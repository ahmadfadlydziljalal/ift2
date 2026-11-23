<?php

namespace app\controllers;

use app\enums\TipePembelianEnum;
use app\models\Barang;
use app\models\BarangSatuan;
use app\models\form\BarangStart;
use app\models\Satuan;
use app\models\search\BarangSearch;
use app\models\Tabular;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * BarangController implements the CRUD actions for Barang model.
 */
class BarangController extends Controller {

    public function behaviors(): array {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Barang models.
     * @return string
     */
    public function actionIndex(): string {
        $searchModel = new BarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return Response|string
     * @throws ServerErrorHttpException
     */
    public function actionCreate(): Response|string {
        $request = Yii::$app->request;
        $model = new Barang();
        $modelsDetail = [new BarangSatuan()];

        if ($model->load($request->post())) {

            # Re-create models detail
            $modelsDetail = Tabular::createMultiple(BarangSatuan::class);
            Tabular::loadMultiple($modelsDetail, $request->post());

            # Validate models
            if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {
                if ($model->createWithDetails($modelsDetail)) return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model'        => $model,
            'modelsDetail' => empty($modelsDetail) ? [new BarangSatuan()] : $modelsDetail,
        ]);

    }

    /**
     * Start stock awal barang yang tersebar di banyak lokasi.
     * @param int|null $id
     * @return Response|string
     * @throws NotFoundHttpException
     * @throws Throwable
     */
    public function actionStart(?int $id = null): Response|string {
        $request = Yii::$app->request;
        $model = new BarangStart(['barangId' => $id]);

        if ($id !== null) {
            $barang = $this->findModel($id);
            if ($model->isStarted($barang->id)) {
                Yii::$app->session->setFlash('warning', [[
                    'title'   => 'Barang sudah di-start.',
                    'message' => 'Gunakan Restart untuk mengubah data start.',
                ]]);
                return $this->redirect(['restart', 'id' => $barang->id]);
            }
        }

        if ($request->isPost && $model->loadAll($request->post()) && $model->validateAll() && $model->save()) {
            $this->flashStartSuccess('Start barang berhasil.');
            return $this->redirect(['view', 'id' => $model->barangId]);
        }

        return $this->render('start', ['model' => $model, 'form' => null]);
    }

    /**
     * Ubah data start yang sudah ada.
     * @param int $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionRestart(int $id): Response|string {
        $request = Yii::$app->request;
        $barang = $this->findModel($id);
        $model = new BarangStart();

        if (!$model->isStarted($barang->id)) {
            return $this->redirect(['start', 'id' => $barang->id]);
        }

        $model->loadExisting($barang);

        if ($request->isPost && $model->loadAll($request->post())) {
            $model->barangId = $barang->id; // barang tidak boleh diganti
            if ($model->validateAll() && $model->save()) {
                $this->flashStartSuccess('Restart barang berhasil.');
                return $this->redirect(['view', 'id' => $barang->id]);
            }
        }

        return $this->render('start', ['model' => $model]);
    }

    private function flashStartSuccess(string $title): void {
        Yii::$app->session->setFlash('success', [[
            'title'   => $title,
            'message' => 'Stock awal dan lokasi barang berhasil disimpan.',
        ]]);
    }

    /**
     * @param int $id
     * @return array
     */
    public function actionDefaultSatuan(int $id): array {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['satuan' => Barang::findOne($id)?->defaultSatuan?->nama];
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionFindAvailableHarga(): array {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'data'     => BarangSatuan::findOne([
                'barang_id' => (int)Yii::$app->request->post('barangId'),
                'satuan_id' => (int)Yii::$app->request->post('satuanId'),
                'vendor_id' => (int)Yii::$app->request->post('vendorId'),

            ]),
            'barangId' => (int)Yii::$app->request->post('barangId'),
            'vendorId' => (int)Yii::$app->request->post('vendorId'),
            'satuanId' => (int)Yii::$app->request->post('satuanId'),

        ];
    }

    /**
     * @param $q
     * @param $id
     * @return array[]
     */
    public function actionFindTypeStock($q = null, $id = null): array {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {
            $data = Barang::find()
                ->byTipePembelian(TipePembelianEnum::STOCK->value, $q);
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = [
                'id'   => $id,
                'text' => Barang::findOne($id)->nama
            ];
        }
        return $out;
    }

    /**
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate(int $id): Response|string {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsDetail = !empty($model->barangSatuans)
            ? $model->barangSatuans :
            [new BarangSatuan()];

        if ($model->load($request->post())) :

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(BarangSatuan::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $request->post());
            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {
                if ($model->updateWithDetails($modelsDetail, $deletedDetailsID)) return $this->redirect(['barang/view', 'id' => $id]);
            }

        endif;

        return $this->render('update', [
            'model'        => $model,
            'modelsDetail' => $modelsDetail
        ]);
    }

    /**
     * Delete an existing Barang model.
     * @param integer $id
     * @return Response
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger', " Barang : " . $model->nama . " berhasil dihapus.");
        return $this->redirect(['index']);
    }

    /**
     * Digunakan pada DepDrop
     * @return array|string[]
     */
    public function actionDepdropFindBarangByTipePembelian(): array {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $out = Barang::find()->byTipePembelian($parents[0]);
                if (isset($out[0])) {
                    return ['output' => $out, 'selected' => $out[0]];
                }
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionDepdropFindSatuanByBarang(): array {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $out = BarangSatuan::find()->availableSatuan($parents[0]);
                if (isset($out[0])) {
                    return ['output' => $out, 'selected' => $out[0]];
                }

                $allSatuan = Satuan::find()->mapIdName();
                return ['output' => $allSatuan, 'selected' => $allSatuan[0]];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * Digunakan pada DepDrop
     * @return array|string[]
     */
    public function actionDepdropFindVendorByBarangDanSatuan(): array {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $out = [];
        if (isset($_POST['depdrop_parents'])) {

            $ids = $_POST['depdrop_parents'];
            $barangId = empty($ids[0]) ? null : $ids[0];
            $satuanId = empty($ids[1]) ? null : $ids[1];

            if ($barangId != null) {
                $data = BarangSatuan::find()->availableVendor($barangId, $satuanId);
                return ['output' => $data, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUploadPhoto($id): string {
        $model = $this->findModel($id);
        return $this->render('_form_upload_photo', [
            'model' => $model
        ]);
    }

    /**
     * @return array|void
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionHandleUploadPhoto() {
        if (empty($_FILES['file_data'])) {
            echo Json::encode(['error', 'No files found for upload']);
            return;
        }

        $model = $this->findModel(Yii::$app->request->post('id'));
        $error = $model->upload($_FILES['file_data'], Yii::$app->request->post());

        Yii::$app->response->format = Response::FORMAT_JSON;
        return empty($error)
            ? ['success', $_FILES['file_data']]
            : ['error', 'Error While uploading image, contact the system administrator' . $error];
    }


    /**
     * @param $id
     * @return Response
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function actionDeletePhoto($id): Response {
        $model = $this->findModel($id);
        $storage = Yii::$app->get('spaces');

        $storage->commands()->delete($model->photo)->execute();
        $storage->commands()->delete($model->photo_thumbnail)->execute();

        $model->photo = null;
        $model->photo_thumbnail = null;
        $model->save(false);

        return $this->redirect(['barang/view', 'id' => $id]);
    }

    /**
     * Finds the Barang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Barang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Barang {
        if (($model = Barang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}