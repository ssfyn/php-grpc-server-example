<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Dev\Fyn;

/**
 */
class HelloWorldClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Dev\Fyn\SayHelloRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SayHello(\Dev\Fyn\SayHelloRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/dev.fyn.HelloWorld/SayHello',
        $argument,
        ['\Dev\Fyn\SayHelloResponse', 'decode'],
        $metadata, $options);
    }

}
