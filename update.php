<?php
include("functions.inc.php");

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$table_name = $_POST['table'];


$conn = connectToDb();

$id = $_POST['pk_val'];
$columns = array();
$values = array();

// Loop through all the columns in the table and get the new values
foreach ($_POST as $key => $value) {
    if ($key != 'pk_val' && $key != 'table' ) {
        $columns[] = $key;
        $values[] = $value;
    }
}

// Build the update query
$query = "UPDATE $table_name SET ";
for ($i = 0; $i < count($columns); $i++) {
    $column = $columns[$i];
    $value = html_entity_decode($values[$i]);
    $value = mysqli_real_escape_string($conn,$value);
    #re-encode in html
    
    $query .= "$column='$value'";
    if ($i != count($columns) - 1) {
        $query .= ", ";
    }
}
$query .= " WHERE id=$id";

if ($conn->query($query)) {
    // Update successful, redirect back to the table view
    header("Location: table.php?table=$table_name");
} else {
    // Update failed, display error message
    echo "Error updating record: " . $conn->error;
}

$conn->close();

?>