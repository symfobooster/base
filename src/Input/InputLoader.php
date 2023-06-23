<?php

namespace Symfobooster\Base\Input;

use ReflectionAttribute;
use ReflectionClass;
use Symfobooster\Base\Hydrator;
use Symfobooster\Base\Input\Attributes\Muted;
use Symfobooster\Base\Input\Attributes\Renamed;
use Symfobooster\Base\Input\Attributes\Source;
use Symfobooster\Base\Input\Exception\InvalidInputException;
use Symfobooster\Base\Input\Extractor\ExtractorFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InputLoader
{
    private InputInterface $input;
    private ExtractorFactory $extractorFactory;
    private ValidatorInterface $validator;
    private array $fields = [];
    private array $muted = [];
    private array $renamed = [];
    private array $typed = [];

//    private array $transformers = [];

    public function __construct(
        InputInterface $input,
        ExtractorFactory $extractorFactory,
        ValidatorInterface $validator
    ) {
        $this->input = $input;
        $this->extractorFactory = $extractorFactory;
        $this->validator = $validator;
    }

    public function fromRequest(Request $request): InputInterface
    {
        $this->exploreInput($request->getMethod());
        $data = $this->extractData($request);

        $violations = $this->validator->validate($data, $this->input->getValidators());
        if (count($violations) > 0) {
            throw new InvalidInputException($this->filterViolations($violations));
        }

        $hydrator = new Hydrator();
        $hydrator->hydrate($this->input, $data);

        return $this->input;
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
            return $method === 'GET' ? 'query' : 'body';
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
