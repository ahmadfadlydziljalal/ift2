<?php

namespace app\controllers;

use app\enums\TextLinkEnum;
use app\models\Barang;
use app\models\form\ImportMaterialRequestExcelFormRecord;
use app\models\form\ImportMaterialRequestForm;
use app\models\MaterialRequisition;
use app\models\MaterialRequisitionDetail;
use app\models\search\MaterialRequisitionSearch;
use app\models\Tabular;
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
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * MaterialRequisitionController implements the CRUD actions for MaterialRequisition model.
 */
class MaterialRequisitionController extends Controller {

    public function actions(): array {
        return [
            'create-penawaran' => [
                'class' => 'app\actions\material_requisition\CreatePenawaranAction',
            ],
            'update-penawaran' => [
                'class' => 'app\actions\material_requisition\UpdatePenawaranAction',
            ],
            'delete-penawaran' => [
                'class' => 'app\actions\material_requisition\DeletePenawaranAction',
            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public function behaviors(): array {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete'           => ['POST'],
                    'delete-penawaran' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MaterialRequisition models.
     * @return string
     * @throws InvalidConfigException
     */
    public function actionIndex(): string {
        $searchModel = new MaterialRequisitionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->key = 'id';

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialRequisition model.
     * @param integer $id
     * @return string|array
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string|array {

        $model = $this->findModel($id);

        if ($this->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'   => $model->nomor,
                'content' => $this->renderAjax('view', ['model' => $model]),
                'footer'  => Html::a(TextLinkEnum::PRINT->value, ['material-requisition/print-to-pdf', 'id' => $model->id], [
                    'target' => '_blank',
                    'class'  => 'btn btn-success'
                ])
            ];
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $step
     * @param $key
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionImport(int $step = 1, $key = null): Response|string {

        $model = new ImportMaterialRequestForm();

        if ($step == 2) {
            $model->scenario = ImportMaterialRequestForm::SCENARIO_STEP_2;
            $model->setImportMaterialRequestExcelRecord($key);

            if ($model->load(Yii::$app->request->post())) {

                $model->importMaterialRequestExcelRecord = Tabular::createMultiple(ImportMaterialRequestExcelFormRecord::class);
                Tabular::loadMultiple($model->importMaterialRequestExcelRecord, $this->request->post());

                if ($model->validate() && Tabular::validateMultiple($model->importMaterialRequestExcelRecord)) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Material Request has been created successfully.');
                        return $this->redirect(['index']);
                    }
                    Yii::$app->session->setFlash('error', 'Failed to create material request.');
                }
            }

            return $this->render('import_step_2', [
                'model'        => $model,
                'modelsDetail' => $model->getImportMaterialRequestExcelRecord()
            ]);
        }

        // Default step 1
        $model->scenario = ImportMaterialRequestForm::SCENARIO_STEP_1;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->import()) {
                Yii::$app->session->setFlash('success', 'File imported successfully. Please review it!');
                return $this->redirect(['import', 'step' => 2, 'key' => $model->getCacheKey()]);
            }
        }

        return $this->render('import', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new MaterialRequisition model.
     * @return string|Response
     * @throws ServerErrorHttpException
     */
    public function actionCreate(): Response|string {
        $request = Yii::$app->request;

        $model = new MaterialRequisition();
        $modelsDetail = [new MaterialRequisitionDetail([
            'scenario' => MaterialRequisitionDetail::SCENARIO_MR
        ])];

        if ($model->load($request->post())) {

            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetail::class);
            Tabular::loadMultiple($modelsDetail, $request->post());

            if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {
                if ($model->createWithDetails($modelsDetail)) {
                    return $this->redirect(['material-requisition/view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model'        => $model,
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
    public function actionUpdate(int $id): Response|string {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsDetail = !empty($model->materialRequisitionDetails) ? $model->materialRequisitionDetails : [new MaterialRequisitionDetail()];

        if ($model->load($request->post())) {

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetail::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $request->post());
            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {
                if ($model->updateWithDetails($modelsDetail, $deletedDetailsID)) {
                    return $this->redirect(['material-requisition/view', 'id' => $id]);
                }
            }

        }

        return $this->render('update', [
            'model'        => $model,
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
    public function actionDelete(int $id): Response {
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
    public function actionPrint($id): string {
        $this->layout = 'print';
        return $this->render('print', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws CrossReferenceException
     * @throws InvalidConfigException
     * @throws MpdfException
     * @throws NotFoundHttpException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function actionPrintToPdf($id): string {
        /** @var Pdf $pdf */
        $pdf = Yii::$app->pdfWithLetterhead;
        $pdf->content = $this->renderPartial('print', [
            'model' => $this->findModel($id),
        ]);
        return $pdf->render();
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionExpandItem(): string {
        return isset($_POST['expandRowKey']) ? $this->renderPartial('_item', [
            'model' => $this->findModel($_POST['expandRowKey'])
        ]) : Html::tag('div', 'No data found', [
            'class' => 'alert alert-danger'
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPrintPenawaran($id): string {
        $this->layout = 'print';
        return $this->render('print_penawaran', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws CrossReferenceException
     * @throws InvalidConfigException
     * @throws MpdfException
     * @throws NotFoundHttpException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function actionPrintPenawaranToPdf($id): string {
        /** @var Pdf $pdf */
        $pdf = Yii::$app->pdfWithLetterhead;
        $pdf->content = $this->renderPartial('print_penawaran', [
            'model' => $this->findModel($id),
        ]);
        return $pdf->render();
    }

    /**
     * @param string|null $q
     * @param int|string|null $id
     * @return array[]
     */
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
     * Finds the MaterialRequisition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialRequisition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): MaterialRequisition {
        return ($model = MaterialRequisition::findOne($id)) !== null ?
            $model : throw new NotFoundHttpException('The requested page does not exist.');
    }

}