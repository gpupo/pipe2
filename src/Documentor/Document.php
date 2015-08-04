<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For more information, see
 * <http://www.g1mr.com/pipe2/>.
 */

namespace Gpupo\Pipe2\Documentor;

use Gpupo\Pipe2\DocumentInterface;
use Twig_Environment;
use Twig_Loader_String;

class Document implements DocumentInterface
{
    public $formatOutput;

    public function render($list)
    {
        $loader = new Twig_Loader_String();
        $twig = new Twig_Environment($loader);
        $output = '#API Docs'."\n\n";
        foreach ($list as $key => $data) {
            $output .= $twig->render(file_get_contents(__DIR__.'/view.md'), $data);
        }

        return $output;
    }
}
