<?php

namespace app\controllers;

use bilberrry\spaces\Service;
use Yii;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\RangeNotSatisfiableHttpException;
use yii\web\Response;


/**
 * Class untuk meng-handle S3
 * Fitur-fitur:
 *  - Index list file
 *      - Pagination
 *      - Search
 *  - Buat Folder              [DONE]
 *  - Upload file              [DONE]
 *  - Download file
 *  - Move to folder
 *  - Delete file | folder     [DONE]
 * */
class SpacesController extends Controller
{


    public function actionIndex($path = null)
    {
        $contents = Yii::$app->aws->listContents((!isset($path)
            ? Yii::$app->params['awsRootPath']
            : $path)
        );
        return $this->render('index', [
            'contents' => $contents
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionCreateNewFolder($root = null): Response|string
    {
        $model = new DynamicModel([
            'nama_folder'
        ]);

        $model->addRule('nama_folder', 'required');

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {

            $storage = Yii::$app->spaces;
            $storage->commands()
                ->put($root . $model->nama_folder . '/', 'body')
                ->execute();

            return $this->redirect(['index', 'path' => $root]);
        }

        return $this->render('_form_create_folder', [
            'model' => $model
        ]);
    }

    public function actionUploadFile($root = null): string
    {
        return $this->render('_form_upload_dokumen_pendukung', ['root' => $root]);
    }

    public function actionHandleUpload()
    {
        if (empty($_FILES['file_data'])) {
            echo Json::encode(['error', 'No files found for upload']);
            return;
        }

        $files = $_FILES['file_data'];
        $request = Yii::$app->request;
        $storage = Yii::$app->spaces;

        $filename = $request->post('root') . '/' . $files['name'];
        $storage->commands()
            ->upload($filename, $files['tmp_name'])
            ->execute();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return empty($files["error"][0])
            ? ['success', $files]
            : ['error', 'Error While uploading image, contact the system administrator' . $files["error"]];
    }

    /**
     * @param $key
     * @return \yii\console\Response|Response
     * @throws InvalidConfigException
     * @throws RangeNotSatisfiableHttpException
     */
    public function actionDownloadFile($key): Response|\yii\console\Response
    {

        /** @var Service $storage */
        $storage = Yii::$app->get('spaces');
        $result = $storage->get($key);

        return Yii::$app->response->sendContentAsFile(
            $result['Body'],
            basename($key)
        );
    }


    /**
     * @param $key
     * @return Response
     * @throws InvalidConfigException
     */
    public function actionDelete($key, $type)
    {

        $aws = Yii::$app->aws;
        if ($type === 'dir') {
            Yii::$app->aws->deleteDir($key);
        } else {
            Yii::$app->aws->delete($key);
        }
        return $this->redirect(['spaces/index']);
    }
}