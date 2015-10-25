<?php

namespace rock\captcha;


use rock\helpers\Instance;
use Securimage;
use Securimage_Color;

class SecurimageCaptcha extends Common implements CaptchaInterface
{
    /**
     * @var \Securimage
     */
    protected $provider;

    public function init()
    {
        $this->session = Instance::ensure($this->session, '\rock\session\Session', [], false);
        if (empty($this->backgroundColor)) {
            $this->backgroundColor = [mt_rand(220, 255), mt_rand(220, 255), mt_rand(220, 255)];
        }
        list($red, $green, $blue) = $this->backgroundColor;
        $this->provider = new Securimage([
            'image_width' => $this->width,
            'image_height' => $this->height,
            'image_bg_color' => new Securimage_Color($red, $green, $blue),
            'code_length' => $this->length ? : mt_rand(5, 7),
            'charset' => $this->charset,
            'no_session' => true,
            'no_exit' => true,
            'send_headers' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     * @return Securimage
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @inheritdoc
     */
    protected function generate($generate = false)
    {
        if (!empty($this->data) && $generate === false) {
            return $this->data;
        }
        switch ($this->provider->image_type) {
            case Securimage::SI_IMAGE_JPEG:
                $this->data['mimeType'] = 'image/jpeg';
                break;
            case Securimage::SI_IMAGE_GIF:
                $this->data['mimeType'] = 'image/gif';
                break;
            default:
                $this->data['mimeType'] = 'image/png';
                break;
        }

        ob_start();
        $this->provider->show();
        $this->data['image'] = ob_get_clean();
        $this->code = $this->provider->getCode([], true);
        return $this->data;
    }
}