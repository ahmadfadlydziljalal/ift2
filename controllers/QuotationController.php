<?php

namespace app\controllers;

use app\models\Quotation;
use app\models\QuotationBarang;
use app\models\QuotationFormJob;
use app\models\QuotationService;
use app\models\QuotationTermAndCondition;
use app\models\search\QuotationSearch;
use app\models\Tabular;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['verbs' => "array"])]
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-barang-quotation' => ['POST'],
                    'delete-service-quotation' => ['POST'],
                    'delete-term-and-condition' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Quotation models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new QuotationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Quotation model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Finds the Quotation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quotation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Quotation
    {
        if (($model = Quotation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Quotation model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreate(): Response|string
    {
        $model = new Quotation();

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Quotation: ' . $model->nomor . ' berhasil ditambahkan.');
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
     * Updates an existing Quotation model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'Quotation: ' . $model->nomor . ' berhasil dirubah.');
            return $this->redirect(['quotation/view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Quotation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger', 'Quotation: ' . $model->nomor . ' berhasil dihapus.');
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

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionCreateBarangQuotation($id): Response|string
    {
        $quotation = $this->findModel($id);
        $quotation->scenario = Quotation::SCENARIO_CREATE_BARANG_QUOTATION;
        $models = [new QuotationBarang([
            'quotation_id' => $quotation->id
        ])];

        if ($this->request->isPost && $quotation->load($this->request->post())) {

            $models = Tabular::createMultiple(QuotationBarang::class);
            Tabular::loadMultiple($models, $this->request->post());

            $quotation->modelsQuotationBarang = $models;

            if ($quotation->validate() && Tabular::validateMultiple($models)) {
                if ($quotation->createModelsQuotationBarang()) {
                    Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                    return $this->redirect(['quotation/view', 'id' => $quotation->id]);
                }
            }

            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }

        return $this->render('create_barang_quotation', [
            'quotation' => $quotation,
            'models' => $models,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdateBarangQuotation($id): Response|string
    {
        $quotation = $this->findModel($id);
        $quotation->scenario = Quotation::SCENARIO_UPDATE_BARANG_QUOTATION;

        $models = empty($quotation->quotationBarangs)
            ? [new QuotationBarang(['quotation_id' => $id])]
            : $quotation->quotationBarangs;

        if ($this->request->isPost && $quotation->load($this->request->post())) {

            $oldQuotationBarangsId = ArrayHelper::map($models, 'id', 'id');
            $models = Tabular::createMultiple(QuotationBarang::class, $models);

            Tabular::loadMultiple($models, $this->request->post());
            $deletedQuotationBarangsId = array_diff($oldQuotationBarangsId, array_filter(ArrayHelper::map($models, 'id', 'id')));

            $quotation->modelsQuotationBarang = $models;

            if ($quotation->validate() && Tabular::validateMultiple($models)) {
                $quotation->deletedQuotationBarangsId = $deletedQuotationBarangsId;
                if ($quotation->updateModelsQuotationBarang()) {
                    Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                    return $this->redirect(['quotation/view', 'id' => $quotation->id]);
                }
            }
            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }

        return $this->render('update_barang_quotation', [
            'quotation' => $quotation,
            'models' => $models,
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDeleteBarangQuotation($id): Response
    {
        $models = QuotationBarang::findAll([
            'quotation_id' => $id
        ]);
        array_walk($models, function ($item) {
            $item->delete();
        });
        Yii::$app->session->setFlash('success', [[
            'title' => 'Pesan Sistem',
            'message' => 'Sukses menghapus quotation barang ' . Quotation::findOne($id)->nomor,
        ]]);
        return $this->redirect(['quotation/view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionCreateServiceQuotation($id): Response|string
    {
        $quotation = $this->findModel($id);
        $quotation->scenario = Quotation::SCENARIO_CREATE_SERVICE_QUOTATION;
        $models = [new QuotationService([
            'quotation_id' => $quotation->id
        ])];

        if ($quotation->load($this->request->post())) {
            $models = Tabular::createMultiple(QuotationService::class);
            Tabular::loadMultiple($models, $this->request->post());

            $quotation->modelsQuotationService = $models;

            if ($quotation->validate() && Tabular::validateMultiple($models)) {
                if ($quotation->createModelsQuotationService()) {

                    Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                    return $this->redirect(['quotation/view', 'id' => $quotation->id]);
                }
            }

            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }


        return $this->render('create_service_quotation', [
            'quotation' => $quotation,
            'models' => $models,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdateServiceQuotation($id): Response|string
    {
        $quotation = $this->findModel($id);
        $quotation->scenario = Quotation::SCENARIO_UPDATE_SERVICE_QUOTATION;
        $models = !empty($quotation->quotationServices)
            ? $quotation->quotationServices
            : [new QuotationService(['quotation_id' => $id])];

        if ($this->request->isPost && $quotation->load($this->request->post())) {

            $oldQuotationServicesId = ArrayHelper::map($models, 'id', 'id');
            $models = Tabular::createMultiple(QuotationService::class, $models);

            Tabular::loadMultiple($models, $this->request->post());
            $deletedQuotationBarangsId = array_diff($oldQuotationServicesId, array_filter(ArrayHelper::map($models, 'id', 'id')));

            $quotation->modelsQuotationService = $models;
            $quotation->deletedQuotationServicesId = $deletedQuotationBarangsId;

            if ($quotation->validate() && Tabular::validateMultiple($models)) {
                if ($quotation->updateModelsQuotationService()) {
                    Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                    return $this->redirect(['quotation/view', 'id' => $quotation->id]);
                }

            }
            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }

        return $this->render('update_service_quotation', [
            'quotation' => $quotation,
            'models' => $models,
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDeleteServiceQuotation($id): Response
    {
        $models = QuotationService::findAll([
            'quotation_id' => $id
        ]);

        array_walk($models, function ($item) {
            $item->delete();
        });

        Yii::$app->session->setFlash('success', [[
            'title' => 'Pesan Sistem',
            'message' => 'Sukses menghapus quotation service ' . Quotation::findOne($id)->nomor,
        ]]);

        return $this->redirect(['quotation/view', 'id' => $id]);
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionCreateTermAndCondition($id): Response|string
    {
        $quotation = $this->findModel($id);
        $quotation->scenario = Quotation::SCENARIO_CREATE_TERM_AND_CONDITION;

        $models = [];
        if ($this->request->isGet) {

            $template = Yii::$app->settings->get('quotation.term_and_condition_template');
            if ($template) {
                foreach ($template as $item) {
                    $models[] = new QuotationTermAndCondition([
                        'quotation_id' => $id,
                        'term_and_condition' => $item
                    ]);
                }
            } else {
                $models[] = new QuotationTermAndCondition();
            }

        } else if ($this->request->isPost) {

            $models = Tabular::createMultiple(QuotationTermAndCondition::class);
            Tabular::loadMultiple($models, $this->request->post());

            $quotation->modelsQuotationTermAndCondition = $models;
            if (Tabular::validateMultiple($models)) {

                if ($quotation->createModelsTermAndCondition()) {
                    Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                    return $this->redirect(['quotation/view', 'id' => $quotation->id]);
                }
            }

            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }


        return $this->render('create_term_and_condition', [
            'quotation' => $quotation,
            'models' => $models,
        ]);
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdateTermAndCondition($id): Response|string
    {
        $quotation = $this->findModel($id);
        $quotation->scenario = Quotation::SCENARIO_UPDATE_TERM_AND_CONDITION;
        $models = !empty($quotation->quotationTermAndConditions) ? $quotation->quotationTermAndConditions :
            [new QuotationTermAndCondition([
                'quotation_id' => $id
            ])];

        if ($this->request->isPost) {

            $oldId = ArrayHelper::map($models, 'id', 'id');
            $models = Tabular::createMultiple(QuotationTermAndCondition::class, $models);

            Tabular::loadMultiple($models, $this->request->post());
            $deletedId = array_diff($oldId, array_filter(ArrayHelper::map($models, 'id', 'id')));

            $quotation->modelsQuotationTermAndCondition = $models;

            if (Tabular::validateMultiple($models)) {

                $quotation->deletedQuotationTermAndCondition = $deletedId;

                if ($quotation->updateModelsTermAndCondition()) {
                    Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                    return $this->redirect(['quotation/view', 'id' => $quotation->id]);
                }

            }
            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }

        return $this->render('update_term_and_condition', [
            'quotation' => $quotation,
            'models' => $models,
        ]);

    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDeleteTermAndCondition($id): Response
    {
        $models = QuotationTermAndCondition::findAll([
            'quotation_id' => $id
        ]);
        array_walk($models, function ($item) {
            $item->delete();
        });
        Yii::$app->session->setFlash('success', [[
            'title' => 'Pesan Sistem',
            'message' => 'Sukses menghapus term and condition ' . Quotation::findOne($id)->nomor,
        ]]);
        return $this->redirect(['quotation/view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionCreateFormJob($id): Response|string
    {
        $quotation = $this->findModel($id);
        $models = [new QuotationFormJob(['quotation_id' => $id])];

        if ($this->request->isPost) {

            $models = Tabular::createMultiple(QuotationFormJob::class);
            Tabular::loadMultiple($models, $this->request->post());

            $quotation->modelsFormJob = $models;
            if (Tabular::validateMultiple($models)) {

                if ($quotation->createModelsFormJob()) {
                    Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                    return $this->redirect(['quotation/view', 'id' => $quotation->id]);
                }
            }

            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }

        return $this->render('create_form_job', [
            'quotation' => $quotation,
            'models' => $models
        ]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdateFormJob($id): Response|string
    {

        $quotation = $this->findModel($id);
        $models = !empty($quotation->quotationFormJobs) ? $quotation->quotationFormJobs : [new QuotationFormJob(['quotation_id' => $quotation->id])];

        if ($this->request->isPost) {

            $oldId = ArrayHelper::map($models, 'id', 'id');
            $models = Tabular::createMultiple(QuotationFormJob::class, $models);

            Tabular::loadMultiple($models, $this->request->post());
            $deletedId = array_diff($oldId, array_filter(ArrayHelper::map($models, 'id', 'id')));

            $quotation->modelsFormJob = $models;
            if (Tabular::validateMultiple($models)) {

                $quotation->deletedFormJob = $deletedId;

                if ($quotation->updateModelsFormJob()) {
                    Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                    return $this->redirect(['quotation/view', 'id' => $quotation->id]);
                }

            }
            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }

        return $this->render('update_form_job', [
            'quotation' => $quotation,
            'models' => $models
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDeleteFormJob($id): Response
    {

        $models = QuotationFormJob::findAll([
            'quotation_id' => $id
        ]);

        array_walk($models, function ($item) {
            $item->delete();
        });

        Yii::$app->session->setFlash('success', [[
            'title' => 'Pesan Sistem',
            'message' => 'Sukses menghapus form job ' . Quotation::findOne($id)->nomor,
        ]]);

        return $this->redirect(['quotation/view', 'id' => $id]);
    }

    public function actionPrintFormJobs($id): string
    {
        $quotation = $this->findModel($id);

        $this->layout = 'print';
        return $this->render('preview_print_form_jobs', [
            'quotation' => $this->findModel($id),
            'quotationFormJobs' => $quotation->quotationFormJobs
        ]);
    }

}