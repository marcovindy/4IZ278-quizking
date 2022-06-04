<?php

require_once '../inc/db.php';

$errors=[];
if (!empty($_POST)){
  #region zpracování formuláře

  $userName=trim(@$_POST['user_name']);
  $userEmail=trim(@$_POST['user_email']);
  $userPwd=$_POST['user_pwd'];

  #region kontrola jména
  if (empty($userName)){
    $errors['user_name']='Musíte zadat své jméno či přezdívku.';
  }
  #endregion kontrola jména

  #region kontrola emailu
  if (!filter_var($userEmail,FILTER_VALIDATE_EMAIL)){
    $errors['user_email']='Musíte zadat platnou e-mailovou adresu.';
  }else{
    //kontrola, jestli již není e-mail registrovaný
    $mailQuery=$db->prepare('SELECT * FROM users WHERE user_email=:email LIMIT 1;');
    $mailQuery->execute([
      ':email'=>$userEmail
    ]);
    if ($mailQuery->rowCount()>0){
      $errors['user_email']='Uživatelský účet s touto e-mailovou adresou již existuje.';
    }
  }
  #endregion kontrola emailu

  #region kontrola hesla
  if (empty($_POST['user_pwd']) || (strlen($_POST['user_pwd'])<5)){
    $errors['user_pwd']='Musíte zadat heslo o délce alespoň 5 znaků.';
  }
  if ($_POST['user_pwd']!=$_POST['user_pwd_co']){
    $errors['user_pwd_co']='Zadaná hesla se neshodují.';
  }
  #endregion kontrola hesla

  if (empty($errors)){
    //zaregistrování uživatele
    $password=password_hash($_POST['user_pwd'],PASSWORD_DEFAULT);

    $query=$db->prepare('INSERT INTO users (user_name, user_email, user_pwd, user_admin, user_exp, user_coins) VALUES (:name, :email, :password, false, 0, 0);');
    $query->execute([
      ':name'=>$userName,
      ':email'=>$userEmail,
      ':password'=>$userPwd
    ]);

    //uživatele rovnou přihlásíme
    $_SESSION['user_id']=$db->lastInsertId();
    $_SESSION['user_name']=$userName;
    $_SESSION['user_email']=$userEmail;
    $_SESSION['user_exp']=$exp;
    $_SESSION['user_coins']=$coins;

    //přesměrování na homepage
    header('Location: ../index.php');
    exit();
  }

  #endregion zpracování formuláře
}