#!/bin/bash
# file: https://raw.githubusercontent.com/gpupo/pipe2/master/bin/make-sphinx-conf-example.sh
##

wget https://raw.githubusercontent.com/gpupo/pipe2/master/data/sphinx.sample.conf -O /etc/sphinx/sphinx.conf;

mkdir -p /tmp/data/;
wget https://raw.githubusercontent.com/gpupo/pipe2/master/data/acme.googleshopping.xml -O /tmp/data/acme.googleshopping.xml;
wget https://raw.githubusercontent.com/gpupo/pipe2/master/data/foo.googleshopping.xml -O /tmp/data/foo.googleshopping.xml;

service searchd start;

indexer --rotate --all
indexer --merge main acmeIndex --rotate;
indexer --merge main fooIndex --rotate;

