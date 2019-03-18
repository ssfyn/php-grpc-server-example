<?php
/**
 * Created by PhpStorm.
 * User: fanyanan
 * Date: 2019-03-19
 * Time: 00:35
 */

namespace Dev\Fyn;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class HelloWorldClientTest extends TestCase
{

    /** @var Process */
    private static $process;

    public static function setUpBeforeClass(): void
    {
        $code = <<<PHP
require_once('./vendor/autoload.php');
(new Dev\Fyn\Server())->serve();
PHP;
        self::$process = new Process(['php','-r',$code],dirname(__DIR__));
        self::$process->start();
        foreach (self::$process as $type => $data) {
            if (self::$process::OUT === $type) {
                break;
            }
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::$process->stop();
    }

    public function testSayHello()
    {
        $client = new HelloWorldClient('127.0.0.1:50051',['credentials'=>\Grpc\ChannelCredentials::createInsecure()]);
        $request = new SayHelloRequest();
        $request->setName('fyn');
        $call = $client->SayHello($request);
        /** @var SayHelloResponse $response */
        [$response, $status] = $call->wait();
        $this->assertEquals(0, $status->code, sprintf("Call error: %s", $status->details));
        $this->assertEquals("Hi, fyn!", $response->getReply());
    }
}
