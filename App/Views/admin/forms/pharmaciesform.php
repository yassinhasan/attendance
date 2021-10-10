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
                    <label for="pharmacies"> choose pharmacies</label>
                    <select name="pharmacies_id" class="form-control">
                    <option value="" selected> choose pharmacie </option>
                        <?php

                        for ($i=1; $i < 1000; $i++) { 
                            { 
                                $p = "";
                                if($i < 10)
                                {
                                    $p = "000".$i;
                                }
                                if($i >= 10 AND  $i < 100)
                                {
                                    $p = "00".$i;
                                }
                                if($i >= 100 AND  $i < 1000)
                                {
                                    $p = "0".$i;
                                }
                                ?>
                                <option value="<?= $i?>"
                                <?=  $selected->pharmacies_id == $i ? 'selected' : ''  ?>
                                > <?= "PH-$p" ?> </option>
                         <?php }
                        }
                        ?>
                      
                    </select>
                </div>                
                <div class="result pharmacies-id"></div>
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