<?php

namespace AppTest\Controller;

use Zend\Diactoros\Stream;

class MessageControllerTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        $this->app = new \GianArb\Penny\App();
        $this->app->getContainer()->get("redis")->flushall();
    }

    public function testRateLimit()
    {
        $assertStatusCode = 200;
        $message = [
            "userId" => 1241,
            "currencyFrom" => "EUR",
            "currencyTo" => "GBP",
            "amountSell" => 1000,
            "amountBuy" => 242.10,
            "timePlaced" => "24-JAN-15 10:27:44",
            "originatingCountry" => "IT",
            "rate" => 1,
        ];

        $request = (new \Zend\Diactoros\Request())
            ->withUri(new \Zend\Diactoros\Uri('/message'))
            ->withMethod("POST");

        $stream = new Stream('php://memory', 'wb+');
        $stream->write(json_encode($message));

        $request = $request->withBody($stream);
        $response = new \Zend\Diactoros\Response();

        for ($ii = 1; $ii <= 11; $ii++) {
            $response = $this->app->run($request, $response);
            if ($ii == 11) {
                $assertStatusCode = 429;
            }
            $this->assertEquals($assertStatusCode, $response->getStatusCode(), $ii);
        }
    }

    public function testValidMessage()
    {
        $message = [
            "userId" => 1241,
            "currencyFrom" => "EUR",
            "currencyTo" => "GBP",
            "amountSell" => 1000,
            "amountBuy" => 242.10,
            "timePlaced" => "24-JAN-15 10:27:44",
            "originatingCountry" => "FR",
            "rate" => 1,
        ];

        $request = (new \Zend\Diactoros\Request())
            ->withUri(new \Zend\Diactoros\Uri('/message'))
            ->withMethod("POST");

        $stream = new Stream('php://memory', 'wb+');
        $stream->write(json_encode($message));

        $request = $request->withBody($stream);
        $response = new \Zend\Diactoros\Response();

        $response = $this->app->run($request, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @dataProvider getDraftMessages
     */
    public function testInvalidMessage($message)
    {
        $request = (new \Zend\Diactoros\Request())
            ->withUri(new \Zend\Diactoros\Uri('/message'))
            ->withMethod("POST");

        $stream = new Stream('php://memory', 'wb+');
        $stream->write(json_encode($message));

        $request = $request->withBody($stream);
        $response = new \Zend\Diactoros\Response();

        $response = $this->app->run($request, $response);
        $this->assertEquals(406, $response->getStatusCode());
    }

    public function getDraftMessages()
    {
        return [
            [["rate" => 12]],
            [[
                "userId" => 1241,
                "currencyFrom" => "EUR",
                "amountBuy" => 242.10,
                "timePlaced" => "24-JAN-15 10:27:44",
                "originatingCountry" => "FR",
                "rate" => 1,
            ]],
            //Skipped ZF\Validator bug
            //[[
                //"userId" => 1241,
                //"currencyFrom" => "EUR",
                //"currencyTo" => "GBP",
                //"amountSell" => 1000,
                //"amountBuy" => 242.10,
                //"timePlaced" => "4-JAN-15 10:27:44",
                //"originatingCountry" => "FR",
                //"rate" => 1,
            //]],
            [[
                "userId" => "llsf1241",
                "currencyFrom" => "EUR",
                "currencyTo" => "GBP",
                "amountSell" => 1000,
                "amountBuy" => 242.10,
                "timePlaced" => "24-JAN-15 10:27:44",
                "originatingCountry" => "FR",
                "rate" => 1,
            ]],
            [[
                "userId" => 1241,
                "currencyFrom" => "EUR",
                "currencyTo" => "GBP",
                "amountSell" => 1000,
                "amountBuy" => 242.10,
                "timePlaced" => "24-JAN-15 10:27:44",
                "originatingCountry" => "FR",
                "rate" => "1a",
            ]],
            [[
                "userId" => 1241.1,
                "currencyFrom" => "EUR",
                "currencyTo" => "GBP",
                "amountSell" => 1000,
                "amountBuy" => 242.10,
                "timePlaced" => "24-JAN-15 10:27:44",
                "originatingCountry" => "FR",
                "rate" => 1,
            ]],
        ];
    }
}
