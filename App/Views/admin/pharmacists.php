<div class="table-center">
  
    <h2 class="text-center heading">
        Pharmacists 
    </h2>

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
            <input type="search" placeholder="search by pharmacists name" class="form-control search_item" name="search_item">
        </div>
    </div>
     <!-- search sectiob -->
    <table class="table table-bordered" data-load="<?= $load_data ?> " data-edit="<?= $edit_data?>"
    data-delete="<?= $delete_data?>" data-show="<?= $show_data ?>"
    >
        <thead>
            <tr>
                <th>
                    Pharmacist ID
                </th>
                <th>
                    Pharmacist Image
                </th>
                <th>
                    Pharmacist Name 
                </th>
                <th>
                    Pharmacy Name
                </th>
                <th>
                    Pharmacist Area 
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

<div class="modal"  id="pharmacistsmodel">  
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
            <form class="add-form">
                 <div class="form-group">
                    <label for="users_id"> Pharmacist Id</label>
                    <input class="form-control" type="text" name="users_id" id="pharmacists_id">
                </div>
                <div class="result users-id"></div>
                <!--  -->
                <div class="row">
                <!--  -->
                <div class="form-group col-6" style="margin: 20px 0 0 0;">
                     <label for="firstname"> Pharmacist Firtname</label>
                    <input class="form-control" type="text" name="firstname" id="firstname">
                    <div class="result firstname"></div>
                </div>
                <!--  -->
                <!--  -->
                <div class="form-group col-6"  style="margin: 20px 0 0 0;">
                     <label for="lastname"> Pharmacist lastname</label>
                    <input class="form-control" type="text" name="lastname" id="lastname">
                    <div class="result lastname"></div>
                </div>
                </div>
                <!--  -->
                <div class="form-group" style="margin: 20px 0 0 0;">
                     <label for="email"> Pharmacist email</label>
                    <input class="form-control" type="email" name="email" id="email">
                </div>
                <div class="result email"></div>
                <!--  -->
                <!--  -->
                <div class="form-group" style="margin: 20px 0 0 0;">
                     <label for="password"> Pharmacist password</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <div class="result password"></div>
                <!--  -->
                <div class="form-group">
                    <label for="pharmacy_id"> Pharmacy Name</label>
                    <select name="pharmacy_id" class="form-control">
                      <option value="" selected> choose area group </option>
                        <?php
                          foreach($allpharmacies as $allpharmacie)
                          { ?>
                            <option value="<?= $allpharmacie->pharmacies_id ?>"> <?= $allpharmacie->pharmacies_id ?> </option>
                          <?php }
                        ?>
                    </select>
                </div>
                <div class="result pharmacy-id"></div>
                <!--  -->
                <div class="form-group" style="margin: 20px 0 0 0;">
                     <label for="imageprofile"> Pharmacist password</label>
                    <input class="form-control" type="file" name="image" id="imageprofile">
                </div>
                <div class="result image"></div>
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
