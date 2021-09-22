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
                <select class="form-control"name='group_id'>
                    <option value=""> 
                        Select User Type
                    </option>
                    <option value="1" <?= $user_permessions[0]->group_id == 1 ? 'selected' : ''  ?> >
                              Admin
                    </option>
                    <option value="2" <?= $user_permessions[0]->group_id == 2 ? 'selected' : ''  ?>>
                            User
                    </option>
                </select>
            </div>
            <div class="result group_id"></div>
            <div class="form-group" style="margin: 20px 0 0 0;">
                <select class="form-control" multiple style="padding: 10px;" name="permession_id[]">
                    <?php 
                        $all_permessions = $this->app->route->allRoutesUrl();
                        foreach($all_permessions as $key=>$permession){ ?> 
                            <option value="<?= $key ?>" 
                            <?php 
                              foreach($selected_permessions as $selected_permession){
                                if($selected_permession == $key){
                                  echo "selected";
                                }else{ echo "" ;}
                              }
                            ?>

                            >
                            <?= $permession ?>
                        </option>
                        <?php } ?>
                    
                </select>
            </div>
            <div class="result permession_name"></div>
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