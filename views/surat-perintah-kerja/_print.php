<?php

/* @var $this yii\web\View */
/* @var $model app\models\SuratPerintahKerja */
/* @see \app\controllers\SuratPerintahKerjaController::actionExport() */

?>

<div class="card-body">

    <!-- Header -->
    <div class="text-center mb-3">
        <h2 style="text-decoration: underline">Surat Perintah Kerja</h2>
        <table align="center" class="table table-borderless" style="width:320px; font-size: 16px">
            <tbody>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td><?= $model->nomor ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?= Yii::$app->formatter->asDate($model->tanggal) ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Content -->
    <div>
        <div>Dengan ini diberikan perintah kerja kepada:
            <strong class="fw-bold"><?= $model->pelaksana ?></strong>
        </div>
        <div class="mb-3">Untuk melaksanakan pekerjaan:
            <strong class="fw-bold"><?= $model->judul ?></strong>
        </div>
        <div class="mb-3"><strong>Detail Pekerjaan:</strong><br/>
            <div class="ps-4"> <?= !empty($model->keterangan) ? nl2br($model->keterangan) : '' ?></div>
        </div>
        <div><strong>Data pendukung:</strong><br/>
            <div class="ps-4">
                <?php if (!empty($model->suratPerintahKerjaSupportingDocuments)) { ?>
                    <span>Nomor Quotation:</span>
                    <span class="fw-bold">
                            <?php foreach ($model->suratPerintahKerjaSupportingDocuments as $document) {
                                echo $document->quotation->nomor . ' ; ';
                            } ?>
                        </span>

                    <br/>
                <?php } ?>
                <?php if (!empty($model->data_pendukung_lainnya)) {
                    echo $model->data_pendukung_lainnya;
                } ?>
            </div>
        </div>

        <p>Agar melaksanakan pekerjaan ini dengan penuh tanggung jawab dan melaporkan perkembangan pekerjaan serta
            pertanggungjawaban atas biaya pekerjaan bila telah selesai dilaksanakan.<br/><br/>Demikian surat perintah
            ini
            dibuat, agar dilaksanakan denga sebaik-baiknya!</p>

    </div>

    <!-- Signature -->
    <div>
        <div style="float: right;  width: 25% ">
            <span>&nbsp;&nbsp;&nbsp;&nbsp; Hormat Kami</span>
            <div style="height: 6rem"></div>
            <div class="">( __________________ )</div>
        </div>
        <div style="clear: both"></div>
    </div>

</div>
