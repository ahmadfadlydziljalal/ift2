<?php

namespace app\controllers;

use app\models\MaterialRequisition;
use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\search\MaterialRequisitionSearch;
use app\models\Tabular;
use Exception;
use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * MaterialRequisitionController implements the CRUD actions for MaterialRequisition model.
 */
class MaterialRequisitionController extends Controller
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
     * Lists all MaterialRequisition models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new MaterialRequisitionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->key = 'id';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialRequisition model.
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
     * Finds the MaterialRequisition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialRequisition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): MaterialRequisition
    {
        if (($model = MaterialRequisition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new MaterialRequisition model.
     * @return string|Response
     */
    public function actionCreate(): Response|string
    {
        $request = Yii::$app->request;
        $model = new MaterialRequisition();
        $modelsDetail = [new MaterialRequisitionDetail([
            'scenario' => MaterialRequisitionDetail::SCENARIO_MR
        ])];

        if ($model->load($request->post())) {

            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetail::class);
            Tabular::loadMultiple($modelsDetail, $request->post());

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {

                $transaction = MaterialRequisition::getDb()->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {
                        foreach ($modelsDetail as $detail) :
                            $detail->material_requisition_id = $model->id;
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
                    Yii::$app->session->setFlash('success', 'MaterialRequisition: ' . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil ditambahkan.");
                    return $this->redirect(['material-requisition/view', 'id' => $model->id]);
                }

                Yii::$app->session->setFlash('danger', " MaterialRequisition is failed to insert. Info: " . $status['message']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsDetail' => empty($modelsDetail) ? [new MaterialRequisitionDetail()] : $modelsDetail,
        ]);

    }

    /**
     * Updates an existing MaterialRequisition model.
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
        $modelsDetail = !empty($model->materialRequisitionDetails) ? $model->materialRequisitionDetails : [new MaterialRequisitionDetail()];

        if ($model->load($request->post())) {

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetail::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $request->post());
            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {
                $transaction = MaterialRequisition::getDb()->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        if (!empty($deletedDetailsID)) {
                            MaterialRequisitionDetail::deleteAll(['id' => $deletedDetailsID]);
                        }

                        foreach ($modelsDetail as $detail) :
                            $detail->material_requisition_id = $model->id;
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
                    Yii::$app->session->setFlash('info', "MaterialRequisition: " . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil di update.");
                    return $this->redirect(['material-requisition/view', 'id' => $id]);
                }

                Yii::$app->session->setFlash('danger', " MaterialRequisition is failed to updated. Info: " . $status['message']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsDetail' => $modelsDetail
        ]);
    }

    /**
     * Delete an existing MaterialRequisition model.
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

        Yii::$app->session->setFlash('danger', " MaterialRequisition : " . $model->nomor . " berhasil dihapus.");
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
        return $this->render('print', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @throws MpdfException
     * @throws CrossReferenceException
     * @throws InvalidConfigException
     * @throws PdfParserException
     * @throws NotFoundHttpException
     * @throws PdfTypeException
     */
    public function actionPrintPdf($id): string
    {
        /** @var Pdf $pdf */
        $pdf = Yii::$app->pdfWithLetterhead;
        $pdf->content = $this->renderPartial('print_pdf', [
            'model' => $this->findModel($id),
        ]);
        return $pdf->render();
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

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionExpandItemGroup(): string
    {
        if (isset($_POST['expandRowKey'])) {
            return $this->renderPartial('_item', [
                'model' => $this->findModel($_POST['expandRowKey'])
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }


    /**
     * @param int $materialRequisitionDetailId
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionCreatePenawaran(int $materialRequisitionDetailId): Response|string
    {

        $modelMaterialRequisitionDetail = $this->findModelDetail($materialRequisitionDetailId);
        $modelMaterialRequisition = $this->findModel($modelMaterialRequisitionDetail->materialRequisition->id);

        $modelsDetail = [new MaterialRequisitionDetailPenawaran()];

        if ($this->request->isPost) {

            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetailPenawaran::class);
            Tabular::loadMultiple($modelsDetail, $this->request->post());

            if (Tabular::validateMultiple($modelsDetail)) {

                $transaction = MaterialRequisitionDetailPenawaran::getDb()->beginTransaction();

                try {

                    $flag = true;
                    foreach ($modelsDetail as $detail) :

                        /** @var MaterialRequisitionDetailPenawaran $detail */
                        $detail->material_requisition_detail_id = $materialRequisitionDetailId;
                        if (!($flag = $detail->save(false))) {
                            break;
                        }
                    endforeach;

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
                    Yii::$app->session->setFlash('success', " Harga penawaran berhasil ditambahkan.");
                    return $this->redirect(['material-requisition/view', 'id' => $modelMaterialRequisition->id]);
                }

                Yii::$app->session->setFlash('danger', " Harga penawaran is failed to insert. Info: " . $status['message']);
            }

        }

        return $this->render('create_penawaran', [
            'modelMaterialRequisition' => $modelMaterialRequisition,
            'modelMaterialRequisitionDetail' => $modelMaterialRequisitionDetail,
            'modelsDetail' => $modelsDetail,
        ]);
    }

    /**
     * @param $materialRequisitionDetailId
     * @return MaterialRequisitionDetail|null
     * @throws NotFoundHttpException
     */
    protected function findModelDetail($materialRequisitionDetailId): ?MaterialRequisitionDetail
    {
        if (($model = MaterialRequisitionDetail::findOne($materialRequisitionDetailId)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param int $materialRequisitionDetailId
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdatePenawaran(int $materialRequisitionDetailId): Response|string
    {
        $modelMaterialRequisitionDetail = $this->findModelDetail($materialRequisitionDetailId);
        $modelMaterialRequisition = $this->findModel($modelMaterialRequisitionDetail->materialRequisition->id);

        $modelsDetail = empty($modelMaterialRequisitionDetail->materialRequisitionDetailPenawarans)
            ? [new MaterialRequisitionDetailPenawaran()]
            : $modelMaterialRequisitionDetail->materialRequisitionDetailPenawarans;

        if ($this->request->isPost) {

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetailPenawaran::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $this->request->post());
            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            if (Tabular::validateMultiple($modelsDetail)) {

                $transaction = MaterialRequisitionDetailPenawaran::getDb()->beginTransaction();

                try {

                    $flag = true;

                    if (!empty($deletedDetailsID)) {
                        MaterialRequisitionDetailPenawaran::deleteAll(['id' => $deletedDetailsID]);
                    }

                    foreach ($modelsDetail as $detail) :

                        /** @var MaterialRequisitionDetailPenawaran $detail */
                        $detail->material_requisition_detail_id = $materialRequisitionDetailId;
                        if (!($flag = $detail->save(false))) {
                            break;
                        }
                    endforeach;

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
                    Yii::$app->session->setFlash('success', " Harga penawaran berhasil di-update.");
                    return $this->redirect(['material-requisition/view', 'id' => $modelMaterialRequisition->id]);
                }

                Yii::$app->session->setFlash('danger', " Harga penawaran is failed to insert. Info: " . $status['message']);
            }

        }

        return $this->render('update_penawaran', [
            'modelMaterialRequisition' => $modelMaterialRequisition,
            'modelMaterialRequisitionDetail' => $modelMaterialRequisitionDetail,
            'modelsDetail' => $modelsDetail,
        ]);
    }

    /**
     * @param int $materialRequisitionDetailId
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDeletePenawaran(int $materialRequisitionDetailId): Response
    {
        $modelMaterialRequisitionDetail = $this->findModelDetail($materialRequisitionDetailId);
        $count = MaterialRequisitionDetailPenawaran::deleteAll([
            'material_requisition_detail_id' => $materialRequisitionDetailId
        ]);

        Yii::$app->session->setFlash('success', $count . ' penawaran records berhasil dibatalkan.');
        return $this->redirect(['material-requisition/view', 'id' => $modelMaterialRequisitionDetail->material_requisition_id]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPrintPenawaran($id): string
    {
        $this->layout = 'print';
        return $this->render('print_penawaran', [
            'model' => $this->findModel($id),
        ]);
    }


}