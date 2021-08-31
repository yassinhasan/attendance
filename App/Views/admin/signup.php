<div class="signup-div">
    <h2 class=" pb-3"> Create Account </h2>
    <form action="<?= $action ?>" enctype="multipart/form-data" class="form">
        <div class="form-row">
            <div class="form-group col-xs-12 col-md-6">
            <label for="inputfirstname4">First Name</label>
            <input type="text" class="form-control" id="inputfirstname4" name="firstname">
            </div>
            <div class="form-group col-xs-12 col-md-6">
            <label for="inputlastname4">Last Name</label>
            <input type="text" class="form-control" id="inputlastname4" name="lastname">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-12">
            <label for="inputEmail4">Email</label>
            <input type="email" class="form-control" id="inputEmail4" name="email">
            </div>
            <div class="form-group col-12">
            <label for="inputPassword4">Password</label>
            <input type="password" class="form-control" id="inputPassword4" name="password">
            </div>
            <div class="form-group col-12">
            <label for="imageprofile"> Select Image Porfile</label>
            <input type="file" class="form-control" id="imageprofile" name="image">
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-submit">Sign up</button>
    </form>
</div>