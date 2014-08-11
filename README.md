# Pipe2

Convert Google Shopping XML format to [XMLPipe2](http://sphinxsearch.com/docs/current.html#xmlpipe2) format


## Simple usage:

    ./pipe2.phar convert:google data/google-shopping-sample.xml


## Add Channel name

    ./pipe2.phar convert:google --channel=amazon  data/google-shopping-min-sample.xml

### Acme Samples

This example uses the **input** sample file [data/acme.googleshopping.xml](https://github.com/gpupo/pipe2/blob/master/data/acme.googleshopping.xml)
 and creates the **output** sample file [data/acme.xmlpipe2.xml](https://github.com/gpupo/pipe2/blob/master/data/acme.xmlpipe2.xml):

    ./bin/main convert:google --channel=acme --format=true data/acme.googleshopping.xml > data/acme.xmlpipe2.xml


## Sphinx Search Index Example

    source acmeSource
    {
        type = xmlpipe
        xmlpipe_command = /usr/local/bin/pipe2 convert:google --channel=acme /tmp/data/acme.googleshopping.xm
    }

    index acmeIndex
    {
      source = acmeSource
      path = /var/sphinx/acmeIndex
      charset_type = utf-8
      mlock           = 0
      morphology      = none
      enable_star     = 1
      min_prefix_len  = 2
      expand_keywords = 1
      min_word_len    = 2
    }


## Sphinx Search config file

see ``data/sphinx.sample.conf``


## Test

CentOs sintaxe using ``data/sphinx.sample.conf``:


    wget https://raw.githubusercontent.com/gpupo/pipe2/master/data/sphinx.sample.conf -O /etc/sphinx/sphinx.conf;

    mkdir -p /tmp/data/;
    wget https://raw.githubusercontent.com/gpupo/pipe2/master/data/acme.googleshopping.xml -O /tmp/data/acme.googleshopping.xml;
    wget https://raw.githubusercontent.com/gpupo/pipe2/master/data/foo.googleshopping.xml -O /tmp/data/foo.googleshopping.xml;

    /usr/bin/indexer --rotate --all;

    service searchd start;

    search -i acmeIndex anvil
    search -i fooIndex foo

    indexer --merge main fooIndex




    search -i main foo
    search -i main acme

## Requirements

- PHP needs to be a minimum version of PHP 5.3.6 and [PHP XML Lib](http://php.net/manual/en/dom.setup.php);
- PHP with 2GB of [memory](http://php.net/memory-limit) or more memory is highly recommended;

## Installation

### Locally

Download the ``pipe2.phar`` file and store it somewhere on your computer.

### Globally (manual)

You can run these commands to easily access ``pipe2`` from anywhere on
your system:

    $ sudo wget https://github.com/gpupo/pipe2/releases/download/v0.1/pipe2.phar -O /usr/local/bin/pipe2

or with curl:

    $ sudo curl https://github.com/gpupo/pipe2/releases/download/v0.1/pipe2.phar -o /usr/local/bin/pipe2

then:

    $ sudo chmod a+x /usr/local/bin/pipe2

Then, just run ``pipe2``.


## Help usage

    ./pipe2.phar help convert:google

Output:

    Usage:
     convert:google [--output[="..."]] [--channel[="..."]] [--format[="..."]] file

    Arguments:
     file                  Google Xml file path

    Options:
     --output              output filename (default: "stder")
     --channel             channel name for fill channel item field (default: "xml")
     --format              format output (default: false)
     --help (-h)           Display this help message.
     --quiet (-q)          Do not output any message.
     --verbose (-v|vv|vvv) Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
     --version (-V)        Display this application version.
     --ansi                Force ANSI output.
     --no-ansi             Disable ANSI output.
     --no-interaction (-n) Do not ask any interactive question.

## Todo

- [ ] convert remote files
- [ ] deal with unexpected problems
- [ ] deal with gz compression


## License

MIT, see LICENSE.