info:
	echo "Makefile for certinfo"

build:
	php certinfo app:build certinfo

test:
	./vendor/bin/pest