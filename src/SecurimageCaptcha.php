<?php

namespace rock\captcha;


use rock\base\ObjectTrait;
use rock\helpers\Instance;
use Securimage_Color;

class SecurimageCaptcha extends \Securimage
{
    use ObjectTrait {
        ObjectTrait::__construct as parentConstruct;
    }

    use CommonTrait;

    /**
     * Captcha image size.
     *
     * @var int
     */
    public $width = 160;
    public $height = 80;
    public $backgroundColor = [255, 255, 255];
    public $length;

    protected $no_session = true;
    protected $no_exit = true;
    protected $send_headers = false;
    protected $gdnoisecolor;
    /**
     * Code of captcha.
     *
     * @var string
     */
    protected $code;
    protected $data;

    public function __construct($config = [])
    {
        $this->parentConstruct($config);

        list($red, $green, $blue) = $this->backgroundColor;
        parent::__construct([
            'image_width' => $this->width,
            'image_height' => $this->height,
            'image_bg_color' => new Securimage_Color($red, $green, $blue),
            'code_length' => isset($this->length) ? $this->length : mt_rand(5, 7)
        ]);
        $this->session = Instance::ensure($this->session, '\rock\session\Session', [], false);
    }

    /**
     * Returns code a captcha.
     *
     * @param bool $generate
     * @return null|string
     */
    public function getCode($generate = false, $returnExisting = false)
    {
        if (!$this->get($generate)) {
            return null;
        }
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    protected function generate($generate = false)
    {
        if (!empty($this->data) && $generate === false) {
            return $this->data;
        }
        switch ($this->image_type) {
            case self::SI_IMAGE_JPEG:
                $this->data['mimeType'] = 'image/jpeg';
                break;
            case self::SI_IMAGE_GIF:
                $this->data['mimeType'] = 'image/gif';
                break;
            default:
                $this->data['mimeType'] = 'image/png';
                break;
        }

        ob_start();
        $this->show();
        $this->data['image'] = ob_get_clean();
        return $this->data;
    }
}