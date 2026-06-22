<?php

namespace app\actions\material_requisition;

use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\Tabular;
use Yii;
use yii\base\Action;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CreatePenawaranAction extends Action {

    /**
     * @param int $materialRequisitionDetailId
     * @return string|Response|array
     * @throws NotFoundHttpException
     */
    public function run(int $materialRequisitionDetailId): string|Response|array {
        $modelMaterialRequisitionDetail = $this->findModelDetail($materialRequisitionDetailId);
        $modelMaterialRequisitionDetail->scenario = MaterialRequisitionDetail::SCENARIO_PENAWARAN_VENDOR;

        return $this->controller->request->isAjax ?
            $this->handleAjax([new MaterialRequisitionDetailPenawaran()], $materialRequisitionDetailId, $modelMaterialRequisitionDetail) :
            $this->handleNonAjax([new MaterialRequisitionDetailPenawaran()], $materialRequisitionDetailId, $modelMaterialRequisitionDetail);

    }

    private function handleAjax(array $modelsDetail, $materialRequisitionDetailId, MaterialRequisitionDetail $modelMaterialRequisitionDetail): array {

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($this->controller->request->isPost) {
            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetailPenawaran::class);
            Tabular::loadMultiple($modelsDetail, $this->controller->request->post());

            /* @see MaterialRequisitionDetail::validatePenawaranList() */
            $modelMaterialRequisitionDetail->arrayObjectPenawaran = $modelsDetail;

            if (Tabular::validateMultiple($modelsDetail) && $modelMaterialRequisitionDetail->validate()) {

                $status = $modelMaterialRequisitionDetail->createPenawaran($modelsDetail, $materialRequisitionDetailId);

                if ($status['code']) {
                    return [
                        'forceClose'  => true,
                        'forceReload' => '#material-requisition-detail-penawaran-grid',
                    ];
                }
            }

            return [
                'title'   => 'Error',
                'content' => $this->controller->render('create_penawaran', [
                    'modelMaterialRequisition'       => $modelMaterialRequisitionDetail->materialRequisition,
                    'modelMaterialRequisitionDetail' => $modelMaterialRequisitionDetail,
                    'modelsDetail'                   => $modelsDetail,
                ]),
                'footer'  => Html::button('Tutup', ['class' => 'btn btn-secondary', 'data-bs-dismiss' => 'modal']) . ' ' .
                    Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'form' => 'dynamic-form']),
            ];
        }

        return [
            'title'   => 'Tambah Penawaran: ' . ($modelMaterialRequisitionDetail->barang->nama ?? ''),
            'content' =>
            /** @see views/material-requisition/create_penawaran.php */
                $this->controller->renderAjax('create_penawaran', [
                    'modelMaterialRequisition'       => $modelMaterialRequisitionDetail->materialRequisition,
                    'modelMaterialRequisitionDetail' => $modelMaterialRequisitionDetail,
                    'modelsDetail'                   => $modelsDetail,
                ]),
            'footer'  => Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'form' => 'dynamic-form']),
        ];
    }

    private function handleNonAjax(array $modelsDetail, $materialRequisitionDetailId, MaterialRequisitionDetail $modelMaterialRequisitionDetail): Response|string {
        if ($this->controller->request->isPost) {

            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetailPenawaran::class);
            Tabular::loadMultiple($modelsDetail, $this->controller->request->post());

            /* @see MaterialRequisitionDetail::validatePenawaranList() */
            $modelMaterialRequisitionDetail->arrayObjectPenawaran = $modelsDetail;

            if (Tabular::validateMultiple($modelsDetail) && $modelMaterialRequisitionDetail->validate()) {

                $status = $modelMaterialRequisitionDetail->createPenawaran($modelsDetail, $materialRequisitionDetailId);

                if ($status['code']) {
                    Yii::$app->session->setFlash('success', " Harga penawaran berhasil ditambahkan.");
                    return $this->controller->redirect([
                        'material-requisition/view',
                        'id' => $modelMaterialRequisitionDetail->materialRequisition->id,
                        '#'  => 'material-requisition-tab-tab1'
                    ]);
                }

                Yii::$app->session->setFlash('danger', " Harga penawaran is failed to insert. Info: " . $status['message']);
            }

        }

        return $this->controller->render('create_penawaran', [
            'modelMaterialRequisition'       => $modelMaterialRequisitionDetail->materialRequisition,
            'modelMaterialRequisitionDetail' => $modelMaterialRequisitionDetail,
            'modelsDetail'                   => $modelsDetail,
        ]);
    }

    /**
     * @param $materialRequisitionDetailId
     * @return MaterialRequisitionDetail|null
     * @throws NotFoundHttpException
     */
    protected function findModelDetail($materialRequisitionDetailId): ?MaterialRequisitionDetail {
        return ($model = MaterialRequisitionDetail::findOne($materialRequisitionDetailId)) !== null ?
            $model :
            throw new NotFoundHttpException('The requested page does not exist.');
    }
}