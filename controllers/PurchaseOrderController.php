<?php

namespace app\controllers;

use app\models\form\BeforeCreatePurchaseOrderForm;
use app\models\MaterialRequisition;
use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\PurchaseOrder;
use app\models\search\PurchaseOrderSearch;
use app\models\Tabular;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PurchaseOrderController implements the CRUD actions for PurchaseOrder model.
 */
class PurchaseOrderController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all PurchaseOrder models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new PurchaseOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseOrder model.
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
     * Finds the PurchaseOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): PurchaseOrder
    {
        if (($model = PurchaseOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBeforeCreate(): Response|string
    {
        $model = new BeforeCreatePurchaseOrderForm();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['purchase-order/create',
                'materialRequestAndVendorId' => $model->nomorMaterialRequest
            ]);
        }

        return $this->render('before_create', [
            'model' => $model
        ]);
    }

    /**
     * @param $q
     * @param $id
     * @return string[][]
     */
    #[ArrayShape(['results' => "mixed|string[]"])]
    public function actionFindMaterialRequisitionForCreatePurchaseOrder($q = null, $id = null): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {

            $data = MaterialRequisitionDetail::find()->createForPurchaseOrder($q);
            $out['results'] = array_values($data);

        } elseif ($id > 0) {

            $out['results'] = [
                'id' => $id,
                'text' => MaterialRequisition::find($id)->nama
            ];

        }

        return $out;
    }

    /**
     * Creates a new PurchaseOrder model.
     * @param $materialRequestAndVendorId
     * @return string|Response
     */
    public function actionCreate($materialRequestAndVendorId): Response|string
    {
        $materialRequestAndVendorId = Json::decode($materialRequestAndVendorId);


        $request = Yii::$app->request;

        $model = new PurchaseOrder([
            'material_requisition_id' => $materialRequestAndVendorId['material_requisition_id'],
            'vendor_id' => $materialRequestAndVendorId['vendor_id']
        ]);
        
        $modelsDetail = MaterialRequisitionDetailPenawaran::find()
            ->joinWith('materialRequisitionDetail', false)
            ->where([
                'material_requisition_id' => $materialRequestAndVendorId['material_requisition_id'],
                'material_requisition_detail_penawaran.vendor_id' => $materialRequestAndVendorId['vendor_id'],
            ])
            ->all();

        if ($model->load($request->post())) {

            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetailPenawaran::class, $modelsDetail);
            Tabular::loadMultiple($modelsDetail, $request->post());

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {

                $transaction = PurchaseOrder::getDb()->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {
                        foreach ($modelsDetail as $detail) :
                            $detail->purchase_order_id = $model->id;
                            if (!($flag = $detail->save(false))) {
                                break;
                            }
                        endforeach;
                    }

                    if ($flag) {
                        $transaction->commit();
                        $status = ['code' => 1, 'message' => 'Commit'];
                    } else {
                        $transaction->rollBack();
                        $status = ['code' => 0, 'message' => 'Roll Back'];
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                    $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
                }

                if ($status['code']) {
                    Yii::$app->session->setFlash('success', 'PurchaseOrder: ' . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil ditambahkan.");
                    return $this->redirect(['index']);
                }

                Yii::$app->session->setFlash('danger', " PurchaseOrder is failed to insert. Info: " . $status['message']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsDetail' => empty($modelsDetail) ? [new MaterialRequisitionDetailPenawaran()] : $modelsDetail,
        ]);

    }

    /**
     * Updates an existing PurchaseOrder model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsDetail = !empty($model->materialRequisitionDetails)
            ? $model->materialRequisitionDetails
            : [new MaterialRequisitionDetail()];

        if ($model->load($request->post())) {

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetail::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $request->post());
            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {
                $transaction = PurchaseOrder::getDb()->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        if (!empty($deletedDetailsID)) {
                            MaterialRequisitionDetail::updateAll(['purchase_order_id' => null], ['id' => $deletedDetailsID]);
                        }

                        foreach ($modelsDetail as $detail) :
                            $detail->purchase_order_id = $model->id;
                            if (!($flag = $detail->save(false))) {
                                break;
                            }
                        endforeach;
                    }

                    if ($flag) {
                        $transaction->commit();
                        $status = ['code' => 1, 'message' => 'Commit'];
                    } else {
                        $transaction->rollBack();
                        $status = ['code' => 0, 'message' => 'Roll Back'];
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
                }

                if ($status['code']) {
                    Yii::$app->session->setFlash('info', "PurchaseOrder: " . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil di update.");
                    return $this->redirect(['index']);
                }

                Yii::$app->session->setFlash('danger', " PurchaseOrder is failed to updated. Info: " . $status['message']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsDetail' => $modelsDetail
        ]);
    }

    /**
     * Delete an existing PurchaseOrder model.
     * @param integer $id
     * @return Response
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger', " PurchaseOrder : " . $model->nomor . " berhasil dihapus.");
        return $this->redirect(['index']);
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
}