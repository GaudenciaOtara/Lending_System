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
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
<button id="topUpButton" data-toggle="modal" data-target="#topUpModal" style="margin-left:1%;";>Top Up</button>
</div>

 <!-- TOP UP Bootstrap Modal -->
<div class="modal fade" id="topUpModal" tabindex="-1" role="dialog" aria-labelledby="topUpModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="topUpModalLabel">Top Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="topUpForm" action="./process_topup.php" method="POST">
          <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="text" class="form-control" id="amount" name="amount" required>
          </div>
          <div class="form-group">
            <label for="phoneNumber">Phone Number:</label>
            <input type="number" class="form-control" id="phoneNumber" name="phoneNumber" required>
          </div>
           
            <input type="hidden" class="form-control" id="lender_id" name="customer_id" value="<?php echo $user_data['id'];?>" required>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
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