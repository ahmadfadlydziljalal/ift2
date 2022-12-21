<?php

namespace app\widgets\modal_ajax;

use yii\base\Widget;

class ModalAjaxWidget extends Widget
{

   public function init()
   {
      parent::init();
   }

   public function run()
   {
      return $this->render('index');
   }

}