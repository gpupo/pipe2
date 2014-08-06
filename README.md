# Pipe2

Convert Google Shopping XML format to [XMLPipe2](http://sphinxsearch.com/docs/current.html#xmlpipe2) format


## Simple usage:

    ./pipe2.phar convert:google data/google-shopping-sample.xml

## Sphinx Search Index Example:

    source xmlSource
    {
        type = xmlpipe
        xmlpipe_command = /usr/local/bin/pipe2 convert:google /tmp/google-shopping-sample.xml
    }


    index xmlIndex
    {
      source = xmlSource
      path = /var/sphinx/xmlIndex
      charset_type = utf-8
      mlock           = 0
      morphology      = none
      enable_star     = 1
      min_prefix_len  = 2
      expand_keywords = 1
      min_word_len    = 2
    }



Test (CentOs sintaxe):

    service searchd start
    /usr/bin/indexer --rotate --all




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

## Todo

- [] convert remote files
- [] deal with unexpected problems
- [] deal with gz compression
- []

## License

MIT, see LICENSE.