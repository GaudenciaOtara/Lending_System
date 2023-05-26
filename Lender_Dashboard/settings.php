<?php
session_start();
include '../Functions/connect.php';
include '../Functions/checksession.php';
check_session();
if (isset($_SESSION['user'])){
    
$var_session=$_SESSION["user"];

$user_query = mysqli_query($conn,"select * from lender_reg where email='$var_session'");
$user_data = mysqli_fetch_assoc($user_query);

if (isset($_POST['update'])){

   
  $username=$_POST['username'];
  $email=$_POST['email'];
  $phone=$_POST['phonenumber'];
  
  
    $user_id=$user_data['id'];
    $query = "UPDATE lender_reg SET username=?, email=?, phonenumber=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssii", $username, $email, $phone,$user_id);
    $stmt->execute();
    
    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
      echo "Profile updated successfully!";
    } else {
      echo "Failed to update profile.";
    }
    
     $stmt->close();
    $conn->close();
    header("Location: ./settings.php");

    exit();
  
  
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Settings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/settings.css">

</head>
<body>
    <nav>
    <div class="back">
    <a href="./index.php"><img src="../Images/back.png" alt="back" height="31px" width="40px"></a>
    </div>
<div class="details">

<h3>Settings</h3>
 
</div>
<!-- <div class="settings">
  <a href="settings.php"><img src="../Images/settings.png" alt="back" height="31px" width="40px"></a>
</div> -->
</nav>
<br>
<div class="profile">
<p>Profile</p>
<hr>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

  Name: <input type="text" placeholder="<?php echo $user_data['username']; ?>" readonly><br>
  Email Address: <input type="text" placeholder="<?php echo $user_data['email']; ?>" readonly><br>
  ID Number: <input type="text" placeholder="<?php echo $user_data['ID_Number']; ?>" readonly><br>
  Phone No: <input type="text" placeholder="<?php echo $user_data['phonenumber']; ?>" readonly><br>
  <button type="button"  data-toggle="modal" data-target="#updateModal">UPDATE PROFILE</button>
 
<!-- Add a Bootstrap modal for updating the profile -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form fields for updating the profile information -->
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" class="form-control" value="<?php echo $user_data['username']; ?>" name="username">
          </div>
          <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="text" id="email" class="form-control" value="<?php echo $user_data['email']; ?>" name="email">
          </div>
          
          <div class="form-group">
            <label for="phone_number">Phone No:</label>
            <input type="text" id="phone_number" class="form-control" value="<?php echo $user_data['phonenumber']; ?>" name="phonenumber">
          </div>
          
          <button type="submit" class="btn btn-primary" name="update">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
 <!-- Add Bootstrap JavaScript and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
<?php
    }
    else {
        echo "<script>
                location.replace('../agentlogin.php');
            </script>";
    }
 
 ?>