<?php

namespace Symfobooster\Base\Input\Transformer;

use Symfobooster\Base\Input\Transformer\Exception\InvalidTransformerException;
use Symfobooster\Base\Input\Transformer\Exception\TransformersNotFoundException;

class TransformerCollection
{
    private array $collection = [];

    public function __construct(array $transformers)
    {
        foreach ($transformers as $field => $fieldTransformers) {
            if (!is_string($field)) {
                throw new InvalidTransformerException('Keys in a collection must be a request fields');
            }
            if (!is_array($fieldTransformers)) {
                throw new InvalidTransformerException('Transformer collection must be array');
            }
            $this->addTransformers($field, $fieldTransformers);
        }
    }

    private function addTransformers(string $field, array $transformers): void
    {
        foreach ($transformers as $transformer) {
            if (!($transformer instanceof TransformerInterface)) {
                throw new InvalidTransformerException('Transformer must implement TransformerInterface');
            }
            $this->addTransformer($field, $transformer);
        }
    }

    private function addTransformer(string $field, TransformerInterface $transformer): void
    {
        if (!array_key_exists($field, $this->collection)) {
            $this->collection[$field] = [];
        }

        $this->collection[$field][] = $transformer;
    }

    public function getTransformersByField(string $field): array
    {
        if (array_key_exists($field, $this->collection)) {
            return $this->collection[$field];
        }

        throw new TransformersNotFoundException('Transformers not found for this field');
    }
}
