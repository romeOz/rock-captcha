<?php

namespace rock\captcha;


use Gregwar\Captcha\CaptchaBuilder;
use rock\base\ObjectInterface;
use rock\base\ObjectTrait;
use rock\helpers\Instance;

class GregwarCaptcha extends CaptchaBuilder implements ObjectInterface, CaptchaInterface
{
    use ObjectTrait {
        ObjectTrait::__construct as parentConstruct;
    }
    use CommonTrait;

    /**
     * Width image.
     * @var int
     */
    public $width = 160;
    /**
     * Height image.
     * @var int
     */
    public $height = 80;
    /**
     * JPEG quality of image.
     *
     * @var int
     */
    public $quality = 90;

    public $backgroundColor;

    /**
     * Code of captcha.
     *
     * @var string
     */
    protected $code;
    protected $background;
    protected $data;

    public function __construct($config = [])
    {
        parent::__construct();
        $this->parentConstruct($config);
        $this->session = Instance::ensure($this->session, '\rock\session\Session', [], false);
    }

    protected function generate($generate = false)
    {
        if (!empty($this->data) && $generate === false) {
            return $this->data;
        }
        $this->build($this->width, $this->height);

        $this->code = $this->getPhrase();
        return $this->data = [
            'mimeType' => 'image/jpeg',
            'image' => parent::get($this->quality)
        ];
    }
}