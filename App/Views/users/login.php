<div class="login-div">
    <h2 class=" pb-3"> Login  </h2>
    <form class="form" action="<?= $action ?>">
    <div class="form-row" style="margin-bottom: 20px;">
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
        <div class="result invalid">
        </div>
        </div>
    </div>

    <div class="form-group">
        <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck" name="remember">
        <label class="form-check-label" for="gridCheck">
            Remember Me
        </label>
        </div>
    </div>
    <button type="submit" class="btn btn-block btn-primary btn-submit">Sign in</button>
    </form>
    <div class="text-center mt-3">
        <a href=""> Forget Password  ? </a>
    </div>
    <div class="text-center mt-3">
        <span> Don't Have Account </span>
        <a href="<?= toLink("users/signup") ?>"> Create One Now </a>
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