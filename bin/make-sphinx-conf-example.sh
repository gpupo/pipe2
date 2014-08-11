#!/bin/bash

wget https://raw.githubusercontent.com/gpupo/pipe2/master/data/sphinx.sample.conf -O /etc/sphinx/sphinx.conf;

mkdir -p /tmp/data/;
wget https://raw.githubusercontent.com/gpupo/pipe2/master/data/acme.googleshopping.xml -O /tmp/data/acme.googleshopping.xml;
wget https://raw.githubusercontent.com/gpupo/pipe2/master/data/foo.googleshopping.xml -O /tmp/data/foo.googleshopping.xml;

service searchd stop;
/usr/bin/indexer --rotate --all;
indexer --merge main acmeIndex
indexer --merge main fooIndex
service searchd start;


