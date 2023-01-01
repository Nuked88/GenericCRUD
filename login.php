<?php
include("functions.inc.php");

$conn= connectToDb();

print_r($_SESSION);
// Check if form was submitted
if (isset($_POST['username'])) {
    // Get username and password from form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if username and password are not empty
    if (!empty($username) && !empty($password)) {
        // Query database for user with matching username and password
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);
        echo $query;
        // Check if query returned a result
        if (mysqli_num_rows($result) > 0) {
            // Set session variable for logged in user
            $_SESSION['user_id'] = mysqli_fetch_assoc($result)['id'];
            // Redirect user to index page
            header("Location: index.php");
            exit();
        } else {
            // Display error message if username or password is incorrect
            $error = "Invalid username or password";
        }
    } else {
        // Display error message if username or password is empty
        $error = "Please enter a username and password";
    }
}

?>
<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="styles.css">-->
  </head>
  <body>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="card">
            <div class="card-header">
              <h3 class="mb-0">Login</h3>
            </div>
            <div class="card-body">
              <form action="login.php" method="post">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>