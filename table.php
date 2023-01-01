<?php
include("functions.inc.php");

// Check if the user is logged in
if (!isLoggedIn()) {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}

// Connect to the database
$conn = connectToDb();

// Get the name of the table from the query string
$table = $_GET['table'];

// Get the data from the table
$data = getTableData($conn, $table);

$columns = getTableColumns($conn, $table);

?>
<!DOCTYPE html>
<html>
<head>
  <title>RESTful GUI</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
  <div class="table-div" style="margin: 0 auto;">
    <h1><?php echo $table; ?></h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <?php foreach ($columns as $column) { ?>
            <th><?php echo $column; ?></th>
          <?php } ?>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $row) { ?>
          <tr>
            <?php foreach ($columns as $column) { ?>
              <td><?php echo htmlentities($row[$column]); ?></td>
            <?php } ?>
            <td>
              <a href="edit.php?table=<?php echo $table; ?>&id=<?php echo $row['id']; ?>" class="btn btn-secondary">Edit</a>
              <a href="delete.php?table=<?php echo $table; ?>&id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <a href="add.php?table=<?php echo $table; ?>" class="btn btn-primary">Add New Record</a>
  </div>
</body>
</html>