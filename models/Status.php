<?php

namespace app\models;

use app\models\base\Status as BaseStatus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "status".
 */
class Status extends BaseStatus
{

    const MATERIAL_REQUISITION_DETAIL_PENAWARAN_STATUS = 'material-requisition-detail-penawaran-status';


    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}