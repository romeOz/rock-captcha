<?php

namespace rock\captcha;

/**
 * Interface CaptchaInterface
 * @package rock\captcha
 * @property int $width width image.
 * @property int $height height image.
 * @property array|null backgroundColor
 */
interface CaptchaInterface 
{
    const URL = 1;
    const BASE64 = 2;

    /**
     * Returns data image.
     *
     * @param bool $generate
     * @return array
     */
    public function get($generate = false);

    /**
     * Returns image as base64.
     *
     * @param bool $generate
     * @return null|string
     */
    public function getBase64($generate = false);

    /**
     * Returns image as data-uri.
     * @param bool $generate
     * @return string
     */
    public function getDataUri($generate = false);

    /**
     * Returns code a captcha.
     *
     * @param bool $generate
     * @return null|string
     */
    public function getCode($generate = false);

    /**
     * Returns code a captcha by key.
     *
     * @return string|null
     */
    public function getSession();

    /**
     * Exists session.
     *
     * @return bool
     */
    public function existsSession();

    /**
     * Returns code a captcha and remove session.
     *
     * @return string|null
     */
    public function getAndRemoveSession();

    /**
     * Remove session.
     */
    public function removeSession();
} 