<?php

namespace Zabachok\Symfobooster\Controller;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Zabachok\Symfobooster\Input\Exception\InvalidInputException;
use Zabachok\Symfobooster\Input\InputLoader;
use Zabachok\Symfobooster\Output\Error;
use Zabachok\Symfobooster\Output\Invalid;
use Zabachok\Symfobooster\Output\OutputInterface;
use Zabachok\Symfobooster\Response\JsonTransformer;
use Zabachok\Symfobooster\Service\ServiceInterface;

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
