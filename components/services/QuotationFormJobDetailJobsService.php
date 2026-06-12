<?php

namespace app\components\services;

use app\models\QuotationFormJob;
use app\models\QuotationFormJobJobs;
use app\models\Tabular;
use Throwable;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * Service layer to handle all database interactions for Quotation Form Job details
 * (both Jobs and Spare Part types). Controllers should delegate to this service
 * to comply with Single Responsibility (no direct DB operations in controllers).
 */
class QuotationFormJobDetailJobsService {

    /**
     * Prepare context for Create page (GET).
     * @param int $formJobId QuotationFormJob ID
     * @return array{quotationFormJobModel: QuotationFormJob, models: QuotationFormJobJobs[]}
     */
    public function getCreateContext(int $formJobId): array {
        $quotationFormJobModel = QuotationFormJob::findOne($formJobId);
        if (!$quotationFormJobModel) {
            throw new InvalidArgumentException('Quotation Form Job not found');
        }
        $models = [new QuotationFormJobJobs([
            'quotation_form_job_id' => $formJobId,
        ])];
        return compact('quotationFormJobModel', 'models');
    }

    /**
     * Handle Create (POST) for tabular QuotationFormJobJobs/SparePart.
     * Returns operation result and context for re-render when failed.
     *
     * @param int $formJobId
     * @param int $type
     * @param array $post
     * @return array{success: bool, quotationFormJobModel: QuotationFormJob, models: QuotationFormJobJobs[], quotationId?: int}
     * @throws Exception
     */
    public function create(int $formJobId, array $post): array {
        $quotationFormJobModel = QuotationFormJob::findOne($formJobId);
        if (!$quotationFormJobModel) {
            throw new InvalidArgumentException('Quotation Form Job not found');
        }

        $models = Tabular::createMultiple(QuotationFormJobJobs::class);
        Tabular::loadMultiple($models, $post);

        if (!Tabular::validateMultiple($models)) {
            return [
                'success'               => false,
                'quotationFormJobModel' => $quotationFormJobModel,
                'models'                => $models,
            ];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $flag = true;
            /** @var QuotationFormJobJobs $model */
            foreach ($models as $model) {
                $model->quotation_form_job_id = $formJobId;
                if (!($flag = $model->save(false))) {
                    break;
                }
            }

            if ($flag) {
                $transaction->commit();
                return [
                    'success'               => true,
                    'quotationFormJobModel' => $quotationFormJobModel,
                    'models'                => $models,
                    'quotationId'           => $quotationFormJobModel->quotation_id,
                ];
            }

            $transaction->rollBack();
        } catch (Throwable $e) {
            Yii::error($e->getMessage(), __METHOD__);
            $transaction->rollBack();
        }

        return [
            'success'               => false,
            'quotationFormJobModel' => $quotationFormJobModel,
            'models'                => $models,
        ];
    }

    /**
     * Prepare context for Update page (GET): existing detail rows for a given type.
     * @param int $formJobId
     * @return array{quotationFormJobModel: QuotationFormJob, models: QuotationFormJobJobs[]}
     */
    public function getUpdateContext(int $formJobId): array {
        $quotationFormJobModel = QuotationFormJob::findOne($formJobId);
        if (!$quotationFormJobModel) {
            throw new InvalidArgumentException('Quotation Form Job not found');
        }

        $models = $quotationFormJobModel->quotationFormJobJobs;
        return compact('quotationFormJobModel', 'models');
    }

    /**
     * Handle Update (POST) for tabular details with add/update/delete semantics.
     * @param int $formJobId
     * @param array $post
     * @return array{success: bool, quotationFormJobModel: QuotationFormJob, models: QuotationFormJobJobs[], quotationId?: int}
     */
    public function update(int $formJobId, array $post): array {
        $quotationFormJobModel = QuotationFormJob::findOne($formJobId);
        if (!$quotationFormJobModel) {
            throw new InvalidArgumentException('Quotation Form Job not found');
        }

        $existing = $quotationFormJobModel->quotationFormJobJobs;

        $oldDetailsID = ArrayHelper::map($existing, 'id', 'id');
        $models = Tabular::createMultiple(QuotationFormJobJobs::class, $existing);
        Tabular::loadMultiple($models, $post);
        $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($models, 'id', 'id')));

        if (!Tabular::validateMultiple($models)) {
            return [
                'success'               => false,
                'quotationFormJobModel' => $quotationFormJobModel,
                'models'                => $models,
            ];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $flag = true;
            foreach ($models as $model) {
                $model->quotation_form_job_id = $formJobId;
                if (!($flag = $model->save(false))) {
                    break;
                }
            }

            if ($flag) {
                if (!empty($deletedDetailsID)) {
                    QuotationFormJobJobs::deleteAll([
                        'id' => $deletedDetailsID,
                    ]);
                }
                $transaction->commit();
                return [
                    'success'               => true,
                    'quotationFormJobModel' => $quotationFormJobModel,
                    'models'                => $models,
                    'quotationId'           => $quotationFormJobModel->quotation_id,
                ];
            }

            $transaction->rollBack();
        } catch (Throwable $e) {
            Yii::error($e->getMessage(), __METHOD__);
            $transaction->rollBack();
        }

        return [
            'success'               => false,
            'quotationFormJobModel' => $quotationFormJobModel,
            'models'                => $models,
        ];
    }

    /**
     * Delete all details of a given type for a Form Job.
     * @param int $formJobId
     * @return array{success: bool, quotationId?: int, affected: int}
     */
    public function delete(int $formJobId): array {
        $quotationFormJobModel = QuotationFormJob::findOne($formJobId);
        if (!$quotationFormJobModel) {
            throw new InvalidArgumentException('Quotation Form Job not found');
        }
        $affected = QuotationFormJobJobs::deleteAll([
            'quotation_form_job_id' => $formJobId,
        ]);
        return [
            'success'     => $affected > 0,
            'quotationId' => $quotationFormJobModel->quotation_id,
            'affected'    => $affected,
        ];
    }
}