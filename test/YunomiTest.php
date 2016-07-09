<?php
require 'yunomi.php';

class A
{
}

class YunomiTest extends \PHPUnit_Framework_TestCase
{
    function testA()
    {
        Yunomi::register('A', 'A');
        
        $A = Yunomi::get('A');
        
        $this->assertEquals($A, new A());
    }
}
?>