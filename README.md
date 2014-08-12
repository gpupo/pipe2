# Pipe2

Convert Google Shopping XML format to [XMLPipe2](http://sphinxsearch.com/docs/current.html#xmlpipe2) format


## Simple usage:

    pipe2 convert data/google-shopping-sample.xml


with channel name:

    pipe2 convert --channel=amazon data/google-shopping-min-sample.xml


Generate blank document with nicely formats output with indentation:

    pipe2 generate --pretty=true


### Samples

This example uses the **input** sample file [data/acme.googleshopping.xml](https://github.com/gpupo/pipe2/blob/master/data/acme.googleshopping.xml)
 and creates the **output** sample file [data/acme.xmlpipe2.xml](https://github.com/gpupo/pipe2/blob/master/data/acme.xmlpipe2.xml):

    pipe2 convert --channel=acme data/acme.googleshopping.xml > data/acme.xmlpipe2.xml

### Sphinx Search Index Example

    source acmeSource
    {
        type = xmlpipe
        xmlpipe_command = /usr/local/bin/pipe2 convert --channel=acme /tmp/data/acme.googleshopping.xml
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


For Sphinx Search config file example, see ``data/sphinx.sample.conf``

## Requirements

- PHP needs to be a minimum version of PHP 5.3.6 and [PHP XML Lib](http://php.net/manual/en/dom.setup.php);
- PHP with 2GB of [memory](http://php.net/memory-limit) or more memory is highly recommended;

## Installation

### Locally

Download the [latest release](https://github.com/gpupo/pipe2/releases/latest) for ``pipe2.phar`` file and store it somewhere on your computer.

### Globally (manual)

You can run these commands to easily access ``pipe2`` from anywhere on
your system:

    $ sudo wget https://github.com/gpupo/pipe2/releases/download/v0.3/pipe2.phar -O /usr/local/bin/pipe2

then:

    $ sudo chmod a+x /usr/local/bin/pipe2

Then, just run ``pipe2``.


# Help

## Available commands

  - convert:    Convert Xml file to xmlpipe2 format
  - generate:   Generate blank Document xmlpipe2 format
  - help:       Displays help for a command
  - list:       Lists commands

## Help Usage:

    pipe2 help convert;
    pipe2 help generate;

## Todo

- [ ] convert remote files
- [ ] deal with unexpected problems
- [ ] deal with gz compression


## License

MIT, see LICENSE.