<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Text/Wiki.php';

// class to test the Text_Wiki::transform() with different wiki markups
class Text_Wiki_BugTests extends PHPUnit_Framework_TestCase
{
    protected $wiki;

    protected function setUp()
    {
        $this->wiki = Text_Wiki::factory('Default');
    }

    protected function tearDown()
    {
        unset($this->wiki);
    }

    /**
     * @see http://pear.php.net/bugs/bug.php?id=18289
     */
    public function test18289()
    {
        $text = <<<EOT
* level1
 * level2
* level1
 * level2
EOT;

        $html = $this->wiki->transform($text);

        // strip all whitespace to make assertEquals() easier
        $html = preg_replace('/\s+/','',$html);

        $assertion  = '<ul><li>level1<ul><li>level2</li></ul></li>';
        $assertion .= '<li>level1<ul><li>level2</li></ul></li></ul>';
        $this->assertEquals($assertion, $html);
    }
}