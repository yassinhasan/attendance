<div class="modal"  id="pharmacistpreviewmodel">
<div class="modal-dialog modal-dialog-centered" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content custom-modal" >
      <div class="modal-header">
        <h5 class="modal-title"> Supervisor Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="margin-top: 20px;">
          <div class="row">
              <div class="col col-3">
                <div class="img-thumbnail">
                    <img src="/Public/uploades/images/<?= $selected->image ?>"  alt="">
                </div>
              </div>
              <div class="col col-8">
                  <div class="row user-details">
                      <div class="info">
                          <span>  Name</span>
                      </div>
                      <div class="details">
                          <?= $selected->firstname." ".$selected->lastname ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> Email</span>
                      </div>
                      <div class="details">
                          <?= $selected->email ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> ID</span>
                      </div>
                      <div class="details">
                          <?= $selected->users_id ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> Pharmacy</span>
                      </div>
                      <div class="details">
                          <?= "PH-".$selected->pharmacy_id ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> Area</span>
                      </div>
                      <div class="details">
                          <?= $selected->area_name ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> User Type</span>
                      </div>
                      <div class="details">
                          <?= $selected->group_name ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> Date Of Joinning</span>
                      </div>
                      <div class="details">
                          <?= date(" Y-M-d" , $selected->logintime) ?>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer custom-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>