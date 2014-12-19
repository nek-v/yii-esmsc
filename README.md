Yii SMS send extension
=========
[![Latest Stable Version](https://poser.pugx.org/nek-v/yii-esmsc/v/stable.svg)](https://packagist.org/packages/nek-v/yii-esmsc)
[![License](https://poser.pugx.org/nek-v/yii-esmsc/license.svg)](https://packagist.org/packages/nek-v/yii-esmsc)
This extension is designed to send sms messages through different services and protocols.
You can add your providers extending class ```ESMSCProvider```.
See the examples in the directory ```providers```

* [Installation](#installation)
* [Usage](#usage)

### Resources

* Concept and some code: [Yii EAuth](https://github.com/Nodge/yii-eauth)
* [Yii Framework](http://yiiframework.com/)
* [php-smpp](https://github.com/onlinecity/php-smpp)
* [SMPP v3.4](http://opensmpp.org/specs/smppv34_gsmumts_ig_v10.pdf)
* [Kannel](http://www.kannel.org/)

### Requirements

* PHP 5.3+
* Yii 1.1 or above


## Installation
* Configure your composer.json as in the example below

```yaml
...
"require": {
    "nek-v/yii-esmsc": "1.0.0"
}
...
```
* Or extract the files with the extension in the protected/extensions
* In your `protected/config/main.php`, add the following:

```php
<?php
...
'aliases' => array(
    // Path to vendor dir
    'vendor'    => realpath(__DIR__ . '/../vendor'),
),
'import'    => array(
    'vendor.nek-v.yii-esmsc.*',
),
'components'    => array(
    'sms'   => array(
        'class' => 'vendor.nek-v.yii-esmsc.ESMSC',
        'provides'  => array(
            'dummy' => array(
                'class' => 'DummyProvider'
            ),
            'smpp'  => array(
                'class'     => 'SMPPProvider',
                'server'    => 'smpp server',
                'port'      => 'smpp port',
                'login'     => 'smpp login',
                'password'  => 'smpp passwod',
                'source'    => 'sender name'
            )
        )
    )
)
...
```
## Usage

```php
<?php
class SiteController extends CController {
    public function actionIndex() {
        $text = 'Hello world!';
        $phone = '1234567891011';
        $provider = Yii::app()->sms;
        // Dummy
        $provider->getInstance('dummy')->send($phone, $text);
        // SMPP
        $provider->getInstance('smpp')->send($phone, $text);
    }
}
```