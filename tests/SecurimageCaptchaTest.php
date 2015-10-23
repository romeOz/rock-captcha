<?php

namespace rockunit;


use rock\captcha\SecurimageCaptcha;

class SecurimageCaptchaTest extends Common
{
    /**
     * @var SecurimageCaptcha
     */
    protected $captcha;

    protected function setUp()
    {
        parent::setUp();
        $this->captcha = new SecurimageCaptcha();
        $this->captcha->removeSession();
    }

    public function testGet()
    {
        $data = $this->captcha->get();
        $this->assertSame('image/png', $data['mimeType']);
        $this->assertNotEmpty($data['image']);
    }
}