<?php

namespace rock\captcha;


use rock\base\ObjectInterface;
use rock\base\ObjectTrait;
use rock\helpers\Instance;
use rock\session\Session;
use rock\session\SessionInterface;


abstract class Common implements ObjectInterface
{
    use ObjectTrait {
        ObjectTrait::__construct as parentConstruct;
    }
    /**
     * The length of the captcha code.
     * @var int
     */
    public $length;
    /**
     * Allowed character for generating the captcha code.
     * @var string
     */
    public $alphabet = 'ABCDEFGHKLMNPRSTUVWYZabcdefghklmnprstuvwyz23456789';
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
    public $backgroundColor = [];
    /** @var  Session */
    public $session = 'session';
    /**
     * @var string the name of the session key. Defaults to `_captcha`.
     */
    public $sessionKey = '_captcha';
    /**
     * Code of captcha.
     *
     * @var string
     */
    protected $code;
    protected $data;

    public function init()
    {
        $this->session = Instance::ensure($this->session, '\rock\session\Session', [], false);
    }

    /**
     * Returns a data image.
     * @param bool $generate
     * @return array
     */
    public function get($generate = false)
    {
        if (!$data = $this->generate($generate)) {
            return [];
        }

        if ($this->session instanceof SessionInterface) {
            $this->writeSession($this->code);
        }

        return $data;
    }

    /**
     * Returns a image as base64.
     * @param bool $generate
     * @return null|string
     */
    public function getBase64($generate = false)
    {
        if (!$data = $this->get($generate)) {
            return null;
        }

        return base64_encode($data['image']);
    }

    /**
     * Returns a image as data-uri.
     * @param bool $generate
     * @return string
     */
    public function getDataUri($generate = false)
    {
        if (!$hash = $this->getBase64($generate)) {
            return null;
        }
        return 'data:image/png;base64,' . $hash;
    }

    /**
     * Returns code a captcha.
     * @param bool $generate
     * @return null|string
     */
    public function getCode($generate = false)
    {
        if (!$this->get($generate)) {
            return null;
        }
        return $this->code;
    }

    /**
     * Returns code a captcha by key.
     * @return string|null
     */
    public function getSession()
    {
        return $this->session->getFlash($this->sessionKey);
    }

    /**
     * Exists session.
     * @return bool
     */
    public function existsSession()
    {
        return $this->session->hasFlash($this->sessionKey);
    }
    /**
     * Returns code a captcha and remove session.
     * @return string|null
     */
    public function getAndRemoveSession()
    {
        $result = $this->session->getFlash($this->sessionKey);
        $this->removeSession();
        return $result;
    }

    /**
     * Removes a session.
     */
    public function removeSession()
    {
        $this->session->removeFlash($this->sessionKey);
    }

    /**
     * Writes a code to session.
     * @param string $code
     */
    protected function writeSession($code)
    {
        $this->session->setFlash($this->sessionKey, $code, false);
    }

    /**
     * Generate image.
     * @param bool $generate
     * @return array
     */
    abstract protected function generate($generate);
}