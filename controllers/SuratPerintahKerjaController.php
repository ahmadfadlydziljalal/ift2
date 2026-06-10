<?php

namespace app\controllers;


use app\models\Quotation;
use app\models\search\SuratPerintahKerjaSearch;
use app\models\SuratPerintahKerja;
use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * SuratPerintahKerjaController implements the CRUD actions for SuratPerintahKerja model.
 */
class SuratPerintahKerjaController extends Controller {
    /**
     * {@inheritdoc}
     */
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
     * Lists all SuratPerintahKerja models.
     * @return string
     */
    public function actionIndex(): string {
        $searchModel = new SuratPerintahKerjaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SuratPerintahKerja model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new SuratPerintahKerja model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     * @throws Exception
     */
    public function actionCreate(): Response|string {
        $model = new SuratPerintahKerja();

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->saveWithQuotation()) {
                Yii::$app->session->setFlash('success', 'SuratPerintahKerja: ' . $model->nomor . ' berhasil ditambahkan.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SuratPerintahKerja model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id): Response|string {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->saveWithQuotation()) {
            Yii::$app->session->setFlash('info', 'SuratPerintahKerja: ' . $model->nomor . ' berhasil dirubah.');
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SuratPerintahKerja model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete(int $id): Response {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger', 'SuratPerintahKerja: ' . $model->id . ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
     * @param string|null $q
     * @param int|string|null $id
     * @return array[]
     */
    public function actionFindQuotation(string $q = null, int|string $id = null): array {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $out['results'] = Quotation::find()->liveSearch($q)->limit(20)->asArray()->all();
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Quotation::findOne($id)->nomor];
        }
        return $out;
    }

    /**
     * @throws CrossReferenceException
     * @throws MpdfException
     * @throws InvalidConfigException
     * @throws PdfParserException
     * @throws NotFoundHttpException
     * @throws PdfTypeException
     */
    public function actionExport($id, $type = 'pdf'): string {

        $model = $this->findModel($id);
        /** @var $pdf Pdf */
        $pdf = Yii::$app->pdf;
        $pdf->content = $this->renderPartial('_print', [
            'model' => $model
        ]);
        $pdf->filename = 'Surat Perintah Kerja | ' . $model->nomor;
        return $pdf->render();
    }

    /**
     * Finds the SuratPerintahKerja model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SuratPerintahKerja the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): SuratPerintahKerja {
        return ($model = SuratPerintahKerja::findOne($id)) !== null ? $model :
            throw new NotFoundHttpException('The requested page does not exist.');
    }
}