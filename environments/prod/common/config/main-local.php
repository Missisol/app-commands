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
            'username' => 'your_user_name',
            'password' => 'your password here',
            'viewPath' => '@common/mail',
        ],
    ],
];
