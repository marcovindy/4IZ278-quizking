<?php

session_start(); //spustíme session

require_once 'db.php'; //načteme připojení k databázi

#region kontrola, jestli je přihlášený uživatel platný
if (!empty($_SESSION['user_id'])) {
    $userQuery = $db->prepare('SELECT user_id FROM users WHERE user_id=:id LIMIT 1;');
    $userQuery->execute([
        ':id' => $_SESSION['user_id']
    ]);
    if ($userQuery->rowCount() != 1) {
        //uživatel už není v DB, nebo není aktivní => musíme ho odhlásit
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_exp']);
        unset($_SESSION['user_coins']);
        header('Location: index.php');
        exit();
    }
}
  #endregion kontrola, jestli je přihlášený uživatel platný