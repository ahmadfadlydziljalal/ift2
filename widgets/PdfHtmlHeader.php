<?php

namespace widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class PdfHtmlHeader extends Widget
{

    public ?string $perusahaan = null;

    public ?string $alamat = 'Alamat tidak tersedia, karena anda tidak terdaftar di cabang manapun...!';

    public bool $renderMediaAsPdf = true;
    private string $imgRenderPath = '/images/logo-tms.png';

    public function init()
    {

        parent::init();
        if(!Yii::$app->user->isGuest){
            $dataKaryawan = Yii::$app->cache->get('sihrd-karyawan' . Yii::$app->user->identity->id);
            if(isset($dataKaryawan['jabatan_utama']['perusahaan'])){
                $this->perusahaan = $dataKaryawan['jabatan_utama']['perusahaan'];
                $this->alamat = $dataKaryawan['jabatan_utama']['alamat'];
            }
        }

    }

    public function run()
    {
        if ($this->renderMediaAsPdf) {
            $this->imgRenderPath = "." . $this->imgRenderPath;
        }
        $this->renderLayout();
    }

    public function renderLayout()
    {

        /* Begin Row */
        echo Html::beginTag('div', [
            'class' => 'row'
        ]);

            /* ============ Image ==============*/
            echo Html::beginTag('div', [
                'style' => [
                    'float' => "left",
                    "width" => "10%",
                ]
            ]);
                echo Html::img($this->imgRenderPath, [
                    'style' => [
                        'width' => '80px',
                        'height' => '80px',
                    ]
                ]);
            echo Html::endTag('div');
            /* ============ Image ==============*/


            /* ======== Company =============== */
            echo Html::beginTag('div', [
                'style' => [
                    'float' => "left",
                    "width" => "89%",
                    //'border' => '1px solid black',
                    'text-align' => 'center',
                    'padding' => '0'
                ]
            ]);
                echo Html::tag('h3', $this->perusahaan , ['style' => ['margin' => '0', 'padding' => '0']]);
                echo Html::tag('small', $this->alamat, ['style' => ['margin' => '0', 'padding' => '0']]);

            echo Html::endTag('div');
            /* ======== Company =============== */

        echo Html::endTag('div');
        /* End Row */

        echo "<div style='content: \"\"; clear: both; display: table;'> </div>";
        echo '<hr style="border-top: 1px solid red;"/>';

    }


}