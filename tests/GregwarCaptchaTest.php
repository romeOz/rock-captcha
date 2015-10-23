<?php

namespace rockunit;


use rock\captcha\GregwarCaptcha;

class GregwarCaptchaTest extends Common
{
    /**
     * @var GregwarCaptcha
     */
    protected $captcha;

    protected function setUp()
    {
        parent::setUp();
        $this->captcha = new GregwarCaptcha();
        $this->captcha->removeSession();
    }


}