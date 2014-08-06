# Pipe2

Convert Google Shopping XML format to [XMLPipe2](http://sphinxsearch.com/docs/current.html#xmlpipe2) format


## Simple usage:

    ./pipe2.phar convert:google data/google-shopping-sample.xml

## Sphinx Search Index Example:

source xml
{
    type = xmlpipe
    xmlpipe_command = /usr/local/bin/pipe2 convert:google data/google-shopping-sample.xml
}

## Requirements

PHP needs to be a minimum version of PHP 5.3.6

## Installation

### Locally

Download the `pipe2.phar`_ file and store it somewhere on your computer.

### Globally (manual)

You can run these commands to easily access ``pipe2`` from anywhere on
your system:

    $ sudo wget https://github.com/gpupo/pipe2/releases/download/v0.1/pipe2.phar -O /usr/local/bin/pipe2

or with curl:

    $ sudo curl https://github.com/gpupo/pipe2/releases/download/v0.1/pipe2.phar -o /usr/local/bin/pipe2

then:

    $ sudo chmod a+x /usr/local/bin/pipe2

Then, just run ``pipe2``.

## License

MIT, see LICENSE.