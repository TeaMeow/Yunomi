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

    function testMultipleBasic()
    {
        Yunomi::register('A', 'A');

        $A = Yunomi::get(['A', 'A']);

        $this->assertEquals($A, [new A(), new A()]);
    }

    function testNone()
    {
        $D = Yunomi::get('D');

        $this->assertEquals($D, null);
    }

    function testBasicWithArg()
    {
        Yunomi::register('AA', 'A', ['A']);

        $AA = Yunomi::get('AA');

        $this->assertEquals($AA, new A('A'));
    }

    function testInject()
    {
        $C = Yunomi::inject('AA', 'B', function($aa, $b)
        {
            return new C($aa, $b);
        });

        $this->assertEquals($C, new C(new A('A'), new B()));
    }

    function testResolve()
    {
        $C = Yunomi::resolve('C');

        $this->assertEquals($C, new C(new A('A'), new B()));
    }
}
?>