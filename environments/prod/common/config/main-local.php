<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        /*'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],*/
        'sendGrid' => [
            'class' => 'bryglen\sendgrid\Mailer',
            'apiKey' => getenv('SENDGRID_API_KEY'),
            'viewPath' => '@common/mail',
        ],
    ],
];
