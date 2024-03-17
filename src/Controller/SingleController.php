<?php

namespace Symfobooster\Base\Controller;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfobooster\Base\Input\Exception\InvalidBodyException;
use Symfobooster\Base\Output\BadRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Symfobooster\Base\Input\Exception\InvalidInputException;
use Symfobooster\Base\Input\InputLoader;
use Symfobooster\Base\Output\Error;
use Symfobooster\Base\Output\Invalid;
use Symfobooster\Base\Response\JsonTransformer;
use Symfobooster\Base\Service\ServiceInterface;

class SingleController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected InputLoader $inputLoader;
    protected ServiceInterface $service;
    protected JsonTransformer $transformer;

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

    private function getOutput(Request $request): mixed
    {
        try {
            $input = $this->inputLoader->fromRequest($request);

            return $this->service->behave($input);
        } catch (InvalidInputException $exception) {
            return new Invalid($exception->getViolationList());
        } catch (InvalidBodyException $exception) {
            return new BadRequest();
        } catch (Throwable $exception) {
            $this->logger->error($exception);
            return new Error($exception);
        }
    }
}
