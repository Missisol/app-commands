<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/verifyNewEmail', 'token' => $user->verify_new_email_token]);
?>
Привет, <?= $user->login ?>,

Для подтверждения своего нового email перейдите по ссылке:

<?= $verifyLink ?>
