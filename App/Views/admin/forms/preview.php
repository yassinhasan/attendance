<div class="modal"  id="previewmodel">
<div class="modal-dialog modal-dialog-centered" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content custom-modal" >
      <div class="modal-header">
        <h5 class="modal-title"> preview test </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <h1><?= pre($selected) ?></h1>
      </div>
      <div class="modal-footer custom-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    >Close</button>
                    <button type="button" class="btn btn-primary save_btn" data-target="<?= $action ?>">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>