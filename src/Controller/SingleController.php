<?php

namespace Symfobooster\Base\Controller;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Symfobooster\Base\Input\Exception\InvalidInputException;
use Symfobooster\Base\Input\InputLoader;
use Symfobooster\Base\Output\Error;
use Symfobooster\Base\Output\Invalid;
use Symfobooster\Base\Output\OutputInterface;
use Symfobooster\Base\Response\JsonTransformer;
use Symfobooster\Base\Service\ServiceInterface;

class SingleController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private InputLoader $inputLoader;
    private ServiceInterface $service;
    private JsonTransformer $transformer;

    public function __construct(InputLoader $inputLoader, ServiceInterface $service, JsonTransformer $transformer)
    {
        $this->inputLoader = $inputLoader;
        $this->service = $service;
        $this->transformer = $transformer;
    }

    public function action(Request $request): Response
    {
        return $this->transformer->transform(
            $this->getOutput($request)
        );
    }

    private function getOutput(Request $request): OutputInterface
    {
        try {
            $input = $this->inputLoader->fromRequest($request);

            return $this->service->behave($input);
        } catch (InvalidInputException $exception) {
            return new Invalid($exception->getViolationList());
        } catch (Throwable $exception) {
            return new Error($exception);
        }
    }
}
