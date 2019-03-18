# PHP gRPC Server Example

This is a simple demo, used to demonstrate how to use PHP as a gRPC service.

## 0. Prepare
When these installations encounter problems, please refer to: https://grpc.io/docs/quickstart/php.html    

### Install protoc
```bash
git clone -b $(curl -L https://grpc.io/release) https://github.com/grpc/grpc
cd grpc
git submodule update --init
make
sudo make install
```

### Install PHP Protoc plugin
```bash
git clone -b $(curl -L https://grpc.io/release) https://github.com/grpc/grpc
cd grpc
git submodule update --init
make grpc_php_plugin
```

### Install ext-protobuf
```bash
pecl install protobuf
```

### Install ext-grpc
```bash
pecl install ext-grpc
```

## 1. Init project

### Composer
```bash
composer install
```

### Protoc
```bash
protoc --php_out=./pb-src --grpc_out=./pb-src --plugin=protoc-gen-grpc=$(which grpc_php_plugin) ./protos/HelloWorld.proto
```

## 2. Startup server
```php
require_once __DIR__.'/vendor/autoload.php';

$server = new \Dev\Fyn\Server('0.0.0.0:50051');
$server->serve();
```

## 3. Using client call gRPC Service
```php
require_once __DIR__.'/vendor/autoload.php';

$client = new HelloWorldClient('127.0.0.1:50051',[
    'credentials'=>\Grpc\ChannelCredentials::createInsecure()
]);

$request = new SayHelloRequest();
$request->setName('fyn');

$call = $client->SayHello($request);
[$response, $status] = $call->wait();

echo "Code: ", $status->code,"\n";
echo "Details: ", $status->details,"\n";
echo "Reply: ", ($response?$response->getReply():null),"\n";
```
