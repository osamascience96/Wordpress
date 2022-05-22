<!-- Delete Modal -->
<div id="delete-card" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="delete-card-ttl mb-0">Are you sure you want to delete?</p>
                <?php if (!empty($delete_msg)) { ?>
                    <p class="form-text"><?php echo $delete_msg; ?></p>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <form action="<?php echo $action_delete; ?>" class="delete-card-button" method="post">
                    <input type="hidden" value="" class="delete-id" name="id">
                    <input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>