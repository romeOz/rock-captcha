<?php

namespace rock\captcha;


use rock\session\Session;
use rock\session\SessionInterface;


trait CommonTrait
{
    /** @var  Session */
    public $session = 'session';
    /**
     * @var string the name of the session key. Defaults to `_captcha`.
     */
    public $sessionKey = '_captcha';

    /**
     * Returns data image.
     *
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
     * Returns image as base64.
     *
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
     * Returns image as data-uri.
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
     *
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
     *
     * @return string|null
     */
    public function getSession()
    {
        return $this->session->getFlash($this->sessionKey);
    }

    /**
     * Exists session.
     *
     * @return bool
     */
    public function existsSession()
    {
        return $this->session->hasFlash($this->sessionKey);
    }
    /**
     * Returns code a captcha and remove session.
     *
     * @return string|null
     */
    public function getAndRemoveSession()
    {
        $result = $this->session->getFlash($this->sessionKey);
        $this->removeSession();
        return $result;
    }

    /**
     * Remove session.
     */
    public function removeSession()
    {
        $this->session->removeFlash($this->sessionKey);
    }

    /**
     * Write code to session.
     * @param string $code
     */
    protected function writeSession($code)
    {
        $this->session->setFlash($this->sessionKey, $code, false);
    }

    /**
     * Generate image.
     *
     * @param bool $generate
     * @return array
     */
    abstract protected function generate($generate);
}