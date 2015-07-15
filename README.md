[![Build Status](https://secure.travis-ci.org/gpupo/pipe2.png?branch=master)](http://travis-ci.org/gpupo/pipe2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gpupo/pipe2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gpupo/pipe2/?branch=master)

# Pipe2

XML command line Tool

## Installation

The *[Pipe2](http://gpupo.github.io/pipe2/)* is a small PHP application that must be installed once in your computer.

Installation on Linux and Mac OS X

```bash

sudo curl -LsS https://github.com/gpupo/pipe2/releases/download/v1.0/pipe2.phar -o /usr/local/bin/pipe2;
sudo chmod a+x /usr/local/bin/pipe2;

```
Installation on Windows

```bat

c:\> php -r "readfile('https://github.com/gpupo/pipe2/releases/download/v1.0/pipe2.phar');" > pipe2

```
Then, just run ``pipe2``.


## Usage

Convert XML file to [XMLPipe2](http://sphinxsearch.com/docs/current.html#xmlpipe2) format;

    pipe2 convert data/google-shopping-sample.xml

with channel name:

    pipe2 convert --channel=amazon data/google-shopping-min-sample.xml


Generate blank document with nicely formats output with indentation:

    pipe2 generate --pretty=true

Merge XML Documents with *Similar Structure* Where Second Document Contains *Attributes*:

    pipe2 merge-attributes data/merge/attributes/firstDocument.xml data/merge/attributes/secondDocument.xml data/merge/attributes/outputDocument.xml


## Available commands


| Command               | Description
| ----------------------|:-------------
| ``convert``           | Convert Xml file to [XMLPipe2](http://sphinxsearch.com/docs/current.html#xmlpipe2) format
| ``merge-attributes``  | Merge XML Documents with *Similar Structure* Where Second Document Contains *Attributes*
| ``generate``          | Generate blank Document xmlpipe2 format
| ``list``              | Lists commands
| ``help``              | Displays help for a command

## Help

Displays help for a command

```bash

pipe2 help convert;
pipe2 help generate;

```
### Samples

This example uses the **input** sample file [data/acme.googleshopping.xml](https://github.com/gpupo/pipe2/blob/master/data/acme.googleshopping.xml)
 and creates the **output** sample file [data/acme.xmlpipe2.xml](https://github.com/gpupo/pipe2/blob/master/data/acme.xmlpipe2.xml):

    pipe2 convert --channel=acme data/acme.googleshopping.xml > data/acme.xmlpipe2.xml

### Sphinx Search Index Example

```bash

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
```

For Sphinx Search config file example, see ``data/sphinx.sample.conf``

## Requirements

- PHP needs to be a minimum version of PHP 5.4 and [PHP XML Lib](http://php.net/manual/en/dom.setup.php);
- PHP with 2GB of [memory](http://php.net/memory-limit) or more memory is highly recommended;

## Todo

- [ ] convert remote files
- [ ] deal with ``gz`` compression
- [ ] ``merge-elements``: Merge XML Documents with Similar Structure Where Second Document Contains Additional Elements

## License

MIT, see LICENSE.

[Latest release](https://github.com/gpupo/pipe2/releases/latest)
[Website](http://gpupo.github.io/pipe2/)
