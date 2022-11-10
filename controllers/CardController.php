<?php

namespace app\controllers;

use app\models\Card;
use app\models\CardBelongsType;
use app\models\search\CardSearch;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Card models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new CardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = [
            'pageSize' => 12
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Card model.
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
     * Finds the Card model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Card the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Card
    {
        if (($model = Card::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Card model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreate(): Response|string
    {
        $model = new Card();
        $model->scenario = Card::SCENARIO_CREATE_AND_UPDATE;

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                $transaction = Yii::$app->db->beginTransaction();

                if ($flag = $model->save(false)) {

                    foreach ($model->cardBelongsTypesForm as $cardType) {

                        $cbt = new CardBelongsType([
                            'card_id' => $model->id,
                            'card_type_id' => $cardType
                        ]);

                        $flag = $cbt->save(false) && $flag;

                        if (!$flag) {
                            break;
                        }
                    }
                }

                if ($flag) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }


                Yii::$app->session->setFlash('success', 'Card: ' . $model->nama . ' berhasil ditambahkan.');
                return $this->redirect(['card/view', 'id' => $model->id]);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Card model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $model->scenario = Card::SCENARIO_CREATE_AND_UPDATE;
        $model->cardBelongsTypesForm = $oldCardBelongsTypesFormID = ArrayHelper::map(
            $model->cardBelongsTypes,
            'card_type_id',
            'card_type_id'
        );

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {

            $deletedCardBelongsTypeID = array_diff(
                $oldCardBelongsTypesFormID,
                $model->cardBelongsTypesForm
            );
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($flag = $model->save(false)) {

                    if (!empty($deletedCardBelongsTypeID)) {
                        CardBelongsType::deleteAll(['AND', 'card_id = :card_id',
                            ['IN', 'card_type_id', $deletedCardBelongsTypeID]], [':card_id' => $id
                        ]);

                    }

                    foreach ($model->cardBelongsTypesForm as $cardType) {

                        $exist = CardBelongsType::find()
                            ->where([
                                'card_id' => $id,
                                'card_type_id' => $cardType
                            ])
                            ->exists();

                        if (!$exist) {
                            $cbt = new CardBelongsType([
                                'card_id' => $model->id,
                                'card_type_id' => $cardType
                            ]);

                            $flag = $cbt->save(false) && $flag;
                        }

                        if (!$flag) {
                            break;
                        }
                    }
                }

                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('info', 'Card: ' . Html::a($model->nama, ['card/view', 'id' => $model->id, [
                            'class' => 'btn btn-link'
                        ]]) . ' berhasil dirubah.');

                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('danger', "Rollback");
                }

            } catch (Exception $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Card model.
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

        Yii::$app->session->setFlash('danger', 'Card: ' . $model->nama . ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    public function actionDepdropFindMataUangByCardId(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $out = Card::find()->mataUang($parents[0]);
                if (isset($out[0])) {
                    return ['output' => $out, 'selected' => $out[0]];
                }
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }


}