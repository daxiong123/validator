<?php

namespace Aichong\tests;

use Aichong\Validator;

class ValidatorTest extends TestCase
{

    public function testRequired()
    {
        $validator = new Validator();
        $validator->validate(['test' => ''], ['test' => 'required'], ['test' => 'empty']);

        $this->assertEquals($validator->message(), 'empty');
    }

    public function testEquals()
    {
        $validator = new Validator();
        $ret = $validator->validate(['test' => '1'], ['test' => 'equals:1'], ['test' => 'noequals']);

        $this->assertTrue($ret);
    }

    public function testLength()
    {
        $validator = new Validator();
        $ret = $validator->validate(['test' => '123'], ['test' => 'length:3'], ['test' => 'nolength']);

        $this->assertTrue($ret);
    }

    public function testUrl()
    {
        $validator = new Validator();
        $validator->validate(['test' => '123'], ['test' => 'url'], ['test' => 'nourl']);

        $this->assertEquals($validator->message(), 'nourl');
    }

    public function testMin()
    {
        $validator = new Validator();
        $ret = $validator->validate(['test' => 5], ['test' => 'min:5'], ['test' => 'nomin']);

        $this->assertTrue($ret);
    }

    public function testMax()
    {
        $validator = new Validator();
        $ret = $validator->validate(['test' => 10], ['test' => 'max:10'], ['test' => 'nomax']);

        $this->assertTrue($ret);
    }

    public function testEmail()
    {
        $validator = new Validator();
        $validator->validate(['test' => 'zhangwj@5ichong'], ['test' => 'email'], ['test' => 'noemail']);

        $this->assertEquals($validator->message(), 'noemail');
    }

    public function testPhone()
    {
        $validator = new Validator();
        $ret = $validator->validate(['test' => '15821789646'], ['test' => 'phone'], ['test' => 'nophone']);

        $this->assertTrue($ret);
    }

    public function testIp()
    {
        $validator = new Validator();
        $ret = $validator->validate(['test' => '192.168.1.1'], ['test' => 'ip'], ['test' => 'noip']);

        $this->assertTrue($ret);
    }

    public function testIdCard()
    {
        $validator = new Validator();
        $validator->validate(['test' => '123456789098765432'], ['test' => 'id_card'], ['test' => 'no_idcard']);

        $this->assertEquals($validator->message(), 'no_idcard');
    }

    public function testJson()
    {
        $validator = new Validator();
        $validator->validate(['test' => '123456789098765432'], ['test' => 'json'], ['test' => 'no_json']);

        $this->assertEquals($validator->message(), 'no_json');

        $ret = $validator->validate(['test' => '{"discount": "0.00"}'], ['test' => 'json'], ['test' => 'no_json']);

        $this->assertTrue($ret);
    }
}