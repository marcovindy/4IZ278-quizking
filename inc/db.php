<?php

  $db = new PDO('mysql:host=127.0.0.1;dbname=quizking;charset=utf8', 'root', '');

  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);