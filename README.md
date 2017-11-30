AMS
===
AMS

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist kordar/ams "*"
```

or add

```
"kordar/ams": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \kordar\ams\AutoloadExample::widget(); ?>
```

Config
-----

Mailer

```php
'mailer' => [
    'class' => 'yii\swiftmailer\Mailer',
    'viewPath' => '@kordar/ams/mail',
    // send all mails to a file by default. You have to set
    // 'useFileTransport' to false and configure a transport
    // for the mailer to send real emails.
    'useFileTransport' => false,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        //我用的是QQ 的代理，所以这里是 QQ 的配置信息
        'host' => 'smtp.qq.com',
        'port' => 587,
        'encryption' => 'tls',
        //这部分信息不应该公开，所以后期会由数据库中拿取
        'username' => '605205796',
        'password' => 'fjpouagngihgbbbe',
    ],

    //发送的邮件信息配置
    'messageConfig' => [

        'charset' => 'utf-8',

        'from' => ['605205796@qq.com' => '阿毛']
    ],
]
```







