
<div class="container">
    <div class="wraper">
        <div class="profile">
            <div class="img">
                <img src="<?=  assets("uploades/images/$user->image")?>" alt="">
            </div> 
            <div class="info">
                <p class="name"><?= $user->firstname." ".$user->lastname ?></p>
                <p> <?php
                        if($user->group_id == 1)
                        {
                            echo "Admin" ; 
                        }elseif($user->group_id == 2)
                        {
                            echo "Supervisor";
                                        
                        }elseif($user->group_id == 3)
                        {
                            echo "Pharmacist";
                        }                
                ?> </p>
                <p class="email"><?= $user->email ?></p>
                <p>PH-<?= $user->pharmacy ?></p>
                <p><?= $user->supervisor_firstname." ".$user->supervisor_lastname ?></p>
                <p><?= $user->area_name ?></p>
                <button class="btn btn-info info__profile" style="margin: 10px 0;"><a href="/users/profile" style="color: #fff;margin:10px 0" >Edit Porfile</a></button>
                <button class="btn btn-danger info__logout"><a href="/users/logout" style="color: #fff;" >LogOut</a></button>
            </div>
        </div>
        <div class="insurance">
            <p class="insurance__p">Insurance</p>
            <button class="btn btn-primary insurance__btn_show"> <a href="/users/insurance">Show All Insurance</a> </button>
            <!-- <button class="btn btn-info insurance__btn_add"> <a href="/users/insurance/add">Add New Insurance</a> </button> -->
        </div>
        <div>
            test 2
        </div>
    </div>
</div>