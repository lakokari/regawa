<div id="my-modal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?php echo isset($modal_title)?$modal_title:'';?></h3>
    </div>
    <div id="modal-body" class="modal-body">
        <!-- content will be filled dynamically -->
    </div>
    <?php if (isset($buttons)):?>
    <div class="modal-footer">
        <?php foreach($buttons as $button):?>
        <a href="#" id="<?php echo $button->id;?>"><?php echo $button->caption;?></a>
        <?php endforeach;?>
    </div>
    <?php endif;?>
</div>