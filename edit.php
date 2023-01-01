<?php
include("functions.inc.php");


  // Connect to database
  $conn = connectToDb();
  if (!$conn) {
    die("Error connecting to database.");
  }

  // Get table and primary key value from URL
  $table = $_GET['table'];
  $pk_val = $_GET['id'];

  // Check if user is logged in
  if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
  }


  // Get data for current record
  $query = "SELECT * FROM $table WHERE id = $pk_val";
  $result = mysqli_query($conn, $query);
  if (!$result) {
    die("Error querying database.");
  }
  $row = mysqli_fetch_assoc($result);

  // Get list of columns in table
  $query = "SHOW COLUMNS FROM $table";
  $result = mysqli_query($conn, $query);
  if (!$result) {
    die("Error querying database.");
  }
  $columns = array();
  while ($row2 = mysqli_fetch_assoc($result)) {
    $columns[] = $row2['Field'];
  }
?>
<style>
/*https://css-tricks.com/the-cleanest-trick-for-autogrowing-textareas*/
.grow-wrap {
  /* easy way to plop the elements on top of each other and have them both sized based on the tallest one's height */
  display: grid;
}
.grow-wrap::after {
  /* Note the weird space! Needed to preventy jumpy behavior */
  content: attr(data-replicated-value) " ";

  /* This is how textarea text behaves */
  white-space: pre-wrap;

  /* Hidden from view, clicks, and screen readers */
  visibility: hidden;
}
.grow-wrap > textarea {
  /* You could leave this, but after a user resizes, then it ruins the auto sizing */
  resize: none;

  /* Firefox shows scrollbar on growth, you can hide like this. */
  overflow: hidden;
}
.grow-wrap > textarea,
.grow-wrap::after {
  /* Identical styling required!! */
  border: 1px solid black;
  padding: 0.5rem;
  font: inherit;

  /* Place on top of each other */
  grid-area: 1 / 1 / 2 / 2;
}

</style>

<!-- HTML form for editing record -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<div class="container mt-5">
  <form action="update.php" method="post" class="form-group">
    <input type="hidden" name="table" value="<?php echo $table; ?>">
    <input type="hidden" name="pk_val" value="<?php echo $pk_val; ?>">
    <div class="card shadow-lg">
      <div class="card-body">
        <h3 class="card-title mb-5">Edit Record</h3>
        <?php foreach ($columns as $column) { ?>
          <div class="form-group">
            <label for="<?php echo $column; ?>"><?php echo $column; ?>:</label>
            <?php $content = htmlentities($row[$column]); ?>
            <?php if(strlen($content)>$expandfieldat){?>
            <div class="grow-wrap">
            <textarea name="<?php echo $column; ?>" onfocus="this.parentNode.dataset.replicatedValue = this.value"  onInput="this.parentNode.dataset.replicatedValue = this.value" class="form-control"><?php echo $content; ?></textarea>
            </div>
            <?php }else{ ?>
            <input name="<?php echo $column; ?>" value = "<?php echo $content; ?>" class="form-control">

           <?php } ?>
          </div>
        <?php } ?>
        <div class="form-group mt-5">
          <input type="submit" value="Update" class="btn btn-primary">
        </div>
      </div>
    </div>
  </form>
</div>
<style>
  .card {
    width: 50%;
    margin: 0 auto;
  }
</style>