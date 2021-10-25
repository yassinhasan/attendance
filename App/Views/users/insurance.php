<h5 style="margin: 20px 30px;">
    <a href="/users/usershome">Home > </a>  INSURANCE 
    </h2>
<div class="table-center">
  
    <h2 class="text-center heading">
        Insurance Of Ph- <?= $user->pharmacy_id < 10 ? "0".$user->pharmacy_id : $user->pharmacy_id ?> 
    </h2>

    <!-- test -->
        <div class="set-pos">
        <div class="table-items">
        <button class="add-new-modal btn btn-info add-new" >
            Add New  <?= $custom_add ?>   <i class="fas fa-plus"></i>
        </button>
        <div class="form-group">
                    <label for="exampleFormControlSelect1"> No oF Items Per Page </label>
                    <select class="form-control select-no-pages" id="exampleFormControlSelect1" name="123`3132">
                    <option value="">Select No Of Rows</option>
                    <option value="3">3</option>
                    <option value="5">5</option>
                    <option value="10">105</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    </select>
        </div>
    </div>

    <!-- search sectiob -->
    <div class="table-items">
        <div></div>

        <div class="form-group">
            <input type="search" placeholder="search by id" class="form-control table-serach" name="search">
        </div>
    </div>
    <div class="table-items">
         <div></div>

        <div class="form-group">
            <input type="search" placeholder="search by insurance name" class="form-control search_item" name="search_item">
        </div>
    </div>
        </div>
    <!-- test -->
     <!-- search sectiob -->
    <table class="table table-bordered" data-load="<?= $load_data ?> " data-edit="<?= $edit_data?>"
    data-delete="<?= $delete_data?>" data-show="<?= $show_data ?>"
    >
    <thead>
            <tr>
                <th class="th-name">
                    Name
                </th>
                <th>
                    Mobile NO
                </th>
                <th>
                    INSURANCE COMPANY
                </th>
                <th class="th-time">
                    Dispensed Time
                </th>
                <th class="th-time">
                  Next  Dispensed Time
                </th>
                <th class="th-drugs">
                  Drugs
                </th>
                <th class="th-notes">
                  Notes
                </th>
                <th class="th-action">
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="tbody">

        </tbody>
    </table>
</div>

<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
  </ul>
</nav>

<div class="modal"  id="insurancemodel">  
    <!-- modal form must have id=""  equal to data-target in button -->
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
            <form class="add-form" enctype="multipart/form-data">
                 <div class="form-group">
                    <label for="name"> Insurance name</label>
                    <!-- //         // id	name	mobile	company	dispensed_time	next_dispensed_time	user_id	drugs	notes	files	 -->
                    <input class="form-control" type="text" name="name" id="name">
                </div>
                <div class="result name2"></div>
                <!--  -->
                <!--  -->
                <div class="form-group">
                     <label for="mobile"> Member Mobile</label>
                    <input class="form-control" type="text" name="mobile" id="mobile" style="margin-bottom: 10px;">
                    <div class="result mobile2"></div>
                </div>
                <!--  -->
                <!--  -->
                <div class="row">
                    <div class="form-group col-5" >
                        <label for="dispensed_time"> Insurance Dispensed Time</label>
                        <input class="form-control dis-time" type="date" name="dispensed_time"  style="margin-bottom: 10px;"id="dispensed_time"value="<?= date('Y-m-d'); ?>">
                        <div class="result dispensed_time2"></div>
                    </div>
                  
                    <div class="form-group col-2" >
                        <label for="period"> MONTHS</label>
                        <input class="form-control period" type="number" name="period" id="period"
                        value="1" min="1" style="margin-bottom: 10px;">
                        <div class="result period2"></div>
                    </div>
                   
                    <!--  -->
                    <!--  -->
                    <div class="form-group col-5" >
                        <label for="next_dispensed_time"> Next Dispensed Time</label>
                        <input class="form-control next-refill" type="date" name="next_dispensed_time"  style="margin-bottom: 10px;"id="next_dispensed_time">
                        <div class="result next_dispensed_time2"></div>
                    </div>
                    
                </div>
                <!--  -->
                <div class="form-group">
                    <label for="company"> Insurance Company </label>
                    <select name="company" class="form-control" id="company">
                      <option value="" selected> choose area group </option>
                        <?php
                          foreach($allcompanies as $company)
                          { ?>
                            <option value="<?= $company->name ?>"> <?= $company->name ?> </option>
                          <?php }
                        ?>
                    </select>
                </div>
                <div class="result company2"></div>
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
                        style="margin-bottom: 10px;"
                        >
                <div class="result files2"></div>
                </div>
                 <!--  -->
                <div class="form-group">
                    <textarea placeholder="Write Here Note " name="notes" class="form-control"></textarea>
                </div>
                <div class="result notes2"></div>
                <!--  -->
            </form>
        </div>
        <div class="modal-footer custom-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        >Close</button>
                        <button type="button" class="btn btn-primary submit-btn" data-target="<?= $action ?>">Save changes</button>
        </div>
        </div>
    </div>
    </div>
</div>



<!-- spinner -->
<div class="loadinsuccess">
    <div class="spinner-grow text-primary" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-secondary" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-danger" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-warning" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-info" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-light" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-dark" role="status">
    <span class="sr-only">Loading...</span>
    </div>
</div>
<div class="overlay">
</div>
<!-- spinner -->

<!-- pagination -->
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
  </ul>
</nav>
<!-- donloawd -->
<div class="justify-content-center" style="text-align: center; margin: 30px 0">
    <form method="POST">
    <a class="btn btn-success btn-download" href="<?= $delete_download ?>">
        download to excel
    </a>
    </form>
</div>
