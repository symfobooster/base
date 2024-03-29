<?php

namespace Symfobooster\Base\Input;

use ReflectionAttribute;
use ReflectionClass;
use Symfobooster\Base\Input\Attributes\Muted;
use Symfobooster\Base\Input\Attributes\Renamed;
use Symfobooster\Base\Input\Attributes\Source;
use Symfobooster\Base\Input\Exception\InvalidInputException;
use Symfobooster\Base\Input\Extractor\ExtractorFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InputLoader
{
    private array $fields = [];
    private array $muted = [];
    private array $renamed = [];
    private array $typed = [];

//    private array $transformers = [];

    public function __construct(
        private InputInterface $input,
        private ExtractorFactory $extractorFactory,
        private ValidatorInterface $validator
    ) {
    }

    public function fromRequest(Request $request): InputInterface
    {
        $this->exploreInput($request->getMethod());
        $data = $this->extractData($request);
        $violations = $this->validator->validate($data, $this->input->getValidators());
        if (count($violations) > 0) {
            throw new InvalidInputException($this->filterViolations($violations));
        }
        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
        $serializer = new Serializer([$normalizer]);
        $fileFields = [];
        foreach ($data as $key => $field) {
            if ($data[$key] instanceof UploadedFile) {
                $fileFields[$key] = $field;
                unset($data[$key]);
            }
        }
        $input = $serializer->denormalize($data, get_class($this->input));
        foreach ($fileFields as $key => $field) {
            $input->{$key} = $field;
        }

        return $input;
    }

    private function exploreInput(string $method): void
    {
        $reflection = new ReflectionClass(get_class($this->input));

        foreach ($reflection->getProperties() as $property) {
            $source = $this->getSource($method, $property->getAttributes(Source::class)[0] ?? null);
            $this->fields[$property->getName()] = $source;

            if (!empty($property->getAttributes(Muted::class))) {
                $this->muted[] = $property->getName();
            }

            $renamed = $property->getAttributes(Renamed::class);
            if (!empty($renamed)) {
                $this->renamed[$property->getName()] = $renamed[0]->newInstance()->externalName;
            }
            $this->typed[$property->getName()] = $property->getType()->getName();
            // TODO
//            $transformer = $property->getAttributes(Transformer::class);
//            if (!empty($transformer)) {
//                $this->transformers[$property->getName()] = $transformer[0]->newInstance()->name;
//            }
        }
    }

    private function getSource(string $method, ?ReflectionAttribute $attribute): string
    {
        if (is_null($attribute)) {
            return in_array($method, ['GET', 'DELETE']) ? 'query' : 'body';
        }

        return $attribute->newInstance()->source;
    }

    private function extractData(Request $request): array
    {
        $data = [];
        foreach ($this->fields as $field => $source) {
            $value = $this->extractorFactory->getExtractor($source)->extract(
                $request,
                array_key_exists($field, $this->renamed) ? $this->renamed[$field] : $field
            );
            // TODO
//            if($transformer = $this->transformers[$field]) {
//                $value = $this->transform(new ($this->transformers[$field])(), $value);
//            }
            if (!is_null($value)) {
                $data[$field] = $this->typeIt($value, $this->typed[$field]);
            }
        }

        return $data;
    }

    private function typeIt($value, string $type)
    {
        if (in_array($type, ['string', 'int', 'bool', 'array'])) {
            settype($value, $type);
            return $value;
        }

        return $value;
    }

//    private function transform(TransformerInterface $transformer, mixed $value): mixed
//    {
//        return $transformer->transform($value);
//    }

    private function filterViolations(ConstraintViolationListInterface $violations)
    {
        /** @var ConstraintViolation $violation */
        foreach ($violations as $key => $violation) {
            $field = substr($violation->getPropertyPath(), 1, -1);
            if (in_array($field, $this->muted)) {
                $violations->remove($key);
            }
        }

        return $violations;
    }
}
