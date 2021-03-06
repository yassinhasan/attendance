<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?= toLink("/") ?>">Attendance</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link" href="/admin" data-target="admin">Admin <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= toLink("admin/usersgroups") ?>" data-target="usersgroups">User Groups <span class="sr-only">(current)</span></a>
      </li>
      <!--  -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Manger Area
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?= toLink("admin/areagroups") ?>" data-target="areagroups">Area Groups <span class="sr-only">(current)</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= toLink("admin/pharmacies") ?>" data-target="pharmacies"> pharmacies <span class="sr-only">(current)</span></a>
            <a class="dropdown-item" href="<?= toLink("admin/supervisors") ?>" data-target="supervisors">Supervisors <span class="sr-only">(current)</span></a>
            <a class="dropdown-item" href="<?= toLink("admin/pharmacists") ?>" data-target="supervisors">Pharmacists <span class="sr-only">(current)</span></a>

        </div>
      </li>

      <!-- <li class="nav-item">
        <a class="nav-link" href="<?= toLink("admin/areagroups") ?>" data-target="areagroups">Area Groups <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= toLink("admin/pharmacies") ?>" data-target="pharmacies"> pharmacies <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= toLink("admin/supervisors") ?>" data-target="supervisors">Supervisors <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= toLink("admin/pharmacists") ?>" data-target="supervisors">Pharmacists <span class="sr-only">(current)</span></a>
      </li> -->

      <li class="nav-item dropdown">
        
        <a class="nav-link dropdown-toggle profile-name-nav" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="profile-name"><?= ucfirst( $user->firstname)." ".ucfirst($user->lastname) ?></span>
        <img  src="<?= assets("uploades/images/$user->image") ?>" class="image-nav">
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= toLink("admin/profile") ?>">Edit Profile</a>
          <!-- <a class="dropdown-item" href="<?= toLink("admin/password") ?>">Change Password </a> -->
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?=toLink("admin/logout")  ?>">LOG OUT</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>