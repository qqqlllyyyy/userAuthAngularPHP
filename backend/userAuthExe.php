<?php
include_once('connection.php');

//--------------------------------------------------------------------------------------
// 1. Sign Up
//--------------------------------------------------------------------------------------
//  1) Get post data
//  2) Select from database
//  3) Insert into database
//  4) Return
//--------------------------------------------------------------------------------------

if (isset($_GET['action']) && $_GET['action'] == 'signup') {

  // Get post data
  $data = json_decode(file_get_contents("php://input"));
  $username = $data -> username;
  $password = $data -> password;

  // Select from database
  $sql = "SELECT * FROM `{$CONFIG['TBL_USER']}`
        WHERE `Username`='{$username}'";
  $userInfo = $DB -> get_all($sql);
  if (count($userInfo) > 0) {
    echo 'ERROR';
    exit();
  }

  // Insert into database
  $token = $username . " | " . uniqid() . uniqid() . uniqid();
  $info = array(
    'Username'   => $username,
    'Password'   => sha1($password),
    'Token'      => $token
  );
  $DB -> insert($CONFIG['TBL_USER'], $info);

  // Return
  echo json_encode($token);
  exit();
}




//--------------------------------------------------------------------------------------
// 2. Login
//--------------------------------------------------------------------------------------
//  1) Get post data
//  2) Select from database
//  3) If loggedin, give him a token
//  4) Update database with the token
//  5) Return
//--------------------------------------------------------------------------------------

if (isset($_GET['action']) && $_GET['action'] == 'login') {

  // Get post data
  $data = json_decode(file_get_contents("php://input"));
  $username = $data -> username;
  $password = $data -> password;

  // Select from database
  $sql = "SELECT * FROM `{$CONFIG['TBL_USER']}`
        WHERE `Username`='{$username}'
        AND `Password`='" . sha1($password) . "'";
  $userInfo = $DB -> get_all($sql);

  // If loggedin, give him a token
  $token = 'a';
  if (count($userInfo) == 1) {
    $token = $username . " | " . uniqid() . uniqid() . uniqid();
  } else {
    echo 'ERROR';
    exit();
  }

  // Update database with the token
  $info = array('Token' => $token);
  $DB -> update($CONFIG['TBL_USER'], $info, "`Username`='" . $username . "'");

  // Return
  echo json_encode($token);
  exit();
}




//--------------------------------------------------------------------------------------
// 3. Logout
//--------------------------------------------------------------------------------------
//  1) Get post data
//  2) Update database
//  3) Return
//--------------------------------------------------------------------------------------

if (isset($_GET['action']) && $_GET['action'] == 'logout') {

  // Get post data
  $data = json_decode(file_get_contents("php://input"));
  $token = $data -> token;
  $token = substr($token, 1, strlen($token) - 2); // Why $token has double quote outside?

  // Update database
  $info = array('Token' => 'LOGGED OUT');
  $DB -> update($CONFIG['TBL_USER'], $info, "`Token`='" . $token . "'");

  // Return
  echo json_encode($data);
  exit();
}




//--------------------------------------------------------------------------------------
// 4. Check Token
//--------------------------------------------------------------------------------------
//  1) Get post data
//  2) Select from database
//  3) Return
//--------------------------------------------------------------------------------------

if (isset($_GET['action']) && $_GET['action'] == 'checkToken') {

  // Get post data
  $data = json_decode(file_get_contents("php://input"));
  $token = $data -> token;
  $token = substr($token, 1, strlen($token) - 2); // Why $token has double quote outside?

  // Select from database
  $sql = "SELECT * FROM `{$CONFIG['TBL_USER']}` WHERE `Token`='$token'";
  $check = $DB -> get_all($sql);

  // Return
  if (count($check) == 1) {
    echo 'authorized';
  } else {
    echo 'unauthorized';
  }

  exit();
}
