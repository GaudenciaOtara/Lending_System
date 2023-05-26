<?php
session_start();
include '../Functions/connect.php';
include '../Functions/checksession.php';
check_session();
if (isset($_SESSION['user'])){
    
$var_session=$_SESSION["user"];

$user_query = mysqli_query($conn,"select * from customer_reg where email='$var_session'");
$user_data = mysqli_fetch_assoc($user_query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lender Profile</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <nav>
    <div class="back">
    <a href="./index.php"><img src="../Images/back.png" alt="back" height="31px" width="40px"></a>
    </div>
<div class="details">

<h3>Personal Details</h3>
 
</div>
<div class="settings">
  <a href="settings.php"><img src="../Images/settings.png" alt="back" height="31px" width="40px"></a>
</div>
</nav>
<br>
<div class="profile">
<p>Profile</p>
<hr>
Name: <input type="text" placeholder="<?php echo $user_data['username'];?>" readonly class="input1"><br>
Email Address: <input type="text" placeholder="<?php echo $user_data['email'];?>" readonly><br>
ID Number: <input type="text" placeholder="<?php echo $user_data['ID_Number'];?>" readonly><br>
Phone No: <input type="text" placeholder="<?php echo $user_data['phonenumber'];?>" readonly><br>

</div>
 
</body>
</html>
<?php
    }
    else {
        echo "<script>
                location.replace('../login.php');
            </script>";
    }
 
 ?>