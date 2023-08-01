<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="static/images/logo.png" class="logo" alt="png logo image"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a href="#addMember" class="nav-link">Add Member</a>
        </li>
        <li class="nav-item">
            <a href="#addTrainer" class="nav-link">Add Trainer</a>
        </li>
        <li class="nav-item">
            <a href="#TrainerToMember" class="nav-link">Assign Trainer to member</a>
        </li>
     </ul>
      <form  action="logout.php" method="POST">
        <input type="hidden" name="logout_id" value="<?php $_SESSION['admin_id']; ?>">
        <button class="btn btn-outline-danger" type="submit">Logout</button>
      </form>
    </div>
  </div>
</nav>