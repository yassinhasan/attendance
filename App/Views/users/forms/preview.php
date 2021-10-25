<div class="modal"  id="previewmodel">
<div class="modal-dialog modal-dialog-centered" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content custom-modal" >
      <div class="modal-header">
        <h5 class="modal-title"> Insurance Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="margin-top: 20px;">
          <div class="row">
              <div class="col col-3">
                <div class="img-thumbnail">
                    <img src="/Public/uploades/images/"  alt="">
                </div>
              </div>
              <div class="col col-8">
                  <div class="row user-details">
                      <div class="info">
                          <span>  Name</span>
                      </div>
                      <div class="details">
                          <?= $selected->name ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> company</span>
                      </div>
                      <div class="details">
                          <?= $selected->company ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> mobile</span>
                      </div>
                      <div class="details">
                          <?= $selected->mobile ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> dispensed_time</span>
                      </div>
                      <div class="details">
                          <?= $selected->dispensed_time ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> next_dispensed_time</span>
                      </div>
                      <div class="details">
                          <?= $selected->next_dispensed_time ?>
                      </div>
                  </div>
                  <div class="row user-details">
                      <div class="info">
                          <span> notes</span>
                      </div>
                      <div class="details">
                          <?=  $selected->notes ?>
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