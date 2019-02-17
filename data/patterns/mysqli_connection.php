<?php

  // Localhost configuration

  $dbServername = 'localhost';
  $dbUsername = 'root';
  $dbPassword = '';
  $dbName = 'lotusmain';

  $conn = mysqli_connect(
    $dbServername,
    $dbUsername,
    $dbPassword,
    $dbName
  );

?>