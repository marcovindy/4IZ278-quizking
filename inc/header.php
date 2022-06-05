<?php
session_start();

if (empty($_SESSION)) {
}

?>

<header class="topbar" data-navbarbg="skin6">
  <nav class="navbar top-navbar navbar-expand-md navbar-light">
    <div class="navbar-header" data-logobg="skin6">
      <a href="index.php" class="sidebar-box-logo d-flex align-items-center link-dark m-auto text-decoration-none">
        <span class="logo-font logo-bar fs-5 fw-semibold">QuizKing</span>
      </a>
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a>
    </div>
    <div class="navbar-collapse collapse justify-content-end" id="navbarSupportedContent" data-navbarbg="skin5">
      <div class="dropdown">

        <?php if (empty($_SESSION)) : ?>
          <a href="login.php" class="link-dark rounded hyper-item">
            Příhlásit se
          </a>
        <?php else : ?>
          <button class="btn text-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['user_name'] ?>
          </button>
        <?php endif; ?>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li><a class="dropdown-item" href="profile.php">Profil</a></li>
          <li><a class="dropdown-item" href="change-password.php">Změnit heslo</a></li>
          <li><a class="dropdown-item" href="php/logout.php">Odhlásit</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>