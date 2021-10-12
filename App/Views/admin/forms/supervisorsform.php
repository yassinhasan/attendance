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
                <div class="row">
                  <div class="form-group col-6" style="margin: 20px 0 0 0;">
                      <label for="firstname"> Supervisors Firtname</label>
                      <input class="form-control" type="text" name="firstname" id="firstname" value="<?= $selected->firstname?>">
                      <div class="result firstname"></div>
                  </div>
                  <!--  -->
                  <!--  -->
                  <div class="form-group col-6" style="margin: 20px 0 0 0;">
                      <label for="lastname"> Supervisors lastname</label>
                      <input class="form-control" type="text" name="lastname" id="lastname" value="<?= $selected->lastname?>">  
                     <div class="result lastname"></div>
                  </div>

                </div>
                <!--  -->
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
                <!--  -->
                <div class="form-group" style="margin: 20px 0 0 0;">
                     <label for="imageprofile"> Supervisors password</label>
                    <input class="form-control" type="file" name="image" id="imageprofile">
                </div>
                <div class="result image"></div>
                <!--  -->
                <div class="image-edit">
                      <img src="<?= assets("uploades/images/$selected->image") ?>">
                </div>
                <!--  -->
                <div class="form-group" style="margin: 20px 0 0 0;">
                     <label for="email"> Supervisors email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?= $selected->email?>">
                </div>
                <div class="result email"></div>
                <!--  -->
                <div class="change-password" onclick="showchangepassword(this)"> change password </div>
                    <div class="password-box">
                          <div class="form-group" style="margin: 20px 0 0 0;">
                              <label for="password"> old password</label>
                              <input class="form-control" type="password" name="password" id="password">
                          </div>
                          <div class="result password"></div>
                          <div class="form-group" style="margin: 20px 0 0 0;">
                              <label for="newpassword"> New password</label>
                              <input class="form-control" type="password" name="newpassword" id="newpassword">
                          </div>
                          <div class="result newpassword"></div>
                          <div class="form-group" style="margin: 20px 0 0 0;">
                              <label for="confirmpassword">Confirm New password</label>
                              <input class="form-control" type="password" name="confirmpassword" id="confirmpassword">
                          </div>
                          <div class="result confirmpassword"></div>
                    </div>
                  <!--  -->
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


