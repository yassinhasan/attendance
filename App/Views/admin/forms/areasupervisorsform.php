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
                    <label for="area_id"> Area Name</label>
                    <select name="area_id" class="form-control">
                      <option value="" selected> choose area group </option>
                        <?php
                          foreach($allarea as $area)
                          { ?>
                            <option value="<?= $area->area_id ?>" <?=  $selected->area_id == $area->area_id ? " selected " : "" ?>> <?= $area->area_name ?> </option>
                          <?php }
                        ?>
                    </select>
                </div>
                <div class="result area-id"></div>
                <div class="form-group" style="margin: 20px 0 0 0;">
                    <label for="supervisors"> choose supervisors</label>
                    <select name="supervisors_id" class="form-control">
                    <option value="" selected> choose supervisor </option>
                        <?php
                          foreach($allsupervisors as $supervisor)
                          { ?>
                            <option value="<?= $supervisor->supervisors_id ?>" <?=  $selected->supervisors_id == $supervisor->supervisors_id ? " selected " : "" ?>> <?= $supervisor->firstname." ".$supervisor->lastname ?> </option>
                          <?php }
                        ?>
                      
                    </select>
                </div>
                <div class="result supervisors-id"></div>
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