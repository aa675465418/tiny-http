<?php

/*
 * This file is part of the Tiny package.
 *
 * (c) Alex Ermashev <alexermashevn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TinyTest\Http;

use PHPUnit\Framework\TestCase;
use Tiny\Http\Exception\InvalidArgumentException;
use Tiny\Http\Request;
use Tiny\Http\RequestSystemParamsInterface;

class RequestTest extends TestCase
{

    public function testGetMethod()
    {
        $method = 'GET';
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getMethod')
            ->willReturn($method);

        $request = new Request($systemParamsMock);

        $this->assertEquals($method, $request->getMethod());
    }

    public function testGetRequestMethod()
    {
        $requestString = '/test';
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getRequest')
            ->willReturn($requestString);

        $request = new Request($systemParamsMock);

        $this->assertEquals($requestString, $request->getRequest());
    }

    public function testGetParamMethod()
    {
        $id = 'test';
        $systemParamsStub = $this->createStub(
            RequestSystemParamsInterface::class
        );

        $request = new Request($systemParamsStub);
        $request->setParams(
            [
                'id' => $id,
            ]
        );
        $this->assertEquals($id, $request->getParam('id'));
    }

    public function testGetParamMethodUsingDefaultValues()
    {
        $id = 'test';
        $systemParamsStub = $this->createStub(
            RequestSystemParamsInterface::class
        );

        $request = new Request($systemParamsStub);
        $request->setParams([]);
        $this->assertEquals($id, $request->getParam('id', $id));
    }

    public function testGetParamMethodUsingNotRegisteredParams()
    {
        $param = 'id';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Request param "%s" not found',
                $param
            )
        );

        $systemParamsStub = $this->createStub(
            RequestSystemParamsInterface::class
        );
        $request = new Request($systemParamsStub);
        $request->setParams([]);
        $request->getParam($param);
    }

}
