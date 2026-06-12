<?php

namespace app\components\services;

use app\components\helpers\ArrayHelper;
use app\models\Quotation;
use app\models\QuotationFormJob;
use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidRouteException;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class QuotationFormJobService {

    /**
     * Load Quotation by id or throw 404
     * @param int $id
     * @return Quotation
     * @throws NotFoundHttpException
     */
    protected function findQuotation(int $id): Quotation {
        $model = Quotation::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Handle create Form Job flow.
     * - GET: returns ['view' => 'create_form_job', 'params' => [...]]
     * - POST success: returns Response redirect to tab 4
     * - POST fail: sets flash and returns same view params
     * @param int $quotationId
     * @return array|Response
     * @throws NotFoundHttpException|InvalidRouteException
     */
    public function create(int $quotationId): array|Response {
        $quotation = $this->findQuotation($quotationId);
        $model = new QuotationFormJob(['quotation_id' => $quotation->id]);
        $model->scenario = QuotationFormJob::SCENARIO_CREATE_UPDATE;

        $request = Yii::$app->request;
        if ($request->isPost && $model->load($request->post()) && $model->validate()) {
            if ($model->createFormJob()) {
                Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                return Yii::$app->getResponse()->redirect([
                    'quotation/view',
                    'id' => $quotation->id,
                    '#'  => 'quotation-tab-tab4'
                ]);
            }
            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }

        return [
            'view'   => 'create_form_job',
            'params' => [
                'quotation' => $quotation,
                'model'     => $model,
            ],
        ];
    }

    /**
     * Handle update Form Job flow.
     * - GET: returns ['view' => 'update_form_job', 'params' => [...]]
     * - POST success: Response redirect to tab 4
     * - POST fail: sets flash and returns same view params
     * @param int $quotationId
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws InvalidRouteException|Throwable
     */
    public function update(int $quotationId): array|Response {
        $quotation = $this->findQuotation($quotationId);
        if (!empty($quotation->quotationFormJob)) {
            $model = $quotation->quotationFormJob;
            // preload mekaniksId for form
            $model->mekaniksId = ArrayHelper::getColumn($model->quotationFormJobMekaniks, 'mekanik_id');
        } else {
            $model = new QuotationFormJob(['quotation_id' => $quotation->id]);
        }
        $model->scenario = QuotationFormJob::SCENARIO_CREATE_UPDATE;

        $request = Yii::$app->request;
        if ($request->isPost && $model->load($request->post()) && $model->validate()) {
            if ($model->updateFormJob()) {
                Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
                return Yii::$app->getResponse()->redirect([
                    'quotation/view',
                    'id' => $quotation->id,
                    '#'  => 'quotation-tab-tab4'
                ]);
            }
            Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
        }

        return [
            'view'   => 'update_form_job',
            'params' => [
                'quotation' => $quotation,
                'model'     => $model,
            ],
        ];
    }

    /**
     * Delete Form Job(s) for a quotation and redirect back to tab 4.
     * @param int $quotationId
     * @return Response
     * @throws InvalidRouteException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function delete(int $quotationId): Response {
        $models = QuotationFormJob::findAll(['quotation_id' => $quotationId]);
        foreach ($models as $m) {
            $m->delete();
        }
        $q = Quotation::findOne($quotationId);
        if ($q) {
            Yii::$app->session->setFlash('success', [[
                'title'   => 'Pesan Sistem',
                'message' => 'Sukses menghapus form job ' . $q->nomor,
            ]]);
        }
        return Yii::$app->getResponse()->redirect([
            'quotation/view',
            'id' => $quotationId,
            '#'  => 'quotation-tab-tab4'
        ]);
    }

    /**
     * Render printable Form Job for a quotation via mPDF.
     * @param int $quotationId
     * @return string
     * @throws NotFoundHttpException
     * @throws CrossReferenceException
     * @throws InvalidConfigException
     * @throws MpdfException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function print(int $quotationId): string {
        $quotation = $this->findQuotation($quotationId);
        /** @var Pdf $pdf */
        $pdf = Yii::$app->pdfWithLetterhead;
        $pdf->content = Yii::$app->controller->renderPartial('preview_print_form_job', [
            'quotation'        => $quotation,
            'quotationFormJob' => $quotation->quotationFormJob,
        ]);
        return $pdf->render();
    }
}