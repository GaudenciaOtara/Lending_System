<?php
session_start();
include '../Functions/connect.php';
include '../Functions/agentchecksession.php';
check_session();
if (isset($_SESSION['user'])){
    
$var_session=$_SESSION["user"];

$user_query = mysqli_query($conn,"select * from agent_reg where email='$var_session'");
$user_data = mysqli_fetch_assoc($user_query);
$query = "SELECT lent_amount FROM lender_transactions WHERE agent_account_number=?";
$statement = $conn->prepare($query);
$statement->bind_param("s", $user_data["account_number"]);
$statement->execute();
$result = $statement->get_result();
$numbers = [];
while ($row = $result->fetch_assoc()) {
    $numbers[] = $row['lent_amount'];
}
$accumulatedTotal = array_sum($numbers);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <nav>
    <div class="back">
    <a href="../Functions/agentlogout.php"><img src="../Images/back.png" alt="back" height="31px" width="40px"></a>
    </div>
<div class="details">

<h3>Agent</h3>
<p>Hi <?php echo $user_data['username']; ?>!</p>
</div>
<div class="settings">
  <a href="settings.php"><img src="../Images/settings.png" alt="back" height="31px" width="40px"></a>
</div>
</nav>
<br>
<h4>Your Account Balance is <?php echo "Ksh". $accumulatedTotal; ?></h4>

<div class="buttons">
   <a href="reports.php"> <button>Reports</button></a>
   <a href="lendermoney.php"> <button class="button2">Money Allocated by Lenders </button></a>
</div><br>
<div class="buttons">
   <a href="profile.php"> <button>Profile Details</button></a>
   <a href="customermoney.php"> <button class="button2">Money Assigned  </button></a>
</div>
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