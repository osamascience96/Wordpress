<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?='/' . DefaultURL . '/dashboard.php'?>">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?='/' . DefaultURL . '/adduser.php'?>">Add User</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="<?='/' . DefaultURL . '/userresponse.php'?>">Edit Response</a>
      </li>
    </ul>
    <div class="form-inline my-2 my-lg-0">
      <a class="btn btn-outline-danger my-2 my-sm-0" href="<?='/' . DefaultURL . '/logout.php'?>">Logout</a>
    </div>
  </div>
</nav>