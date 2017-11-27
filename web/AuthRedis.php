<?php
namespace kordar\ams\web;

class AuthRedis
{
    public function load($event)
    {
        /**
         * @var \kordar\ams\models\User $identity
         * @var \yii\redis\Connection $redis
         */
        $identity = $event->identity;
        if ($identity) {
            $redisKey = md5($identity->getAuthToken());
            $attribues = $identity->attributes();

            $redis = \Yii::$app->redis;
            foreach ($attribues as $attribue) {
                $redis->hset($redisKey, $attribue, $identity->$attribue);
            }
            $timeout = $event->duration;
            $redis->expire($redisKey, $timeout);
        }
    }

    public function destroy($token)
    {
        $redisKey = md5($token);
        /**
         * @var \yii\redis\Connection $redis
         */
        $redis = \Yii::$app->redis;

        return $redis->del($redisKey);
    }

    public function getUserInfo($token)
    {
        $redisKey = md5($token);

        /**
         * @var \yii\redis\Connection $redis
         */
        $redis = \Yii::$app->redis;

        if ($redis->exists($redisKey)) {
            return $redis->hmget($redisKey, 'id', 'username', 'email', 'auth_token', 'status', 'created_at', 'updated_at');
        }

        throw new AmsException(50002);
    }
}