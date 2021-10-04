<div class="signup-div">
    <h2 class=" pb-3"> Create Account </h2>
    <form action="<?= $action ?>" enctype="multipart/form-data" class="form">
        <div class="form-row">
            <div class="form-group col-xs-12 col-md-6">
            <label for="inputfirstname4">First Name</label>
            <input type="text" class="form-control" id="inputfirstname4" name="firstname">
            <div class="result firstname">
            </div>
            </div>
            <div class="form-group col-xs-12 col-md-6">
            <label for="inputlastname4">Last Name</label>
            <input type="text" class="form-control" id="inputlastname4" name="lastname">
            <div class="result lastname">
            </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="users_id">User ID</label>
                <input type="text" class="form-control" id="users_id" name="users_id">
                <div class="result users_id"></div>
                <div class="result supervisors_id"></div>
            </div>
            <div class="form-group col-12">
            <label for="inputEmail4">Email</label>
            <input type="email" class="form-control" id="inputEmail4" name="email">
            <div class="result email">
            </div>
            </div>
            <div class="form-group col-12">
            <label for="inputPassword4">Password</label>
            <input type="password" class="form-control" id="inputPassword4" name="password">
            <div class="result password">
            </div>
            </div>
            <div class="form-group col-12">
            <label for="imageprofile"> Select Image Porfile</label>
            <input type="file" class="form-control" id="imageprofile" name="image">
            <div class="result image">
            </div>
            </div>
        </div>

        <button type="submit" class="btn btn-block btn-primary btn-submit">Sign up</button>
    </form>
    <div class="text-center mt-3">
        <span>  Have Account </span>
        <a href="<?= toLink("users/login") ?>"> Sign In One Now </a>
    </div>
</div>

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
