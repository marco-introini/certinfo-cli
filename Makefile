info:
	echo "Makefile for certinfo"

build:
	php certinfo app:build certinfo

test:
	cd tests/stubs && ./generateCert.sh Example && cd -
	./vendor/bin/pest