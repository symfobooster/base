<?php

namespace Symfobooster\Base\Response;

use ReflectionClass;
use Symfobooster\Base\Output\Attributes\OutputMarker;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class JsonTransformer implements TransformerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private string $environment
    ) {
    }

    public function transform(mixed $output): Response
    {
        $status = $this->getStatus($output);

        return new JsonResponse(
            $this->isDisableOutput($status) ? '' : $this->serializer->serialize($output, 'json'),
            $status,
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

    private function isDisableOutput(int $status): bool
    {
        return $status >= 500 && $this->environment === 'prod';
    }
}
