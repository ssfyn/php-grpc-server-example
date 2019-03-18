<?php
/**
 * Created by PhpStorm.
 * User: fanyanan
 * Date: 2019-03-19
 * Time: 00:27
 */

namespace Dev\Fyn;

/**
 * Class HelloWorldImpl
 * @package Dev\Fyn
 * @author fanyanan
 */
class HelloWorldImpl implements HelloWorldInterface
{

    /**
     * Method <code>sayHello</code>
     *
     * @param SayHelloRequest $request
     * @return SayHelloResponse
     */
    public function sayHello(SayHelloRequest $request): SayHelloResponse
    {
        $response = new SayHelloResponse();
        $response->setReply(sprintf("Hi, %s!", $request->getName()));
        return $response;
    }
}