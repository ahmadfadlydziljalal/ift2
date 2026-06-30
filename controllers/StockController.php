<?php

namespace app\controllers;


use app\components\QrCodeStockGenerator;
use app\models\Barang;
use app\models\form\PrintStockMultipleStickerForm;
use app\models\form\SetLokasiBarangInForm;
use app\models\form\SetLokasiBarangMovementForm;
use app\models\form\SetLokasiBarangMovementFromForm;
use app\models\HistoryLokasiBarang;
use app\models\search\StockPerBarangSearch;
use app\models\search\StockSearch;
use app\models\Status;
use app\models\Stock;
use app\models\Tabular;
use app\models\TandaTerimaBarangDetail;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class StockController extends Controller {

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function actionIndex(): string {
        $searchModel = new StockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProviderForExportMenu = clone $dataProvider;
        $dataProviderForExportMenu->pagination = false;

        $today = Yii::$app->formatter->asDate(date('Y-m-d H:i'), 'php:d-m-Y H:i');

        return $this->render('index', [
            'searchModel'               => $searchModel,
            'dataProvider'              => $dataProvider,
            'dataProviderForExportMenu' => $dataProviderForExportMenu,
            'today'                     => $today
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionView(int $id): string {
        $searchModel = new StockPerBarangSearch([
            'barang' => Barang::findOne($id)
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExpand(): string {
        if (isset($_POST['expandRowKey'])) {
            $model = Barang::findOne(($_POST['expandRowKey']));
            $stock = (new Stock());
            $stock->setAttributes((new Stock())->getData()->where([
                'id' => $model->id,
            ])->one());
            return $this->renderPartial('_expand', [
                'model' => $model,
                'stock' => $stock,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionPrintSticker($id) {
        $model = Barang::findOne($id);
        /*$this->layout = 'print';
        return $this->render('preview_print_sticker_pdf', [
            'model' => $model,
        ]);*/

        $pdf = Yii::$app->pdfStickerStock;
        $pdf->content = $this->renderPartial('preview_print_sticker', [
            'path'        => (new QrCodeStockGenerator([
                'text'     => Url::to(['/scan', 'object' => 'stock', 'params' => ['id' => $model->id]], true),
                'filename' => 'qr-code-stock-' . $model->id . '.png',
                'size'     => 100,
                'margin'   => 0,
            ]))->toFile(),
            'barang'      => $model,
            'width'       => $pdf->format[0],
            'height'      => $pdf->format[1],
            'orientation' => 'L',
        ]);
        return $pdf->render();
    }

    public function actionPrintMultipleSticker() {
        $model = new PrintStockMultipleStickerForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $pdf = Yii::$app->pdfStickerStock;


            // 1. Pecah ukuran format kertas
            $dimensions = explode('*', $model->format);
            $width = $model->orientation == 'L' ? (int)$dimensions[1] : (int)$dimensions[0];
            $height = $model->orientation == 'L' ? (int)$dimensions[0] : (int)$dimensions[1];

            // 2. Set format
            $pdf->format = [$width, $height];

            $barangs = $model->generateBarangsModel();

            $content = '';
            $countBarangs = count($barangs);
            foreach ($barangs as $key => $barang) {
                $content .= $this->renderPartial('preview_print_sticker', [
                    'barang'      => $barang,
                    'path'        => (new QrCodeStockGenerator([
                        'text'     => Url::to(['/scan', 'object' => 'stock', 'params' => ['id' => $barang->id]], true),
                        'filename' => 'qr-code-stock-' . $barang->id . '.png',
                        'size'     => 125,
                        'margin'   => 0,
                    ]))->toFile(),
                    'width'       => $width,
                    'height'      => $height,
                    'orientation' => $model->orientation,
                ]);

                // if last page, do not add pagebreak;
                if (($key + 1) < $countBarangs) {
                    $content .= '<pagebreak />';
                }

            }

            $pdf->content = $content;
            return $pdf->render();
        }

        return $this->render('form_print_multiple_sticker', [
            'model' => $model,
        ]);
    }

    public function actionFindBarang(string $q = null, int|string $id = null): array {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $out['results'] = Barang::find()->liveSearch($q)->limit(20)->asArray()->all();
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Barang::findOne($id)->part_number];
        }
        return $out;
    }

    /**
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionSetLokasi($id, string $type): Response|string {
        $modelType = $this->findStatusSetLokasi($type);
        $modelTandaTerimaBarangDetail = $this->findTandaTerimaBarangDetailModel($id);

        $model = new SetLokasiBarangInForm([
            'tandaTerimaBarangDetail' => $modelTandaTerimaBarangDetail,
            'tipePergerakan'          => $modelType,
        ]);
        $modelsDetail = [new HistoryLokasiBarang()];

        if ($this->request->isPost) {

            $modelsDetail = Tabular::createMultiple(HistoryLokasiBarang::class);
            Tabular::loadMultiple($modelsDetail, $this->request->post());

            $model->historyLokasiBarangs = $modelsDetail;
            if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', [['title' => 'Lokasi in berhasil di record.', 'message' => 'Congratulation ...!']]);
                    return $this->redirect(['stock/view', 'id' => $modelTandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang_id]);
                }

            }

            Yii::$app->session->setFlash('error', [[
                'title'   => 'Gagal insert lokasi',
                'message' => $model->errors
            ]]);

        }

        return $this->render('_form_set_lokasi', [
            'model'        => $model,
            'modelsDetail' => $modelsDetail,
        ]);

    }

    /**
     * @param $type
     * @return Status|null
     * @throws NotFoundHttpException
     */
    protected function findStatusSetLokasi($type): ?Status {
        if (($model = Status::findOne(['section' => 'set-lokasi-barang', 'key' => $type])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('You got status not valid for status set lokasi: ' . $type);
    }

    /**
     * @param $id
     * @return TandaTerimaBarangDetail|null
     * @throws NotFoundHttpException
     */
    protected function findTandaTerimaBarangDetailModel($id): ?TandaTerimaBarangDetail {
        if (($model = TandaTerimaBarangDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException();
    }

    public function actionSetMovementLokasi($id): Response|string {
        $modelTandaTerimaBarangDetail = $this->findTandaTerimaBarangDetailModel($id);
        $historySebelumnya = HistoryLokasiBarang::findAll([
            'tanda_terima_barang_detail_id' => $id
        ]);

        $movementBarangModel = new SetLokasiBarangMovementForm();
        $movementBarangModel->tandaTerimaBarangDetail = $modelTandaTerimaBarangDetail;
        $movementBarangModel->totalItemTandaTerimaBarangDetail = $modelTandaTerimaBarangDetail->quantity_terima;


        $models = [];
        foreach ($historySebelumnya as $sebelumnya) {
            $models[] = new SetLokasiBarangMovementFromForm([
                'tipePergerakanFromId' => 9,
                'quantityFrom'         => $sebelumnya->quantity,
                'blockFrom'            => $sebelumnya->block,
                'rakFrom'              => $sebelumnya->rak,
                'tierFrom'             => $sebelumnya->tier,
                'rowFrom'              => $sebelumnya->row,
            ]);
        }

        if ($this->request->isPost) {


            $models = Tabular::createMultiple(SetLokasiBarangMovementForm::class);
            Tabular::loadMultiple($models, $this->request->post());

            $movementBarangModel->movementBarangItems = $models;

            if ($movementBarangModel->validate() && Tabular::validateMultiple($models)) {
                return $this->redirect(['stock/view', 'id' => $modelTandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang_id]);
            }


        }

        return $this->render('_form_set_movement', [
            'models'                       => $models,
            'modelTandaTerimaBarangDetail' => $modelTandaTerimaBarangDetail,
            'movementBarangModel'          => $movementBarangModel,
        ]);
    }

}