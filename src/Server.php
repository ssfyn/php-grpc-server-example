<?php
/**
 * Created by PhpStorm.
 * User: fanyanan
 * Date: 2019-03-19
 * Time: 01:24
 */

namespace Dev\Fyn;


/**
 * Class Server
 * @package Dev\Fyn
 * @author fanyanan
 */
class Server
{

    private $server;

    public function __construct($addr='0.0.0.0:50051', array $args =[])
    {
        $this->server = new \Grpc\Server($args);
        $this->server->addHttp2Port($addr);
    }

    public function serve()
    {
        $this->server->start();
        file_put_contents('php://stdout',"Server started\n");
        /** @var \stdClass $request */
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        /** @noinspection PhpParamsInspection */
        while($request = $this->server->requestCall()){

            /** @var string $method */
            $method = $request->method;
            /** @var \Grpc\Call $call */
            $call = $request->call;
//            /** @var string $host */
//            $host = $request->host;
//            /** @var \Grpc\Timeval $deadline */
//            $deadline = $request->absolute_deadline;
//            /** @var array[] $metadata */
//            $metadata = $request->metadata;

            if ($method=='/dev.fyn.HelloWorld/SayHello') {
                $recv = $call->startBatch([
                    \Grpc\OP_RECV_MESSAGE => true
                ]);
                $request = new SayHelloRequest();
                /** @noinspection PhpUndefinedMethodInspection */
                $request->mergeFromString($recv->message);
                $impl = new HelloWorldImpl();
                $response = $impl->sayHello($request);
                /** @noinspection PhpUndefinedMethodInspection */
                $call->startBatch([
                    \Grpc\OP_SEND_INITIAL_METADATA => [],
                    \Grpc\OP_SEND_MESSAGE => [
                        'message'=>$response->serializeToString()
                    ],
                    \Grpc\OP_SEND_STATUS_FROM_SERVER => [
                        'code'=>\Grpc\STATUS_OK,
                        'details'=>'OK'
                    ],
                ]);
            } else {
                /** @noinspection PhpUndefinedMethodInspection */
                $call->startBatch([
                    \Grpc\OP_SEND_INITIAL_METADATA => [],
                    \Grpc\OP_SEND_STATUS_FROM_SERVER => ['code'=>\Grpc\STATUS_NOT_FOUND,'details'=>'Not found'],
                ]);
            }
        }

    }
}