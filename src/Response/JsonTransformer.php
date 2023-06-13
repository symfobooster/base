<?php

namespace Symfobooster\Base\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfobooster\Base\Output\OutputInterface;

class JsonTransformer implements TransformerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function transform(OutputInterface $output): Response
    {
        return new JsonResponse(
            $this->serializer->serialize($output->getData(), 'json'),
            $output->getCode(),
            [],
            true
        );
    }
}
