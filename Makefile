GRPC_PLUGIN := $(shell which grpc_php_plugin)
OUTPUT = ${PWD}/pb-src

all: install clean-grpc grpc-with-client test

install:
	composer install

grpc:
	if [ ! -d ${OUTPUT} ]; then mkdir ${OUTPUT}; fi
	protoc --php_out ${OUTPUT} ./protos/HelloWorld.proto

grpc-with-client:
	if [ ! -d ${OUTPUT} ]; then mkdir ${OUTPUT}; fi
	protoc --php_out ${OUTPUT} --grpc_out=${OUTPUT} --plugin=protoc-gen-grpc=${GRPC_PLUGIN} ./protos/HelloWorld.proto

clean-grpc:
	rm -rf ${OUTPUT}/*

test:
	${PWD}/vendor/bin/phpunit --configuration ${PWD}/phpunit.xml.dist