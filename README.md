[![Build Status](https://secure.travis-ci.org/gpupo/pipe2.png?branch=master)](http://travis-ci.org/gpupo/pipe2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gpupo/pipe2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gpupo/pipe2/?branch=master)

# Pipe2

XML command line Tool

## Installation

The *[Pipe2](http://www.g1mr.com/pipe2/)* is a small PHP application that must be installed once in your computer.

Installation on Linux and Mac OS X

    sudo curl -LsS https://github.com/gpupo/pipe2/releases/download/v1.1/pipe2.phar -o /usr/local/bin/pipe2;
    sudo chmod a+x /usr/local/bin/pipe2;


Installation on Windows

    c:\> php -r "readfile('https://github.com/gpupo/pipe2/releases/download/v1.1/pipe2.phar');" > pipe2

Then, just run ``pipe2``.

![screen shot main](http://www.g1mr.com/pipe2/asset/screen-shot-main.png)

## Usage

Convert XML file to [XMLPipe2](http://sphinxsearch.com/docs/current.html#xmlpipe2) format;

    pipe2 convert data/acme.googleshopping.xml

>    This example uses the **input** sample file [data/acme.googleshopping.xml](https://github.com/gpupo/pipe2/blob/master/data/acme.googleshopping.xml)

Merge XML Documents with *Similar Structure* Where Second Document Contains *Attributes*:

    pipe2 merge-attributes data/acme.googleshopping.xml data/merge/attributes/secondDocument.xml --idField="g:id" --pretty=true

>  This example uses the **input** sample files [data/acme.googleshopping.xml](https://github.com/gpupo/pipe2/blob/master/data/acme.googleshopping.xml)
>  and [data/merge/attributes/secondDocument.xml](https://github.com/gpupo/pipe2/blob/master/data/merge/attributes/secondDocument.xml)
>  and creates the **output** sample file [data/merge/attributes/output.xml](https://github.com/gpupo/pipe2/blob/master/data/merge/attributes/output.xml):


### Advanced

with channel name:

    pipe2 convert --channel=amazon data/acme.googleshopping.xml

Generate blank document with nicely formats output with indentation:

    pipe2 generate --pretty=true


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

    pipe2 help convert;
    pipe2 help generate;

![screen-shot-help-convert](http://www.g1mr.com/pipe2/asset/screen-shot-help-convert.png)

![screen-shot-help-attributes](http://www.g1mr.com/pipe2/asset/screen-shot-help-attributes.png)

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

- PHP needs to be a minimum version of PHP 5.4 and [PHP XML Lib](http://php.net/manual/en/dom.setup.php);
- PHP with 2GB of [memory](http://php.net/memory-limit) or more memory is highly recommended;

## Todo

- [ ] convert remote files
- [ ] deal with ``gz`` compression
- [ ] ``merge-elements``: Merge XML Documents with Similar Structure Where Second Document Contains Additional Elements

## License

MIT, see [LICENSE](https://github.com/gpupo/pipe2/blob/master/LICENSE).

---

[Website](http://www.g1mr.com/pipe2/) | [Latest release](https://github.com/gpupo/pipe2/releases/latest)

<!--
# How rebuild website from README.md

    mkdir -p _site/; cp README.md _site/;
    git checkout gh-pages;
    cat _includes/init.md _site/README.md > index.md
    git commit -am 'Automatic Rebuild index from README.md';
    git push; git checkout master;
-->
