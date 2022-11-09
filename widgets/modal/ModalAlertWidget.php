<?php

namespace app\widgets\modal;

use pa3py6aka\yii2\ModalAlert;
use Yii;
use yii\base\InvalidArgumentException;

class ModalAlertWidget extends ModalAlert
{
    /**
     * @var array List of CSS classes for flash-types
     */
    public $alertTypes = [
        'error' => 'bg-danger text-white',
        'danger' => 'bg-danger text-white',
        'success' => 'bg-success text-white',
        'info' => 'bg-info text-white',
        'warning' => 'bg-warning'
    ];

    /**
     * @var string Path to view for render popup, may be use aliases
     */
    public $popupView;

    /**
     * @var int Time in seconds after which the modal window will be automatically closed (0 means that modal will be closed only by user)
     */
    public $showTime = 0;

    public function init()
    {
        parent::init();

        if (!$this->type) {
            throw new InvalidArgumentException('Modal type is required');
        }

        $this->showTime = (int)$this->showTime * 1000;
    }

    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $messages = [];
        $show = false;
        $title = null;
        $footer = null;

        foreach ($flashes as $type => $data) {

            $cssClass = $this->alertTypes[$type] ?? 'bg-info';
            $data = (array)$data;

            foreach ($data as $message) {
                if ($message) {
                    $show = true;
                }
                if (is_array($message)) {
                    if (count($message) > 1) {
                        $title = $message['title'] ?? "";
                        $footer = $message['footer'] ?? "";
                    }
                    $message = $message['message'] ?? "";
                }

                $messages[] = [
                    'cssClass' => $cssClass,
                    'message' => $message,
                ];
            }

            $session->removeFlash($type);
        }

        if ($show) {
            $this->showModal();
            return $this->renderModal($messages, $title, $footer);
        }

        return '';
    }

    private function showModal()
    {
        // Bootstrap 3/4/5 with jQuery
        if (in_array($this->type, [self::TYPE_BOOTSTRAP, self::TYPE_BOOTSTRAP_3, self::TYPE_BOOTSTRAP_4, self::TYPE_BOOTSTRAP_5_JQUERY])) {
            $closeTimer = $this->showTime > 0 ? "setTimeout(\"$('#{$this->popupId}').modal('hide');\", {$this->showTime});" : '';
            $js = <<<JS
$('#{$this->popupId}').modal('show');
{$closeTimer}
JS;
        }

        // Bootstrap 5 without jQuery
        if ($this->type === self::TYPE_BOOTSTRAP_5) {
            $closeTimer = $this->showTime > 0 ? "setTimeout(\"alertModal.hide();\", {$this->showTime});" : '';
            $js = <<<JS
var alertModal = new bootstrap.Modal(document.getElementById('{$this->popupId}'));
alertModal.show();
{$closeTimer}
JS;
        }

        // Magnific popup
        if ($this->type === self::TYPE_MAGNIFIC) {
            $closeTimer = $this->showTime > 0 ? "setTimeout(\"$.magnificPopup.close();\", {$this->showTime});" : '';
            $js = <<<JS
$.magnificPopup.open({
    items: {
        src: '#{$this->popupId}',
        type: '{$this->magnificPopupType}',
        midClick: true
    }
});
{$closeTimer}
JS;
        }

        $this->view->registerJs($js);
    }

    private function renderModal(array $messages, $title, $footer): string
    {
        $path = $this->popupView ?: $this->type . '-modal';
        if ($this->type === self::TYPE_BOOTSTRAP_5_JQUERY && !$this->popupView) {
            $path = self::TYPE_BOOTSTRAP_5 . '-modal';
        }

        return $this->render($path, [
            'messages' => $messages,
            'popupCssClass' => $this->popupCssClass,
            'popupId' => $this->popupId,
            'title' => $title,
            'footer' => $footer
        ]);


    }
}