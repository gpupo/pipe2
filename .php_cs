<?php

use Symfony\CS\Config\Config;
use Symfony\CS\FixerInterface;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\Fixer\Contrib\HeaderCommentFixer;


$header = <<<EOF
This file is part of gpupo/pipe2

(c) Gilmar Pupo <contact@gpupo.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.

For more information, see
<https://opensource.gpupo.com/pipe2/>.

EOF;

HeaderCommentFixer::setHeader($header);

$finder = DefaultFinder::create()
    ->notName('LICENSE')
    ->notName('README.md')
    ->notName('.php_cs')
    ->notName('composer.*')
    ->notName('phpunit.xml*')
    ->notName('*.phar')
    ->exclude('vendor')
    ->exclude('data')
    ->in(__DIR__);

return Config::create()
    ->fixers(array(
        '-yoda_conditions',
        'align_double_arrow',
        'header_comment',
        'multiline_spaces_before_semicolon',
        'no_blank_lines_before_namespace',
        'ordered_use',
        'phpdoc_order',
        'phpdoc_var_to_type',
        'strict',
        'strict_param',
        'short_array_syntax',
    ))
    ->level(FixerInterface::SYMFONY_LEVEL)
    ->setUsingCache(false)
    ->finder($finder);
