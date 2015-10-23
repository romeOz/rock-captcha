<?php

namespace rockunit;


use rock\captcha\KCaptcha;

class KCaptchaTest extends Common
{
    /**
     * @var KCaptcha
     */
    protected $captcha;

    protected function setUp()
    {
        parent::setUp();
        $this->captcha = new KCaptcha();
        $this->captcha->removeSession();
    }
}