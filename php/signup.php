<?php

require_once '../inc/db.php';

$errors = [];
if (!empty($_POST)) {

  $userName = trim(@$_POST['user_name']);
  $userEmail = trim(@$_POST['user_email']);
  $userPwd = $_POST['user_pwd'];


  $pattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
  if (!(preg_match($pattern, $userPwd))) {
    $errors['user_password'] = 'Heslo musí mít minimálně 1 číslici z minimálních 8 znaků.';
  }

  if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    $errors['user_email'] = 'Musíte zadat platnou e-mailovou adresu.';
  } else {

    $mailQuery = $db->prepare('SELECT * FROM users WHERE user_email=:email LIMIT 1;');
    $mailQuery->execute([
      ':email' => $userEmail
    ]);
    if ($mailQuery->rowCount() > 0) {
      $errors['user_email'] = 'Uživatelský účet s touto e-mailovou adresou již existuje.';
    }
  }


  if (empty($_POST['user_pwd']) || (strlen($_POST['user_pwd']) < 5)) {
    $errors['user_pwd'] = 'Musíte zadat heslo o délce alespoň 5 znaků.';
  }
  if ($_POST['user_pwd'] != $_POST['user_pwd_co']) {
    $errors['user_pwd_co'] = 'Zadaná hesla se neshodují.';
  }

  if (empty($errors)) {

    $password = password_hash($_POST['user_pwd'], PASSWORD_DEFAULT);

    $query = $db->prepare('INSERT INTO users (user_name, user_email, user_pwd, user_admin, user_exp, user_coins, user_quiz_submited) VALUES (:name, :email, :password, false, 0, 0, 0);');
    $query->execute([
      ':name' => $userName,
      ':email' => $userEmail,
      ':password' => $userPwd
    ]);

    session_start();
    $_SESSION['user_id'] = $db->lastInsertId();
    $_SESSION['user_name'] = $userName;
    $_SESSION['user_email'] = $userEmail;
    if (!empty($_SESSION)) {
      header("refresh:3; url=../index.php");
      echo "<div class='fs-3'>";
      echo "Registrace se zdařila, budete automaticky přihlášeni.";
      "</div>";
    } else {
      header("refresh:3; url=../register.php");
    }
    exit();
  } else {

    echo "<div>";
    foreach ($errors as $error) {
      echo "<p>" . $error . "</p>";
    }
    echo "</div>";
    header("refresh:4; url=../register.php");
  }
} else {
  echo "<div class='fs-3'>";
  echo "Registrace se nezdařila, budete automaticky přesměrování zpět.";
  echo "</div>";
  header("refresh:3; url=../register.php");
}
