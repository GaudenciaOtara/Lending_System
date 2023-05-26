<?php
session_start();
include '../Functions/connect.php';
include '../Functions/customerchecksession.php';
check_session();
if (isset($_SESSION['user'])){
    
$var_session=$_SESSION["user"];

$user_query = mysqli_query($conn,"select * from customer_reg where email='$var_session'");
$user_data = mysqli_fetch_assoc($user_query);
$phoneNumber=$user_data['phonenumber'];
$agent_transactions = mysqli_query($conn,"select * from customer_money where customer_number='$phoneNumber'");
$agent_trans = mysqli_fetch_assoc($agent_transactions);
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lender Dashboard</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <nav>
    <div class="back">
    <a href="../Functions/customerlogout.php"><img src="../Images/back.png" alt="back" height="31px" width="40px"></a>
    </div>
<div class="details">

<h3>Customer</h3>
<p>Hi <?php echo $user_data['username']; ?>!</p>
</div>
<div class="settings">
  <a href="settings.php"><img src="../Images/settings.png" alt="back" height="31px" width="40px"></a>
</div>
</nav>
<br>
<div class="buttons">
   <a href="profile.php"> <button>My Details</button></a>
   <a href="transactions.php"> <button class="button2">Business Transactions </button></a>
</div>
<!-- <div class="buttons">
   <a href="profile.php"> <button>Top up</button></a>
</div> -->
</body>
</html>
<?php
    }
    else {
        echo "<script>
                location.replace('../customerlogin.php');
            </script>";
    }
 
 ?>