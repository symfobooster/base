<?php

namespace Symfobooster\Base\Response;

use Symfobooster\Base\Output\OutputInterface;
use Symfobooster\Base\Output\Success;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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

    public function transform(OutputInterface $output): Response
    {
        return new JsonResponse(
            $this->serializer->serialize($output, 'json'),
            $this->getCode($output),
            [],
            true
        );
    }

    private function getCode(OutputInterface $output): int
    {
        foreach ($this->statuses as $class => $status) {
            if ($output instanceof $class) {
                return $status;
            }
        }

        return 500;
    }
}
