<?php
require("config.inc.php");

if (!session_id()) {
  session_start();
}

function isLoggedIn() {
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
      return true;
    } else {
      return false;
    }
  }



function connectToDb() {
    require("config.inc.php");
    $conn = mysqli_connect($host, $username, $password, $database);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function getTableData($conn, $table) {
    $sql = "SELECT * FROM $table";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $data = array();
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
      return $data;
    } else {
      return false;
    }
  }

  function getTableColumns($conn,$table) {
  
    $columns = array();
    
    $query = "SHOW COLUMNS FROM $table";
    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_assoc($result)) {
    $columns[] = $row['Field'];
    }
    
    return $columns;
    }

  function getUsername($conn) {
    // Check if user is logged in
    if (!isLoggedIn()) {
    return null;
    }
    
    // Get user id of logged in user
    $user_id = $_SESSION['user_id'];
    
    // Query database to get username of logged in user
    $query = "SELECT username FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
    return null;
    }
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    
    return $username;
    }


  function getTables($conn) {

        // Query the database to retrieve a list of all tables
        $query = "SHOW TABLES";
        $result = mysqli_query($conn, $query);
        // Initialize an empty array to store the table names
        $tables = array();
        // Loop through the result set and add each table name to the array
        while($row = mysqli_fetch_array($result)) {
            array_push($tables, $row[0]);
        }
        // Return the array of table names
        return $tables;
    }


?>


