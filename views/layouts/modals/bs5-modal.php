<?php

/* @var $title string|null */
/* @var $messages array */
/* @var $popupCssClass string */
/* @var $popupId string */
?>
<!-- Alert Modal -->
<div class="modal fade <?= $popupCssClass ?>" id="<?= $popupId ?>" tabindex="-1" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?= $messages[0]['cssClass'] ?>">
                <p class="modal-title" id="myModalLabel"><?= $title ?></p>
                <button type="button" class="btn bnt-link p-0 m-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <?php foreach ($messages as $message): ?>
                    <p><?= $message['message'] ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>