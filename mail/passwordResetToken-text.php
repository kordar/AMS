<?php

/* @var $this yii\web\View */
/* @var $user kordar\ams\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/ams/auth/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>

Follow the link below to reset your password:

<?= $resetLink ?>
