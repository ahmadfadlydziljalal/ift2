<?php

namespace app\components\helpers;

use app\models\User;
use Yii;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;

class SaveCacheKaryawan
{
    /**
     * @param User $user
     * @return void
     * @throws Exception
     * @throws InvalidConfigException
     */
    public static function saveCache(User $user): void
    {
        $key = 'sihrd-karyawan' . $user->id;
        $sihrdKaryawan = self::createRequest($user->karyawan_id, $user->auth_key);
        $data = is_null($sihrdKaryawan) ? '' : $sihrdKaryawan;
        Yii::$app->cache->set($key, $data, 24 * 60 * 60);
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    private static function createRequest($karyawanId, $authKey)
    {
        $request = (new Client())
            ->createRequest()
            ->setMethod('GET')
            ->setUrl(Yii::$app->params['hrdUrl'] . '/api/karyawans/' . $karyawanId);
        $request->headers->set('Authorization', 'Basic ' . base64_encode($authKey . ":null"));

        $response = $request->send();

        if (!$response->isOk) {
            return null;
        }

        return $response->data;
    }
}