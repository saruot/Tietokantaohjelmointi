<?php

function openDb(): object {
  $host = 'mysli.oamk.fi';
  $database = 'opisk_n2rusa00';
  $user = 'n2rusa00';
  $password = 'DSG5bP8u3kbzp42y';
      try {
          $db = new PDO("mysql:host=$host;dbname=$database;charset=utf8",$user,$password);
          $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
          return $db;
      } catch (PDOException $pdoex) {
        echo $pdoex;
    }
  } 