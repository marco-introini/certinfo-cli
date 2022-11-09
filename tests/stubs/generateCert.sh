#!/bin/zsh

if [[ -z $1 ]]; then
  echo "Please pass the CN"
  exit
fi

openssl genrsa -out "$1".pem 2048
openssl req -new -key "$1".pem -out req_"$1".pem -subj "/C=IT/ST=Italy/L=Milan/O=MintDev/OU=MintDev/CN=$1"
openssl req -x509 -key "$1".pem -in req_"$1".pem -out "$1"_PUBLIC.pem -days 3650
openssl pkcs12 -export -out "$1".pfx -inkey "$1".pem -in "$1"_PUBLIC.pem -passout pass:"$1"
zip -j "$1".zip "$1".pem "$1"_PUBLIC.pem "$1".pfx
rm -f req_"$1".pem