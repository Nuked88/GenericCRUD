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

// Get the list of tables in the database
$tables = getTables($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>RESTful GUI</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>RESTful GUI</h1>
        <p>Welcome, <?php echo getUsername($conn); ?>!</p>
        <p>Select a table to view and interact with the data:</p>
        <ul>
            <?php foreach ($tables as $table): ?>
                <li><a href="table.php?table=<?php echo $table; ?>"><?php echo $table; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>