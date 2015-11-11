<?php

namespace rock\captcha;


use Gregwar\Captcha\CaptchaBuilder;

class GregwarCaptcha extends Common implements CaptchaInterface
{
    /**
     * @var CaptchaBuilder
     */
    protected $provider;

    public function init()
    {
        parent::init();

        $this->provider = new CaptchaBuilder($this->generatePhrase());
        if (!empty($this->backgroundColor)) {
            list($red, $green, $blue) = $this->backgroundColor;
            $this->provider->setBackgroundColor($red, $green, $blue);
        }
    }

    /**
     * {@inheritdoc}
     * @return CaptchaBuilder
     */
    public function getProvider()
    {
        return $this->provider;
    }

    protected function generate($generate = false)
    {
        if (!empty($this->data) && $generate === false) {
            return $this->data;
        }
        $this->provider->build($this->width, $this->height);
        $this->code = $this->provider->getPhrase();
        return $this->data = [
            'mimeType' => 'image/jpeg',
            'image' => $this->provider->get($this->quality)
        ];
    }

    /**
     * Generates random phrase of given length with given charset.
     * @return string
     */
    protected function generatePhrase()
    {
        $phrase = '';
        $length = $this->length ? : mt_rand(5, 7);
        $chars = str_split($this->alphabet);

        for ($i = 0; $i < $length; $i++) {
            $phrase .= $chars[array_rand($chars)];
        }

        return $phrase;
    }
}