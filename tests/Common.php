<?php
namespace rockunit;

abstract class Common extends \PHPUnit_Framework_TestCase
{
    protected $captcha;

    public function testGet()
    {
        $data = $this->captcha->get();
        $this->assertSame('image/jpeg', $data['mimeType']);
        $this->assertNotEmpty($data['image']);
    }

    public function testGetDataUri()
    {
        $this->assertNotEmpty($this->captcha->getDataUri());
    }

    public function testGetBase64()
    {
        $this->assertNotEmpty($this->captcha->getBase64());
    }

    public function testGetCode()
    {
        $this->assertNotEmpty($this->captcha->getCode());
    }

    public function testGetSession()
    {
        $this->assertSame($this->captcha->getCode(), $this->captcha->getSession());
    }

    public function testExistsSession()
    {
        $this->assertFalse($this->captcha->existsSession());
        $this->captcha->getCode();
        $this->assertTrue($this->captcha->existsSession());
    }

    public function testGetAndRemoveSession()
    {
        $code = $this->captcha->getCode();
        $this->assertTrue($this->captcha->existsSession());
        $this->assertSame($code, $this->captcha->getAndRemoveSession());
        $this->assertFalse($this->captcha->existsSession());
    }
}