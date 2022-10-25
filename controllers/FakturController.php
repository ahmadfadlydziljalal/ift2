<?php

namespace app\controllers;

use app\models\Faktur;
use app\models\FakturDetail;
use app\models\search\FakturSearch;
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
 * FakturController implements the CRUD actions for Faktur model.
 */
class FakturController extends Controller
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
     * Lists all Faktur models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new FakturSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Faktur model.
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
     * Finds the Faktur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Faktur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Faktur
    {
        if (($model = Faktur::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Faktur model.
     * @return string|Response
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Faktur();
        $modelsDetail = [new FakturDetail()];

        if ($model->load($request->post())) {

            $modelsDetail = Tabular::createMultiple(FakturDetail::class);
            Tabular::loadMultiple($modelsDetail, $request->post());

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {

                $transaction = Faktur::getDb()->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {
                        foreach ($modelsDetail as $detail) :
                            $detail->faktur_id = $model->id;
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

                    Yii::$app->session->setFlash('success', 'Faktur: '
                        . Html::a($model->nomor_faktur, ['view', 'id' => $model->id]) . " berhasil ditambahkan. "
                        . Html::a(' Print disini.', ['faktur/print', 'id' => $model->id],[
                            'target' => '_blank',
                            'rel' => 'noopener noreferrer'
                        ])
                    );

                    if ($request->post('create-another')) {
                        return $this->redirect(['faktur/create']);
                    }
                    return $this->redirect(['index']);
                }

                Yii::$app->session->setFlash('danger', " Faktur is failed to insert. Info: " . $status['message']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsDetail' => empty($modelsDetail) ? [new FakturDetail()] : $modelsDetail,
        ]);
    }

    /**
     * Updates an existing Faktur model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsDetail = !empty($model->fakturDetails) ? $model->fakturDetails : [new FakturDetail()];

        if ($model->load($request->post())) {

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(FakturDetail::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $request->post());
            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {
                $transaction = Faktur::getDb()->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        if (!empty($deletedDetailsID)) {
                            FakturDetail::deleteAll(['id' => $deletedDetailsID]);
                        }

                        foreach ($modelsDetail as $detail) :
                            $detail->faktur_id = $model->id;
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
                    Yii::$app->session->setFlash('info', "Faktur: "
                        . Html::a($model->nomor_faktur, ['view', 'id' => $model->id]) . " berhasil di update. "
                        . Html::a(' Print disini.', ['faktur/print', 'id' => $model->id],[
                            'target' => '_blank',
                            'rel' => 'noopener noreferrer'
                        ])
                    );
                    if ($request->post('create-another')) {
                        return $this->redirect(['faktur/create']);
                    }
                    return $this->redirect(['index']);
                }

                Yii::$app->session->setFlash('danger', " Faktur is failed to updated. Info: " . $status['message']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsDetail' => $modelsDetail
        ]);
    }

    /**
     * Delete an existing Faktur model.
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

        Yii::$app->session->setFlash('danger', " Faktur : " . $model->nomor_faktur . " berhasil dihapus.");
        return $this->redirect(['index']);
    }

    /**
     * @throws CrossReferenceException
     * @throws MpdfException
     * @throws InvalidConfigException
     * @throws PdfParserException
     * @throws NotFoundHttpException
     * @throws PdfTypeException
     */
    public function actionPdf($id): string
    {
        $model = $this->findModel($id);

        /** @var Pdf $pdf */
        $pdf = Yii::$app->pdf;
        $pdf->format = [215, 140];
        $pdf->marginTop = 8;
        $pdf->marginBottom = 2;
        $pdf->content = $this->renderPartial('preview_print', [
            'model' => $model,
            'openWindowPrint' => 0,
        ]);

        return $pdf->render();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionPreviewPrint($id): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);

        return [
            'title' => 'Faktur ' . $model->nomor_faktur . ' ' .
                (
                    Html::tag('span', $model->jenisTransaksi->nama, [
                        'class' =>strtolower($model->jenisTransaksi->nama )== 'cash' ?
                            'badge text-bg-primary' :
                            'badge text-bg-warning'
                    ])
                )
            ,
            'content' => $this->renderAjax('preview_print', [
                'model' => $model,
                'openWindowPrint' => 0
            ]),
            'footer' =>
                Html::button('Close', [
                    'class' => 'btn btn-dark',
                    'data-bs-dismiss' => "modal"
                ]) .

                Html::a('PDF', ['faktur/pdf', 'id' => $id], [
                    'class' => 'btn btn-success',
                    'target' => '_blank',
                    'rel' => 'noopener noreferrer'
                ]) .
                Html::a('Print', ['faktur/print', 'id' => $id], [
                    'class' => 'btn btn-success ms-auto',
                    'onclick' => 'window.open(this.href); return false',
                    'id' => 'btn-print'
                ])
        ];
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPrint($id): string
    {
        $model = $this->findModel($id);
        return $this->renderPartial('preview_print', [
            'model' => $model,
            'openWindowPrint' => 1
        ]);
    }
}