<?php
namespace app\generators\dzilcrud;

use rmrevin\yii\fontawesome\FAS;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

class BulkButtonWidget extends Widget {

	public $buttons;

	public function init() {
		parent::init();

	}

	public function run() {

		try {
			return
				Html::tag('div', FAS::icon(FAS::_ARROW_RIGHT) . '&nbsp;' .
					$this->buttons, [
					'class' => 'float-left'
				])

				/*. Html::tag('div', '@ ' . \Yii::$app->formatter->asDatetime(date('Y-m-d H:i:s')), [
					'class' => 'float-right'
				])*/
			;
		} catch (InvalidConfigException $e) {
			echo $e->getMessage();
		}
	}
}

?>
