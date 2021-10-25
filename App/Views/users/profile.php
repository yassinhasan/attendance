<h5 style="margin: 20px 30px;">
    <a href="/users/usershome">Home > </a>   Edit Profile 
    </h2>
<div class="wraper">

    <div class="profile-box">
        <p>
            Profile
        </p>
        <div class="img-profile">
            <img src="<?= assets("uploades/images/$user->image") ?>" alt="">
            <input class="form-control image-input" type="file" name="image" hidden>
        </div>
        <div class="result image"></div>
        <button class="upload btn btn-info" data-upload="<?= $action ?>">
            Upload New Image
        </button>
    </div>
    <div class="profile-edit">
        <div class="title">
            <span>
                Basic Info
            </span>
            <div>
                <button class="save btn btn-info" data-update="<?= $update ?>">
                        Save
                </button>
            </div>
        </div>
            <!--  -->
        <form class="update-form">
            <div class="row">
                <div class="form-group col">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" placeholder="firstname" id="firstname" 
                    value="<?= $user->firstname ?>" class="form-control">
                    <div class="result firstname"></div>
                </div>
                <div class="form-group col">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" placeholder="lastname" id="lastname" value="<?= $user->lastname ?>" class="form-control">
                    <div class="result lastname"></div>
                </div>
            </div>
            <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" placeholder="email" id="email" value="<?= $user->email ?>" class="form-control">
                        <div class="result email"></div>
            </div>
            <!--  -->
            <div>
                <span class="change-password" onclick="showchangepassword(this)"> change password </span>
             </div>

             <div class="password-box">
                          <div class="form-group" style="margin: 20px 0 0 0;">
                              <label for="password"> old password</label>
                              <input class="form-control" type="password" name="password" id="password">
                          </div>
                          <div class="result password"></div>
                          <div class="form-group" style="margin: 20px 0 0 0;">
                              <label for="newpassword"> New password</label>
                              <input class="form-control" type="password" name="newpassword" id="newpassword">
                          </div>
                          <div class="result newpassword"></div>
                          <div class="form-group" style="margin: 20px 0 0 0;">
                              <label for="confirmpassword">Confirm New password</label>
                              <input class="form-control" type="password" name="confirmpassword" id="confirmpassword">
                          </div>
                          <div class="result confirmpassword"></div>
                    </div>   
            <!--  -->
            <div class="result updated"></div>
            </form>
            
        </div>
    </div>
</div>