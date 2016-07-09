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

class B
{
    function __construct($data = null)
    {
        if($data !== null)
            $this->data = $data;
    }
}

class C
{
    function __construct(A $a, B $b)
    {
        $this->a = $a;
        $this->b = $b;
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
    
    function testResolve()
    {
        $C = Yunomi::inject('A', 'B', function($a, $b)
        {
            return new C($a, $b);
        });
        
        $this->assertEquals($C, new C(new A('A'), new B()));
    }
}
?>