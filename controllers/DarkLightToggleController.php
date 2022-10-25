<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class DarkLightToggleController extends Controller
{

    /**
     * @return string[]
     */
    public function actionIndex(): array
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_COOKIE['theme'])) {

            if ($_COOKIE['theme'] === 'dark') {
                $theme = 'light';
                $themeAttribute = 'bg-light text-dark';
            } else {
                $theme = 'dark';
                $themeAttribute = 'bg-dark text-light';
            }

        } else {
            $theme = 'dark';
            $themeAttribute = 'bg-dark text-light';
        }

        setrawcookie('theme', urlencode($theme), [
            'expires' => time() + (60 * 60 * 24 * 365),
            'path' => '/',
            'sameSite' => yii\web\Cookie::SAME_SITE_LAX,
        ]);

        setrawcookie('themeAttribute', urlencode($themeAttribute), [
            'expires' => time() + (60 * 60 * 24 * 365),
            'path' => '/',
            'sameSite' => yii\web\Cookie::SAME_SITE_LAX,
        ]);

        return [
            'theme' => $theme,
            'themeAttribute' => $themeAttribute
        ];
    }
}