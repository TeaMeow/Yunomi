<?php
require 'yunomi.php';

class A
{
    function __construct($data = null)
    {
        if($data !== null)
            $this->data = $data;
    }
}

class YunomiTest extends \PHPUnit_Framework_TestCase
{
    function testBasic()
    {
        Yunomi::register('A', 'A');
        
        $A = Yunomi::get('A');
        
        $this->assertEquals($A, new A());
    }
    
    function testBasicWithArg()
    {
        Yunomi::register('A', 'A', ['A']);
        
        $A = Yunomi::get('A');
        
        $this->assertEquals($A, new A('A'));
    }
}
?>