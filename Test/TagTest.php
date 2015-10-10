<?php

namespace Tale\Jade\Test;

use Tale\Jade\Compiler;

class TagTest extends \PHPUnit_Framework_TestCase
{

    /** @var \Tale\Jade\Compiler */
    private $_compiler;

    public function setUp()
    {

        $this->_compiler = new Compiler([
            'pretty' => false,
            'handleErrors' => false
        ]);
    }

    public function testTag()
    {

        $this->assertEquals('<p>Test</p>', $this->_compiler->compile('p Test'));
    }

    public function testTagChars()
    {

        $this->assertEquals(
            '<abcdefghijklmnopqrstuvwxyz-_ABCDEFGHIJKLMNOPQRSTUVWXYZ>Test</abcdefghijklmnopqrstuvwxyz-_ABCDEFGHIJKLMNOPQRSTUVWXYZ>',
            $this->_compiler->compile('abcdefghijklmnopqrstuvwxyz-_ABCDEFGHIJKLMNOPQRSTUVWXYZ Test')
        );
    }

    public function testNamespacedTag()
    {

        $this->assertEquals(
            '<a:b>Test</a:b>',
            $this->_compiler->compile('a:b Test')
        );

        $this->assertEquals(
            '<a-b:c-d>Test</a-b:c-d>',
            $this->_compiler->compile('a-b:c-d Test')
        );
    }

    public function testNestedTag()
    {

        $jade = <<<JADE
p
    a Test
JADE;

        $this->assertEquals('<p><a>Test</a></p>', $this->_compiler->compile($jade));
    }

    public function testComplexNestedTag()
    {

        $jade = <<<JADE
div
    nav
        ul
            li
                a
            li
                a
            li
                a
    nav
        ul
            li
                a
            li
                a
            li
                a
    nav
        ul
            li
                a
            li
                a
            li
                a
JADE;

        $this->assertEquals('<div><nav><ul><li><a></a></li><li><a></a></li><li><a></a></li></ul></nav><nav><ul><li><a></a></li><li><a></a></li><li><a></a></li></ul></nav><nav><ul><li><a></a></li><li><a></a></li><li><a></a></li></ul></nav></div>', $this->_compiler->compile($jade));
    }
}