<?php


/* @var $this View */
/* @see \app\controllers\SiteController::actionAccountInformation() */

use yii\helpers\Html;
use yii\web\View;

$this->title = 'Informasi Akun';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-account-information">

    <div class="row">

        <div class="col-12 offset-md-0 col-md-4 col-lg-3 offset-lg-1 align-self-start photo-profile pt-3">
            <div class="d-flex flex-column align-items-center" style="gap: 1rem">
                <?php if (isset($image) and !empty($image)) : ?>
                    <?php echo $image ?>
                <?php endif ?>
            </div>
        </div>

        <div class="col-12 col-md-8 col-lg-8">
            <?php if (isset($dataKaryawan) and !empty($dataKaryawan)) : ?>
                <p>Data dari SIHRD</p>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Nama Karyawan</th>
                        <td><?= $dataKaryawan['nama'] ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Induk Pegawai</th>
                        <td><?= $dataKaryawan['nomor_induk_karyawan'] ?></td>
                    </tr>

                    <?php foreach ($dataKaryawan['jabatan_utama'] as $key => $value) {
                        echo Html::beginTag('tr');
                        echo Html::tag('th', ucfirst($key));
                        echo Html::tag('td', $value);
                        echo Html::endTag('tr');
                    } ?>

                    <tr>
                        <th>User Account</th>
                        <td><?= $dataKaryawan['user']['username'] ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $dataKaryawan['user']['email'] ?></td>
                    </tr>
                    <tr>
                        <th>Bergabung Sejak</th>
                        <td><?= Yii::$app->formatter->asDate($dataKaryawan['user']['created_at']) ?></td>
                    </tr>
                </table>
            <?php endif ?>
        </div>

    </div>

</div>