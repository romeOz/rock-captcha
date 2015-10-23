Captcha library fo PHP
=================

[![Latest Stable Version](https://poser.pugx.org/romeOz/rock-captcha/v/stable.svg)](https://packagist.org/packages/romeOz/rock-captcha)
[![Total Downloads](https://poser.pugx.org/romeOz/rock-captcha/downloads.svg)](https://packagist.org/packages/romeOz/rock-captcha)
[![Build Status](https://travis-ci.org/romeOz/rock-captcha.svg?branch=master)](https://travis-ci.org/romeOz/rock-captcha)
[![HHVM Status](http://hhvm.h4cc.de/badge/romeoz/rock-captcha.svg)](http://hhvm.h4cc.de/package/romeoz/rock-captcha)
[![Coverage Status](https://coveralls.io/repos/romeOz/rock-captcha/badge.svg?branch=master)](https://coveralls.io/r/romeOz/rock-captcha?branch=master)
[![License](https://poser.pugx.org/romeOz/rock-captcha/license.svg)](https://packagist.org/packages/romeOz/rock-captcha)

Features
-------------------

 * Multi providers
  - [KCaptcha](http://www.captcha.ru/en/kcaptcha/)
  - [GregwarCaptcha](https://github.com/Gregwar/Captcha)
  - [SecurimageCaptcha](https://github.com/dapphp/securimage)
 * Write code to session
 * Standalone module/component for [Rock Framework](https://github.com/romeOz/rock)

Installation
-------------------

From the Command Line:

`composer require romeoz/rock-captcha`

In your composer.json:

```json
{
    "require": {
        "romeoz/rock-captcha": "*"
    }
}
```

Quick Start
-------------------

```php
use rock\captcha\KCaptcha;

$captcha = new KCaptcha();

echo '<img src="' . $captcha->getDataUri() . '">';

$captcha->getCode(); // output: <code>
```

Write to session:

Required install [Rock Session](https://github.com/romeOz/rock-session).

`composer require romeoz/rock-session`

Example:

```php
$config = [
    'session' => new \rock\session\Session
];
$captcha = new KCaptcha($config);

echo '<img src="' . $captcha->getDataUri() . '">';

$captcha->getSession(); // output: <code>
```

Requirements
-------------------
 * **PHP 5.4+**
 * For write code to session required [Rock Session](https://github.com/romeOz/rock-session): `composer require romeoz/rock-session`
 * For using GregwarCaptcha required [gregwar/captcha](https://github.com/Gregwar/Captcha): `composer require gregwar/captcha:1.*`
 * For using SecurimageCaptcha required [dapphp/securimage](https://github.com/dapphp/securimage): `composer require dapphp/securimage:3.6.*` 

>All unbolded dependencies is optional.

License
-------------------

Captcha library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).