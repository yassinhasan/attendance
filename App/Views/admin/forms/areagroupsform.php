<div class="modal"  id="editmodal">

<div class="modal-dialog modal-dialog-centered" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content custom-modal" >
      <div class="modal-header">
        <h5 class="modal-title">Add New <?= $custom_add ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="edit-form">
        <div class="form-group">
                    <label for="area_id"> Area Id</label>
                    <input class="form-control" type="text" name="area_id" id="area_id" value="<?= $area_group->area_id?>">
                </div>
                <div class="result area-id"></div>
                <div class="form-group" style="margin: 20px 0 0 0;">
                <label for="area_name"> Area Name</label>
                    <input class="form-control" type="text" name="area_name" id="area_name"
                    value="<?= $area_group->area_name?>"
                    >
                </div>
                <div class="result area-name"></div>
        </form>
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