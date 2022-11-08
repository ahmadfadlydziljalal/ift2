<?php

namespace app\controllers;

use app\models\ClaimPettyCash;
use app\models\ClaimPettyCashNota;
use app\models\ClaimPettyCashNotaDetail;
use app\models\search\ClaimPettyCashSearch;
use app\models\Tabular;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ClaimPettyCashController implements the CRUD actions for ClaimPettyCash model.
 */
class ClaimPettyCashController extends Controller
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
     * Lists all ClaimPettyCash models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ClaimPettyCashSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single ClaimPettyCash model.
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
     * Finds the ClaimPettyCash model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClaimPettyCash the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): ClaimPettyCash
    {
        if (($model = ClaimPettyCash::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new ClaimPettyCash model.
     * @return Response | string
     * @throws HttpException
     * @throws InvalidConfigException
     */
    public function actionCreate(): Response|string
    {
        $request = Yii::$app->request;
        $model = new ClaimPettyCash();
        $modelsDetail = [new ClaimPettyCashNota()];
        $modelsDetailDetail = [[new ClaimPettyCashNotaDetail()]];

        if ($model->load($request->post())) {

            $modelsDetail = Tabular::createMultiple(ClaimPettyCashNota::class);
            Tabular::loadMultiple($modelsDetail, $request->post());

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if (isset($_POST['ClaimPettyCashNotaDetail'][0][0])) {
                foreach ($_POST['ClaimPettyCashNotaDetail'] as $i => $claimPettyCashNotaDetails) {
                    foreach ($claimPettyCashNotaDetails as $j => $claimPettyCashNotaDetail) {
                        $data['ClaimPettyCashNotaDetail'] = $claimPettyCashNotaDetail;
                        $modelClaimPettyCashNotaDetail = new ClaimPettyCashNotaDetail();
                        $modelClaimPettyCashNotaDetail->load($data);
                        $modelsDetailDetail[$i][$j] = $modelClaimPettyCashNotaDetail;
                        $isValid = $modelClaimPettyCashNotaDetail->validate() && $isValid;
                    }
                }
            }

            if ($isValid) {

                $transaction = ClaimPettyCash::getDb()->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {
                        foreach ($modelsDetail as $i => $detail) :

                            if ($flag === false) {
                                break;
                            }

                            $detail->claim_petty_cash_id = $model->id;
                            if (!($flag = $detail->save(false))) {
                                break;
                            }

                            if (isset($modelsDetailDetail[$i]) && is_array($modelsDetailDetail[$i])) {
                                foreach ($modelsDetailDetail[$i] as $modelDetailDetail) {
                                    $modelDetailDetail->claim_petty_cash_nota_id = $detail->id;
                                    if (!($flag = $modelDetailDetail->save(false))) {
                                        break;
                                    }
                                }
                            }

                        endforeach;
                    }

                    if ($flag) {
                        $transaction->commit();
                        $status = [
                            'code' => 1,
                            'message' => 'Commit'
                        ];
                    } else {
                        $transaction->rollBack();
                        $status = [
                            'code' => 0,
                            'message' => 'Roll Back'
                        ];
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $status = [
                        'code' => 0,
                        'message' => 'Roll Back ' . $e->getMessage(),
                    ];
                }

                if ($status['code']) {
                    Yii::$app->session->setFlash('success', 'ClaimPettyCash: ' . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil ditambahkan.");
                    return $this->redirect(['claim-petty-cash/view', 'id' => $model->id]);
                }

                Yii::$app->session->setFlash('danger', " ClaimPettyCash is failed to insert. Info: " . $status['message']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsDetail' => empty($modelsDetail) ? [new ClaimPettyCashNota()] : $modelsDetail,
            'modelsDetailDetail' => empty($modelsDetailDetail) ? [[new ClaimPettyCashNotaDetail()]] : $modelsDetailDetail,
        ]);
    }

    /**
     * Updates an existing ClaimPettyCash model.
     * Only for ajax request will return json object
     * @param integer $id
     * @return Response | string
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    public function actionUpdate(int $id): Response|string
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsDetail = !empty($model->claimPettyCashNotas) ? $model->claimPettyCashNotas : [new ClaimPettyCashNota()];

        $modelsDetailDetail = [];
        $oldDetailDetails = [];

        if (!empty($modelsDetail)) {

            foreach ($modelsDetail as $i => $modelDetail) {
                $claimPettyCashNotaDetails = $modelDetail->claimPettyCashNotaDetails;
                $modelsDetailDetail[$i] = $claimPettyCashNotaDetails;
                $oldDetailDetails = ArrayHelper::merge(ArrayHelper::index($claimPettyCashNotaDetails, 'id'), $oldDetailDetails);
            }
        }


        if ($model->load($request->post())) {

            // reset
            $modelsDetailDetail = [];

            // GET OLD IDs
            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');

            $modelsDetail = Tabular::createMultiple(ClaimPettyCashNota::class, $modelsDetail);
            Tabular::loadMultiple($modelsDetail, $request->post());

            $deletedDetailsID = array_diff($oldDetailsID, array_filter(
                    ArrayHelper::map($modelsDetail, 'id', 'id')
                )
            );

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            $detailDetailIDs = [];
            if (isset($_POST['ClaimPettyCashNotaDetail'][0][0])) {
                foreach ($_POST['ClaimPettyCashNotaDetail'] as $i => $claimPettyCashNotaDetails) {

                    $detailDetailIDs = ArrayHelper::merge($detailDetailIDs, array_filter(ArrayHelper::getColumn($claimPettyCashNotaDetails, 'id')));

                    foreach ($claimPettyCashNotaDetails as $j => $claimPettyCashNotaDetail) {
                        $data['ClaimPettyCashNotaDetail'] = $claimPettyCashNotaDetail;

                        // Difference with actionCreate Here
                        $modelClaimPettyCashNotaDetail =
                            (isset($claimPettyCashNotaDetail['id']) && isset($oldDetailDetails[$claimPettyCashNotaDetail['id']]))
                                ? $oldDetailDetails[$claimPettyCashNotaDetail['id']]
                                : new ClaimPettyCashNotaDetail();

                        $modelClaimPettyCashNotaDetail->load($data);
                        $modelsDetailDetail[$i][$j] = $modelClaimPettyCashNotaDetail;
                        $isValid = $modelClaimPettyCashNotaDetail->validate() && $isValid;
                    }
                }
            }

            $oldDetailDetailsIDs = ArrayHelper::getColumn($oldDetailDetails, 'id');
            $deletedDetailDetailsIDs = array_diff($oldDetailDetailsIDs, $detailDetailIDs);

            if ($isValid) {

                $transaction = ClaimPettyCash::getDb()->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {

                        if (!empty($deletedDetailDetailsIDs)) {
                            ClaimPettyCashNotaDetail::deleteAll(['id' => $deletedDetailDetailsIDs]);
                        }

                        if (!empty($deletedDetailsID)) {
                            ClaimPettyCashNota::deleteAll(['id' => $deletedDetailsID]);
                        }

                        foreach ($modelsDetail as $i => $detail) :

                            if ($flag === false) {
                                break;
                            }

                            $detail->claim_petty_cash_id = $model->id;
                            if (!($flag = $detail->save(false))) {
                                break;
                            }

                            if (isset($modelsDetailDetail[$i]) && is_array($modelsDetailDetail[$i])) {
                                foreach ($modelsDetailDetail[$i] as $modelDetailDetail) {
                                    $modelDetailDetail->claim_petty_cash_nota_id = $detail->id;
                                    if (!($flag = $modelDetailDetail->save(false))) {
                                        break;
                                    }
                                }
                            }

                        endforeach;
                    }

                    if ($flag) {
                        $transaction->commit();
                        $status = [
                            'code' => 1,
                            'message' => 'Commit'
                        ];
                    } else {
                        $transaction->rollBack();
                        $status = [
                            'code' => 0,
                            'message' => 'Roll Back'
                        ];
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $status = [
                        'code' => 0,
                        'message' => 'Roll Back ' . $e->getMessage(),
                    ];
                }

                if ($status['code']) {
                    Yii::$app->session->setFlash('info', "ClaimPettyCash: " . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil di update.");
                    return $this->redirect(['claim-petty-cash/view', 'id' => $id]);
                }

                Yii::$app->session->setFlash('danger', " ClaimPettyCash is failed to insert. Info: " . $status['message']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsDetail' => $modelsDetail,
            'modelsDetailDetail' => $modelsDetailDetail,
        ]);
    }

    /**
     * Delete an existing ClaimPettyCash model.
     * Only for ajax request will return json object
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

        Yii::$app->session->setFlash('danger', 'ClaimPettyCash: ' . $model->nomor . ' berhasil dihapus.');
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

}