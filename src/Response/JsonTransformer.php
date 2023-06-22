<?php

namespace Symfobooster\Base\Response;

use ReflectionClass;
use Symfobooster\Base\Output\Attributes\OutputMarker;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class JsonTransformer implements TransformerInterface
{
    private SerializerInterface $serializer;
    private array $statuses;

    public function __construct(SerializerInterface $serializer, array $statuses)
    {
        $this->serializer = $serializer;
        $this->statuses = $statuses;
    }

    public function transform(mixed $output): Response
    {
        return new JsonResponse(
            $this->serializer->serialize($output, 'json'),
            $this->getStatus($output),
            [],
            true
        );
    }

    private function getStatus(mixed $output): int
    {
        $reflection = new ReflectionClass(get_class($output));
        foreach ($reflection->getAttributes() as $attribute) {
            $instance = new ($attribute->getName());
            if ($instance instanceof OutputMarker) {
                return $instance->status;
            }
        }

        return 500;
    }
}
