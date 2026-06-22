<?php

namespace app\actions\material_requisition;

use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DeletePenawaranAction extends Action {

    public function run($materialRequisitionDetailId) {
        $modelMaterialRequisitionDetail = $this->findModelDetail($materialRequisitionDetailId);
        $count = MaterialRequisitionDetailPenawaran::deleteAll([
            'material_requisition_detail_id' => $materialRequisitionDetailId
        ]);

        // Jika request via PJAX/Ajax: kembalikan potongan HTML yang sama dengan konten PJAX container
        if (Yii::$app->request->isPjax || Yii::$app->request->isAjax) {
            // Tidak perlu set format JSON; biarkan HTML agar Pjax bisa mengganti kontainer
            $materialRequisition = $modelMaterialRequisitionDetail->materialRequisition;
            // Optional: bisa set flash untuk ditampilkan di luar PJAX
            // Yii::$app->session->setFlash('success', $count . ' records penawaran berhasil dibatalkan.');
            return $this->controller->renderPartial('@app/views/material-requisition/_view_penawaran_harga', [
                'model' => $materialRequisition,
            ]);
        }

        // Fallback non-Ajax: behavior lama (flash + redirect)
        Yii::$app->session->setFlash('success', $count . ' records penawaran berhasil dibatalkan.');
        return $this->controller->redirect([
            'material-requisition/view',
            'id' => $modelMaterialRequisitionDetail->material_requisition_id,
            '#'  => 'material-requisition-tab-tab1'
        ]);
    }


    /**
     * @param $materialRequisitionDetailId
     * @return MaterialRequisitionDetail|null
     * @throws NotFoundHttpException
     */
    protected function findModelDetail($materialRequisitionDetailId): ?MaterialRequisitionDetail {
        if (($model = MaterialRequisitionDetail::findOne($materialRequisitionDetailId)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}