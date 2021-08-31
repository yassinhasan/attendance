<div class="login-div">
<h2 class=" pb-3"> Login  </h2>
    <form class="form" action="<?= $action ?>">
    <div class="form-row" style="margin-bottom: 20px;">
        <div class="form-group col-12">
        <label for="inputEmail4">Email</label>
        <input type="email" class="form-control" id="inputEmail4" name="email">
        </div>
        <div class="form-group col-12">
        <label for="inputPassword4">Password</label>
        <input type="password" class="form-control" id="inputPassword4" name="password">
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
    <button type="submit" class="btn btn-primary btn-submit">Sign in</button>
    </form>
</div>