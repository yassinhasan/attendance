<div class="wraper">
    <div class="profile-box">
        <p>
            Profile
        </p>
        <div class="img-profile">
            <img src="<?= assets("uploades/images/$user->image") ?>" alt="">
            
        </div>
        <button class="upload btn btn-info">
            Upload New Image
        </button>
    </div>
    <div class="profile-edit">
        <div class="title">
            <span>
                Basic Info
            </span>
            <div>
                <button class="cancel btn btn-outline-info">
                        Cancel
                </button>
                <button class="save btn btn-info">
                        Save
                </button>
            </div>
        </div>
            <!--  -->
        <form>
            <div class="row">
                <div class="form-group col">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" placeholder="firstname" id="firstname" 
                    value="<?= $user->firstname ?>" class="form-control">
                </div>
                <div class="form-group col">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" placeholder="lastname" id="lastname" value="<?= $user->lastname ?>" class="form-control">
                </div>
            </div>
                <div class="form-group">
                        <label for="group_name">Title</label>
                        <input type="text" name="title" placeholder="group_name" id="group_name" value="<?= $user->group_name ?>" class="form-control">
                </div>
                <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" placeholder="email" id="email" value="<?= $user->email ?>" class="form-control">
                </div>
            <div class="title">
                <span>
                    Basic Info
                </span>
            </div>
            <div class="form-group" style="margin-top: 10px;">
                <label for="area_name">Area Name</label>
                <input type="text" name="area_name" placeholder="area name" id="area_name" value="<?= $user->area_name ?>" class="form-control">
            </div>
            </form>
            
        </div>
    </div>
</div>