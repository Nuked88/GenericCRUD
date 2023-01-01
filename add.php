<?php
include_once 'functions.inc.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}


$conn = connectToDb();
$table = $_GET['table'];
$columns = getTableColumns($conn,$table);

# removing the id fields
$columns = array_filter($columns, function($item) {
    return $item != 'id';
    });
$column_string = implode(', ', $columns);

if (isset($_POST['submit'])) {
    $values = array();
    foreach ($columns as $column) {
        $values[] = "'" . $_POST[$column] . "'";
    }
    $values = implode(',', $values);
    $sql = "INSERT INTO $table ($column_string) VALUES ($values)";
    echo $sql;
    $result = $conn->query($sql);
    if ($result) {
        header("Location: table.php?table=$table");
        exit();
    } else {
        $error = "There was an error inserting the data. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Data</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <?php foreach ($columns as $column): ?>
                <div class="form-group">
                    <label for="<?php echo $column; ?>"><?php echo $column; ?></label>
                    <input type="text" name="<?php echo $column; ?>" id="<?php echo $column; ?>" class="form-control">
                </div>
            <?php endforeach; ?>
            <button type="submit" name="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</body>
</html>