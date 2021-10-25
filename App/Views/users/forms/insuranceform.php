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
        <form class="edit-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name"> Insurance name</label>
                    <!-- //         // id	name	mobile	company	dispensed_time	next_dispensed_time	user_id	drugs	notes	files	 -->
                    <input class="form-control" type="text" name="name" id="name"
                    value="<?= $selected->name ?>"
                    >
                </div>
                <div class="result name"></div>
                <!--  -->
                <!--  -->
                <div class="form-group">
                     <label for="mobile"> Member Mobile</label>
                    <input class="form-control" type="text" name="mobile" id="mobile" 
                    style="margin-bottom: 10px;"
                    value="<?= $selected->mobile ?>"
                    >
                    <div class="result mobile"></div>
                </div>
                <!--  -->
                <!--  -->
                <div class="row">
                <div class="form-group col-5" >
                        <label for="dispensed_time"> Insurance Dispensed Time</label>
                        <input class="form-control dis-time" type="date" name="dispensed_time"  style="margin-bottom: 10px;"id="dispensed_time"value="<?= date('Y-m-d'); ?>">
                        <div class="result dispensed_time"
                        value="<?= $selected->dispensed_time ?>"
                        ></div>
                    </div>
                  
                    <div class="form-group col-2" >
                        <label for="period"> MONTHS</label>
                        <input class="form-control period2" type="number" name="period" id="period"
                        value="1" min="1" style="margin-bottom: 10px;">
                        <div class="result period"></div>
                    </div>
                   
                    <!--  -->
                    <!--  -->
                    <div class="form-group col-5" >
                        <label for="next_dispensed_time"> Next Dispensed Time</label>
                        <input class="form-control next-refill" type="date" name="next_dispensed_time"  style="margin-bottom: 10px;"id="next_dispensed_time">
                        <div class="result next_dispensed_time"></div>
                    </div>
                    
                </div>
                <!--  -->
                <div class="form-group">
                    <label for="company"> Insurance Company </label>
                    <select name="company" class="form-control">
                      <option value=""> choose area group </option>
                        <?php
                          foreach($allcompanies as $company)
                          { ?>
                            <option value="<?= $company->name ?>"
                            <?= strtolower($selected->company) == strtolower($company->name) ? 'SELECTED' : ""  ?>
                            > <?= $company->name ?> </option>
                          <?php }
                        ?>
                    </select>
                </div>
                <div class="result company"></div>
                <!--  -->
                <!-- <div class="form-group">
                    <label for="drugs"> Drugs</label>
                     <input list="drugs" name="drugs[]" class="form-control">
                        <datalist id="drugs" >
                        <?php
                          foreach($alldrugs as $drug)
                          { ?>
                            <option value="<?= $drug->name ?>">
                          <?php }
                        ?>
                        </datalist>
                    <div class="result drugs"></div>
                </div> -->
                <div class="form-group">
                        <label for="files"> Upload Files</label>
                        <input class="form-control" type="file" name="files[]" multiple id="files"
                        style="margin-bottom: 10px;">
                <div class="result files"></div>
                </div>
                 <!--  -->
                <div class="form-group">
                    <textarea placeholder="Write Here Note " name="notes" class="form-control"><?= $selected->notes ?></textarea>
                </div>
                <div class="result notes"></div>
                <!--  -->
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


