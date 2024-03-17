<?php

namespace Symfobooster\Base\Tests\Controller;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfobooster\Base\Controller\SingleController;
use Symfobooster\Base\Input\EmptyInput;
use Symfobooster\Base\Input\Exception\InvalidBodyException;
use Symfobooster\Base\Input\Exception\InvalidInputException;
use Symfobooster\Base\Input\InputLoader;
use Symfobooster\Base\Output\BadRequest;
use Symfobooster\Base\Output\CreatedIdString;
use Symfobooster\Base\Output\Error;
use Symfobooster\Base\Output\Invalid;
use Symfobooster\Base\Output\InvalidHelper;
use Symfobooster\Base\Response\JsonTransformer;
use Symfobooster\Base\Service\ServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SingleControllerTest extends TestCase
{
    public function testSuccess(): void
    {
        $inputLoader = $this->createStub(InputLoader::class);
        $service = $this->createStub(ServiceInterface::class);
        $transformer = $this->createStub(JsonTransformer::class);

        $request = new Request();
        $input = new EmptyInput();
        $output = new CreatedIdString('test-id');
        $inputLoader->expects($this->once())
            ->method('fromRequest')
            ->with($request)
            ->willReturn($input);

        $service->expects($this->once())
            ->method('behave')
            ->with($input)
            ->willReturn($output);
        $res = new JsonResponse();
        $transformer->expects($this->once())
            ->method('transform')
            ->with($output)
            ->willReturn($res);

        $controller = new SingleController($inputLoader, $service, $transformer);
        $response = $controller->action($request);

        $this->assertEquals($res, $response);
    }

    public function testBadBody(): void
    {
        $inputLoader = $this->createStub(InputLoader::class);
        $service = $this->createStub(ServiceInterface::class);
        $transformer = $this->createStub(JsonTransformer::class);

        $request = new Request();
        $input = new EmptyInput();
        $output = new BadRequest();
        $inputLoader->expects($this->once())
            ->method('fromRequest')
            ->will($this->throwException(new InvalidBodyException()));

        $service->expects($this->never())
            ->method('behave')
            ->with($input)
            ->willReturn($output);
        $expectedResponse = new JsonResponse();
        $transformer->expects($this->once())
            ->method('transform')
            ->with($output)
            ->willReturn($expectedResponse);

        $controller = new SingleController($inputLoader, $service, $transformer);
        $response = $controller->action($request);

        $this->assertEquals($expectedResponse, $response);
    }

    public function testError(): void
    {
        $inputLoader = $this->createStub(InputLoader::class);
        $service = $this->createStub(ServiceInterface::class);
        $transformer = $this->createStub(JsonTransformer::class);
        $logger = $this->createStub(LoggerInterface::class);

        $request = new Request();
        $input = new EmptyInput();
        $exception = new Exception();
        $output = new Error($exception);
        $inputLoader->expects($this->once())
            ->method('fromRequest')
            ->will($this->throwException($exception));

        $service->expects($this->never())
            ->method('behave');
        $expectedResponse = new JsonResponse();
        $transformer->expects($this->once())
            ->method('transform')
            ->with($output)
            ->willReturn($expectedResponse);
        $logger->expects($this->once())
            ->method('error')
            ->with($exception);

        $controller = new SingleController($inputLoader, $service, $transformer);
        $controller->setLogger($logger);
        $response = $controller->action($request);

        $this->assertEquals($expectedResponse, $response);
    }

    // TODO
//    public function testInvalidInput(): void
//    {
//        $inputLoader = $this->createStub(InputLoader::class);
//        $service = $this->createStub(ServiceInterface::class);
//        $transformer = $this->createStub(JsonTransformer::class);
//
//        $request = new Request();
//        $input = new EmptyInput();
////        $output = new Invalid();
//        $exception = new InvalidInputException((new InvalidHelper())->only('key', 'message'));
//        $inputLoader->expects($this->once())
//            ->method('fromRequest')
//            ->will($this->throwException($exception));
//
//        $service->expects($this->never())
//            ->method('behave');
//        $expectedResponse = new JsonResponse();
//        $transformer->expects($this->once())
//            ->method('transform')
//            ->with($output)
//            ->willReturn($expectedResponse);
//
//        $controller = new SingleController($inputLoader, $service, $transformer);
//        $response = $controller->action($request);
//
//        $this->assertEquals($expectedResponse, $response);
//    }
}