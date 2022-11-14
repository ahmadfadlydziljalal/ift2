<?php

namespace app\controllers;

use app\enums\TextLinkEnum;
use app\models\form\BeforeCreateTandaTerimaBarangForm;
use app\models\form\LaporanIncomingTandaTerimaBarang;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\search\TandaTerimaBarangSearch;
use app\models\Tabular;
use app\models\TandaTerimaBarang;
use app\models\TandaTerimaBarangDetail;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * TandaTerimaBarangController implements the CRUD actions for TandaTerimaBarang model.
 */
class TandaTerimaBarangController extends Controller
{
    /**
     * @inheritdoc
     */
    #[ArrayShape(['verbs' => "array"])]
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TandaTerimaBarang models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new TandaTerimaBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single TandaTerimaBarang model.
     * @param integer $id
     * @return string
     * @throws HttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the TandaTerimaBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TandaTerimaBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): TandaTerimaBarang
    {
        if (($model = TandaTerimaBarang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new TandaTerimaBarang model.
     * @param int $purchaseOrderId
     * @return Response | string
     */
    public function actionCreate(int $purchaseOrderId): Response|string
    {

        if (!$this->checkUrlCreate()) {
            return $this->redirect(['tanda-terima-barang/before-create']);
        }

        $request = Yii::$app->request;
        $model = new TandaTerimaBarang();

        $mrdp = MaterialRequisitionDetailPenawaran::find()->forCreateTandaTerima($purchaseOrderId);
        foreach ($mrdp as $k => $m) {
            $modelsDetail[$k] = new TandaTerimaBarangDetail([
                'material_requisition_detail_penawaran_id' => $m->id
            ]);
        }

        if ($model->load($request->post())) {

            $modelsDetail = Tabular::createMultiple(TandaTerimaBarangDetail::class);
            Tabular::loadMultiple($modelsDetail, $request->post());

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {

                $status = $model->createWithDetails($modelsDetail);

                if ($status['code']) {
                    Url::remember(); // reset url dari before-create ke create

                    Yii::$app->session->setFlash('success', 'TandaTerimaBarang: ' . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil ditambahkan.");
                    return $this->redirect(['tanda-terima-barang/view', 'id' => $model->id]);
                }

                Yii::$app->session->setFlash('danger', " TandaTerimaBarang is failed to insert. Info: " . $status['message']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsDetail' => empty($modelsDetail) ? [new MaterialRequisitionDetailPenawaran()] : $modelsDetail,
        ]);
    }

    /**
     * @return bool
     */
    protected function checkUrlCreate(): bool
    {
        $allowedUrl = ['/tanda-terima-barang/before-create'];
        if (!in_array(Url::previous(), $allowedUrl)) {
            return false;
        }
        return true;
    }

    /**
     * Updates an existing TandaTerimaBarang model.
     * Only for ajax request will return json object
     * @param integer $id
     * @return Response | string
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsDetail = !empty($model->tandaTerimaBarangDetails) ? $model->tandaTerimaBarangDetails : [new TandaTerimaBarangDetail()];

        if ($model->load($request->post())) {

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(TandaTerimaBarangDetail::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $request->post());
            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {
                $status = $model->updateWithDetails($modelsDetail, $deletedDetailsID);
                if ($status['code']) {
                    Yii::$app->session->setFlash('info', [
                        [
                            'title' => 'Successfully updated.!',
                            'message' => "Tanda Terima Barang: " . $model->nomor . " berhasil di update.",
                            'footer' =>
                                Html::a(TextLinkEnum::PRINT->value, ['tanda-terima-barang/print', 'id' => $model->id], [
                                    'class' => 'btn btn-success',
                                    'target' => '_blank',
                                    'rel' => 'noopener noreferrer'
                                ])
                        ]
                    ]);
                    return $this->redirect(['tanda-terima-barang/view', 'id' => $model->id]);
                }

                Yii::$app->session->setFlash('danger', " TandaTerimaBarang is failed to insert. Info: " . $status['message']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsDetail' => $modelsDetail,
        ]);
    }

    /**
     * Delete an existing TandaTerimaBarang model.
     * Only for ajax request will return json object
     * @param integer $id
     * @return Response
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $status = $model->deleteWithTandaTerimaBarangDetails();

        Yii::$app->session->setFlash('danger', 'Tanda Terima Barang: ' . $model->nomor . ', ' . $status['message']);
        return $this->redirect(['index']);
    }

    /**
     * @return Response|string
     */
    public function actionBeforeCreate(): Response|string
    {
        $model = new BeforeCreateTandaTerimaBarangForm();
        if ($this->request->isPost) {

            if ($model->load($this->request->post()) && $model->validate()) {
                Url::remember(['/tanda-terima-barang/before-create']);
                return $this->redirect(['tanda-terima-barang/create', 'purchaseOrderId' => $model->nomorPurchaseOrder]);
            }
        }

        return $this->render('before_create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPrint($id): string
    {
        $this->layout = 'print';
        return $this->render('preview_print', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionExpandItem(): string
    {
        if (isset($_POST['expandRowKey'])) {
            return $this->renderPartial('_item', [
                'model' => $this->findModel($_POST['expandRowKey'])
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionLaporanIncoming(): Response|string
    {
        $model = new LaporanIncomingTandaTerimaBarang();

        if ($model->load($this->request->post())) {
            return $this->redirect(['tanda-terima-barang/preview-laporan-incoming',
                    'tanggal' => $model->tanggal]
            );
        }

        return $this->render('_form_laporan_tanda_terima_barang', [
            'model' => $model
        ]);

    }

    public function actionPreviewLaporanIncoming($tanggal): string
    {
        $model = new LaporanIncomingTandaTerimaBarang([
            'tanggal' => $tanggal
        ]);
        return $this->render('_preview_laporan_tanda_terima_barang', [
            'model' => $model
        ]);
    }


}