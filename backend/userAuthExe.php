<?php
include_once('connection.php');

//--------------------------------------------------------------------------------------
// 1. Sign Up
//--------------------------------------------------------------------------------------

if (isset($_GET['action']) && $_GET['action'] == 'signup') {
  // Get Data
  $data = json_decode(file_get_contents("php://input"));
  $username = $data -> username;
  $password = $data -> password;

  // Select From Database
  $sql = "SELECT * FROM `{$CONFIG['TBL_USER']}`
        WHERE `Username`='{$username}'";
  $userInfo = $DB -> get_all($sql);
  if (count($userInfo) > 0) {
    echo 'ERROR';
    exit();
  }

  // Insert Into Database
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

if (isset($_GET['action']) && $_GET['action'] == 'login') {

  // Get Post Data
  $data = json_decode(file_get_contents("php://input"));
  $username = $data -> username;
  $password = $data -> password;

  // Select From Database
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

if (isset($_GET['action']) && $_GET['action'] == 'logout') {

  // Get Post Data
  $data = json_decode(file_get_contents("php://input"));
  $token = $data -> token;
  $token = substr($token, 1, strlen($token) - 2); // Why $token has double quote outside?

  // Update Database
  $info = array('Token' => 'LOGGED OUT');
  $DB -> update($CONFIG['TBL_USER'], $info, "`Token`='" . $token . "'");

  // Return
  echo json_encode($data);
  exit();
}




//--------------------------------------------------------------------------------------
// 4. Check Token
//--------------------------------------------------------------------------------------

if (isset($_GET['action']) && $_GET['action'] == 'checkToken') {

  // Get Post Data
  $data = json_decode(file_get_contents("php://input"));
  $token = $data -> token;
  $token = substr($token, 1, strlen($token) - 2); // Why $token has double quote outside?

  // Select from Database
  $sql = "SELECT * FROM `{$CONFIG['TBL_USER']}` WHERE `Token`='$token'";
  $check = $DB -> get_all($sql);

  if (count($check) == 1) {
    echo 'authorized';
  } else {
    echo 'unauthorized';
  }


  exit();
}
