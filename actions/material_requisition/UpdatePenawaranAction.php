<?php

namespace app\actions\material_requisition;

use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\Tabular;
use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UpdatePenawaranAction extends Action {

    public function run(int $materialRequisitionDetailId): Response|array|string {
        $modelMaterialRequisitionDetail = $this->findModelDetail($materialRequisitionDetailId);
        $modelMaterialRequisitionDetail->scenario = MaterialRequisitionDetail::SCENARIO_PENAWARAN_VENDOR;
        $modelsDetail = empty($modelMaterialRequisitionDetail->materialRequisitionDetailPenawarans)
            ? [new MaterialRequisitionDetailPenawaran()]
            : $modelMaterialRequisitionDetail->materialRequisitionDetailPenawarans;

        return $this->controller->request->isAjax ?
            $this->handleAjax($modelsDetail, $materialRequisitionDetailId, $modelMaterialRequisitionDetail) :
            $this->handleNonAjax($modelsDetail, $materialRequisitionDetailId, $modelMaterialRequisitionDetail);
    }

    private function handleNonAjax(array $modelsDetail, int $materialRequisitionDetailId, ?MaterialRequisitionDetail $modelMaterialRequisitionDetail): Response|string {

        if ($this->controller->request->isPost) {

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetailPenawaran::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $this->controller->request->post());
            /* @see MaterialRequisitionDetail::validatePenawaranList() */
            $modelMaterialRequisitionDetail->arrayObjectPenawaran = $modelsDetail;

            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            if (Tabular::validateMultiple($modelsDetail) && $modelMaterialRequisitionDetail->validate()) {

                $status = $modelMaterialRequisitionDetail->updatePenawaran($modelsDetail, $materialRequisitionDetailId, $deletedDetailsID);

                if ($status['code']) {
                    Yii::$app->session->setFlash('success', " Harga penawaran berhasil di-update.");
                    return $this->controller->redirect([
                        'material-requisition/view',
                        'id' => $modelMaterialRequisitionDetail->materialRequisition->id,
                        '#'  => 'material-requisition-tab-tab1'
                    ]);
                }

                Yii::$app->session->setFlash('danger', " Harga penawaran is failed to insert. Info: " . $status['message']);
            }

        }

        return $this->controller->render('update_penawaran', [
            'modelMaterialRequisition'       => $modelMaterialRequisitionDetail->materialRequisition,
            'modelMaterialRequisitionDetail' => $modelMaterialRequisitionDetail,
            'modelsDetail'                   => $modelsDetail,
        ]);
    }

    private function handleAjax(array $modelsDetail, int $materialRequisitionDetailId, ?MaterialRequisitionDetail $modelMaterialRequisitionDetail): array {
        Yii::$app->response->format = Response::FORMAT_JSON;


        if ($this->controller->request->isPost) {
            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetailPenawaran::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $this->controller->request->post());
            /* @see MaterialRequisitionDetail::validatePenawaranList() */
            $modelMaterialRequisitionDetail->arrayObjectPenawaran = $modelsDetail;

            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            if (Tabular::validateMultiple($modelsDetail) && $modelMaterialRequisitionDetail->validate()) {
                $status = $modelMaterialRequisitionDetail->updatePenawaran($modelsDetail, $materialRequisitionDetailId, $deletedDetailsID);
                if ($status['code']) {
                    return [
                        'forceClose'  => true,
                        'forceReload' => '#crud-datatable-pjax',
                    ];
                }
                return [
                    'title'   => 'Error',
                    'content' => $this->controller->renderAjax('update_penawaran', [
                        'modelMaterialRequisition'       => $modelMaterialRequisitionDetail->materialRequisition,
                        'modelMaterialRequisitionDetail' => $modelMaterialRequisitionDetail,
                        'modelsDetail'                   => $modelsDetail,
                    ]),
                    'footer'  =>
                        Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'form' => 'dynamic-form']),
                ];
            }
        }
        return [
            'title'   => 'Update Penawaran: ' . ($modelMaterialRequisitionDetail->barang->nama ?? ''),
            'content' => $this->controller->renderAjax('update_penawaran', [
                'modelMaterialRequisition'       => $modelMaterialRequisitionDetail->materialRequisition,
                'modelMaterialRequisitionDetail' => $modelMaterialRequisitionDetail,
                'modelsDetail'                   => $modelsDetail,
            ]),
            'footer'  => Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'form' => 'dynamic-form']),
        ];

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