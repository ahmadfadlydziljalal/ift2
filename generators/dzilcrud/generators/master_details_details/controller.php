<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\db\ActiveRecordInterface;


/* @var $this yii\web\View */
/* @var $generator \app\generators\dzilcrud\generators\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}


/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
$labelID =
    !isset($generator->labelID) ? $generator->getNameAttribute() : (empty($generator->labelID) ? $generator->getNameAttribute() : $generator->labelID);

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
<?php if (!empty($generator->modelsClassDetail)): ?>
<?php $modelsDetail = StringHelper::basename($generator->modelsClassDetail); ?>
use <?= ltrim($generator->modelsClassDetail, '\\') ?>;
<?php endif; ?>
<?php if (!empty($generator->modelsClassDetailDetail)): ?>
<?php $modelsDetailDetail = StringHelper::basename($generator->modelsClassDetailDetail); ?>
use <?= ltrim($generator->modelsClassDetailDetail, '\\') ?>;
<?php endif; ?>
use app\models\Tabular;
use Throwable;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\StaleObjectException;
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public function behaviors() : array
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
     * Lists all <?= $modelClass ?> models.
     * @return string
     */
    public function actionIndex() : string
    {
       <?php if (!empty($generator->searchModelClass)): ?>
 $searchModel = new <?= $searchModelAlias ?? $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }


    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return string
     * @throws HttpException
     */
    public function actionView(<?= $actionParams === '$id' ? "int " . $actionParams : $actionParams ?>) : string
    {
        return $this->render('view', [
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * @return Response | string
     * @throws HttpException
     * @throws InvalidConfigException
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new <?= $modelClass ?>();
        $modelsDetail = [ new <?= $modelsDetail ?>() ];
        $modelsDetailDetail =[[new <?= $modelsDetailDetail ?>()]];

        if($model->load($request->post())){

            $modelsDetail = Tabular::createMultiple(<?= $modelsDetail ?>::class);
            Tabular::loadMultiple($modelsDetail, $request->post());

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if (isset($_POST['<?= $modelsDetailDetail ?>'][0][0])) {
                foreach ($_POST['<?= $modelsDetailDetail ?>'] as $i => $<?= lcfirst(Inflector::pluralize($modelsDetailDetail))  ?>) {
                    foreach ($<?= lcfirst(Inflector::pluralize($modelsDetailDetail))  ?> as $j => $<?= lcfirst(Inflector::singularize($modelsDetailDetail))  ?>) {
                        $data['<?= $modelsDetailDetail ?>'] = $<?= lcfirst(Inflector::singularize($modelsDetailDetail))  ?>;
                        $model<?= ucfirst(Inflector::singularize($modelsDetailDetail)) ?> = new <?= $modelsDetailDetail ?>();
                        $model<?= ucfirst(Inflector::singularize($modelsDetailDetail)) ?>->load($data);
                        $modelsDetailDetail[$i][$j] = $model<?= ucfirst(Inflector::singularize($modelsDetailDetail)) ?>;
                        $isValid = $model<?= ucfirst(Inflector::singularize($modelsDetailDetail)) ?>->validate() && $isValid;
                    }
                }
            }

            if($isValid){

                $transaction = <?= $modelClass ?>::getDb()->beginTransaction();

                try{

                    if ($flag = $model->save(false)) {
                        foreach ($modelsDetail as $i => $detail) :

                            if ($flag === false) {
                                break;
                            }

                            $detail-><?= Inflector::underscore(StringHelper::basename($generator->modelClass)). '_id' ?> = $model->id;
                            if (!($flag = $detail->save(false))) {
                                break;
                            }

                            if (isset($modelsDetailDetail[$i]) && is_array($modelsDetailDetail[$i])) {
                                foreach ($modelsDetailDetail[$i] as $modelDetailDetail) {
                                    $modelDetailDetail-><?= Inflector::underscore(StringHelper::basename($generator->modelsClassDetail)). '_id' ?> = $detail->id;
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
                }catch (Exception $e){
                    $transaction->rollBack();
                    $status = [
                        'code' => 0,
                        'message' => 'Roll Back ' . $e->getMessage(),
                    ];
                }

                if($status['code']){
                   Yii::$app->session->setFlash('success','<?= $modelClass ?>: ' . Html::a(<?= '$model->' . $labelID ?>,  ['view', <?= $urlParams ?>]) . " berhasil ditambahkan.");
                    return $this->redirect(['index']);
                }

                Yii::$app->session->setFlash('danger',  " <?= $modelClass ?> is failed to insert. Info: ". $status['message']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsDetail' => empty($modelsDetail) ? [ new <?= $modelsDetail ?>() ] : $modelsDetail,
            'modelsDetailDetail' => empty($modelsDetailDetail) ? [[new <?= $modelsDetailDetail ?>()]] : $modelsDetailDetail,
        ]);
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * Only for ajax request will return json object
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return Response | string
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    public function actionUpdate(<?= $actionParams === '$id' ? "int " . $actionParams : $actionParams ?>){
        $request = Yii::$app->request;
        $model = $this->findModel(<?= $actionParams ?>);
        $modelsDetail = !empty($model-><?= $details = lcfirst(Inflector::camelize(Inflector::pluralize(StringHelper::basename($modelsDetail)))) ?>) ?$model-><?= $details ?> :[new <?= $modelsDetail ?>()];

        $modelsDetailDetail =[];
        $oldDetailDetails = [];

        if (!empty($modelsDetail)) {

            foreach ($modelsDetail as $i => $modelDetail) {
                $<?= $detailDetails = lcfirst(Inflector::camelize(Inflector::pluralize(StringHelper::basename($modelsDetailDetail)))) ?> = $modelDetail-><?= $detailDetails ?>;
                $modelsDetailDetail[$i] = $<?= $detailDetails ?>;
                $oldDetailDetails = ArrayHelper::merge(ArrayHelper::index($<?= $detailDetails ?>, 'id'), $oldDetailDetails);
            }
        }

        if($model->load($request->post())){

            // reset
            $modelsDetailDetail = [];

            // GET OLD IDs
            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');

            $modelsDetail=Tabular::createMultiple(<?= $modelsDetail ?>::class, $modelsDetail);
            Tabular::loadMultiple($modelsDetail, $request->post());

            $deletedDetailsID = array_diff($oldDetailsID,array_filter(
                    ArrayHelper::map($modelsDetail, 'id', 'id')
                )
            );

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            $detailDetailIDs = [];
            if (isset($_POST['<?= $modelsDetailDetail ?>'][0][0])) {
                foreach ($_POST['<?= $modelsDetailDetail ?>'] as $i => $<?= lcfirst(Inflector::pluralize($modelsDetailDetail))  ?>) {

                    $detailDetailIDs = ArrayHelper::merge($detailDetailIDs, array_filter(ArrayHelper::getColumn($<?= lcfirst(Inflector::pluralize($modelsDetailDetail))  ?>, 'id')));

                    foreach ($<?= lcfirst(Inflector::pluralize($modelsDetailDetail))  ?> as $j => $<?= lcfirst(Inflector::singularize($modelsDetailDetail))  ?>) {
                        $data['<?= $modelsDetailDetail ?>'] = $<?= lcfirst(Inflector::singularize($modelsDetailDetail))  ?>;

                        // Difference with actionCreate Here
                        $model<?= ucfirst(Inflector::singularize($modelsDetailDetail)) ?> =
                            (isset($<?= lcfirst(Inflector::singularize($modelsDetailDetail)) ?>['id']) && isset($oldDetailDetails[$<?= lcfirst(Inflector::singularize($modelsDetailDetail)) ?>['id']]))
                            ? $oldDetailDetails[$<?= lcfirst(Inflector::singularize($modelsDetailDetail)) ?>['id']]
                            : new <?= $modelsDetailDetail ?>();

                        $model<?= ucfirst(Inflector::singularize($modelsDetailDetail)) ?>->load($data);
                        $modelsDetailDetail[$i][$j] = $model<?= ucfirst(Inflector::singularize($modelsDetailDetail)) ?>;
                        $isValid = $model<?= ucfirst(Inflector::singularize($modelsDetailDetail)) ?>->validate() && $isValid;
                    }
                }
            }

            $oldDetailDetailsIDs = ArrayHelper::getColumn($oldDetailDetails, 'id');
            $deletedDetailDetailsIDs = array_diff($oldDetailDetailsIDs, $detailDetailIDs);

            if($isValid){

                $transaction = <?= $modelClass ?>::getDb()->beginTransaction();

                try{

                    if ($flag = $model->save(false)) {

                        if (!empty($deletedDetailDetailsIDs)) {
                            <?= $modelsDetailDetail ?>::deleteAll(['id' => $deletedDetailDetailsIDs]);
                        }

                        if (!empty($deletedDetailsID)) {
                            <?= $modelsDetail ?>::deleteAll(['id' => $deletedDetailsID]);
                        }

                        foreach ($modelsDetail as $i => $detail) :

                            if ($flag === false) {
                                break;
                            }

                            $detail-><?= Inflector::underscore(StringHelper::basename($generator->modelClass)). '_id' ?> = $model->id;
                            if (!($flag = $detail->save(false))) {
                                break;
                            }

                            if (isset($modelsDetailDetail[$i]) && is_array($modelsDetailDetail[$i])) {
                                foreach ($modelsDetailDetail[$i] as $modelDetailDetail) {
                                    $modelDetailDetail-><?= Inflector::underscore(StringHelper::basename($generator->modelsClassDetail)). '_id' ?> = $detail->id;
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
                }catch (Exception $e){
                    $transaction->rollBack();
                    $status = [
                        'code' => 0,
                        'message' => 'Roll Back ' . $e->getMessage(),
                    ];
                }

                if($status['code']){
                    Yii::$app->session->setFlash('info',"<?= $modelClass ?>: ".Html::a(<?= '$model->' . $labelID ?>, ['view', <?= $urlParams ?>]) . " berhasil di update.");
                    return $this->redirect(['index']);
                }

                Yii::$app->session->setFlash('danger', " <?= $modelClass ?> is failed to insert. Info: ". $status['message']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsDetail' => $modelsDetail,
            'modelsDetailDetail' => $modelsDetailDetail,
        ]);
    }

    /**
     * Delete an existing <?= $modelClass ?> model.
     * Only for ajax request will return json object
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return Response
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(<?= $actionParams !== '$id' ? $actionParams : 'int ' . $actionParams  ?>) : Response {
        $model = $this->findModel(<?= $actionParams ?>);
        $model->delete();

        Yii::$app->session->setFlash('danger',  '<?= $modelClass ?>: ' . <?=  '$model->' . $labelID ?>.  ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
    * Finds the <?= $modelClass ?> model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
    * @return <?= $modelClass ?> the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel(<?= $actionParams !== '$id' ? $actionParams : 'int ' . $actionParams  ?>) : <?= $modelClass ?>
    {
    <?php
    if (count($pks) === 1) {
        $condition = '$id';
    } else {
        $condition = [];
        foreach ($pks as $pk) {
            $condition[] = "'$pk' => \$$pk";
        }
        $condition = '[' . implode(', ', $condition) . ']';
    }
    ?>  if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
      } else {
        throw new NotFoundHttpException('The requested page does not exist.');
      }
    }

}