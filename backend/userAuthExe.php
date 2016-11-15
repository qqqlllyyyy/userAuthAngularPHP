<?php
include_once('connection.php');


// 1. Sign Up
if (isset($_GET['action']) && $_GET['action'] == 'signup') {
  // Get Data
  $data = json_decode(file_get_contents("php://input"));
  $username = $data -> username;
  $password = $data -> password;

  // Insert Into Database
  $info = array(
    'Username' => $username,
    'Password' => $password
  );
  $DB -> insert($CONFIG['TBL_USER'], $info);

  // Return
  echo json_encode($username);

  exit();
}



// 2. Login
if (isset($_GET['action']) && $_GET['action'] == 'login') {
  // Get Data
  $data = json_decode(file_get_contents("php://input"));
  $username = $data -> username;
  $password = $data -> password;

  // Select From Database
  $sql = "SELECT * FROM `{$CONFIG['TBL_USER']}`
        WHERE `Username`='{$username}'
        AND `Password`='{$password}'";
  $userInfo = $DB -> get_all($sql);

  // Return
  echo json_encode($userInfo);

  exit();
}
