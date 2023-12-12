<?php
session_start();
if (isset($_SESSION['userId'])) {
  header("Location: index.php");
  die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <link rel="stylesheet" href="../css/styles.css">

  <title>Registration</title>
</head>
<body>
    <div class="container rounded d-flex justify-content-between">
      <div class="container-form">
        <h2 class="form-title mb-4">Registration</h2>
        <?php
if (isset($_POST['submit'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    
    // Check if the "occupation" key exists before accessing it
    $occupation = isset($_POST['occupation']) ? $_POST['occupation'] : '';
    
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $passwordConfirm = isset($_POST['passwordConfirm']) ? $_POST['passwordConfirm'] : '';

    $errors = array();

    if (strlen($password) < 8) {
        array_push($errors, "The password must be at least 8 characters");
    }
    if ($password !== $passwordConfirm) {
        array_push($errors, "The passwords do not match");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger' role='alert'>$error</div>";
        }
    } else {
        require_once "../connDB.php"; // Check the path here
        require_once "../controller/control.php"; // Check the path here
        $sql = new control(); // Make sure control class is defined
        $result = $sql->c_signUp($username, $email, $password, $address, 
        $phone, $occupation);
        if ($result == 'success') {
            echo "<div class='alert alert-success' role='alert'>Registration success</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Registration failed</div>";
        }
    }
}
?>
        <form action="registration.php" method="post">
          <div class="form-group">
            <div class="form-label">Username</div>
            <input type="text" name="username" class="form-control rounded" placeholder="Write your username" required>
          </div>
          <div class="form-group">
            <div class="form-label">Email</div>
            <input type="email" name="email" class="form-control rounded" placeholder="Write your email" required>
          </div>
          <div class="form-group">
            <div class="form-label">Phone Number</div>
            <input type="tel" name="phone" class="form-control rounded" placeholder="Write your phone number" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}" required>
          </div>
          <div class="form-group">
            <div class="form-label">Occupation</div>
            <input type="text" name="occupation" class="form-control rounded" placeholder="Write your occupation" required>
          </div>
          <div class="form-group">
            <div class="form-label">Address</div>
            <textarea name="address" class="form-control rounded" placeholder="Write your address" rows="4" cols="30" required></textarea>
          </div>
          <div class="form-group">
            <div class="form-label">Password</div>
            <input type="password" name="password" class="form-control rounded" placeholder="Write your password" required>
          </div>
          <div class="form-group">
            <div class="form-label">Confirmation Password</div>
            <input type="password" name="passwordConfirm" class="form-control rounded" placeholder="Write your password again" required>
          </div>
          <div class="submit-button mt-5">
            <input type="submit" name="submit" class="btn btn-light btn-block" value="Register">
          </div>
        </form>
      </div>
      <div class="container-img">
        <img src="../pictures/regist-img.png" alt="registration" class="img-fluid mt-5">
      </div>
    </div>
</body>
</html>
