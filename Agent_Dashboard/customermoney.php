<?php
session_start();
Require '../Functions/connect.php';
Require '../Functions/agentchecksession.php';
check_session();
if (isset($_SESSION['user'])){
    
$var_session=$_SESSION["user"];

$user_query = mysqli_query($conn,"select * from agent_reg where email='$var_session'");
$user_data = mysqli_fetch_assoc($user_query);
$user_transactions=mysqli_query($conn,"select * from lender_transactions where agent_account_number='{$user_data["account_number"]}'");
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
$id=$user_data['id'];

if (isset($_POST['send'])){
    $customer_number=$_POST['customer_number'];
    $account_balance = $_POST['account_balance'];
    $amount_lent = $_POST['amount_lent'];
    $expected_interest=$_POST['expected_interest'];
    $agent_id=$_POST['agent_id'];
    $total_amount=$_POST['total_amount'];

   
    if ($amount_lent > $account_balance) {
        echo"
        <script>
        alert('Insufficient Balance to make this transaction');
        </script>
        ";}
    else{
        $time = date('H:i:s');
        $updatedBalance = $account_balance - $amount_lent;
        $updateQuery = "UPDATE customer_money SET account_balance = $updatedBalance WHERE agent_id = {$user_data['id']}";
        mysqli_query($conn, $updateQuery);
        $updatetable = "UPDATE agent_reg SET account_balance = $updatedBalance WHERE id = {$user_data['id']}";
        mysqli_query($conn, $updatetable);
    
    $statement= $conn->prepare("INSERT into customer_money (account_balance,customer_number,amount_lent,expected_interest,total_amount,time_allocated,agent_id) VALUES (?,?,?,?,?,?,?)");
    $statement->bind_param("iiiiisi",$account_balance,$customer_number,$amount_lent,$expected_interest,$total_amount,$time,$agent_id);
    $statement->execute();
    $statement->close();
    $conn->close();
    header("Location: ./customermoney.php");
    exit();
         
    }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/customermoney.css">
    <link rel="stylesheet" href="../css/table.css">
</head>
<body>
    <nav>
    <div class="back">
    <a href="./index.php"><img src="../Images/back.png" alt="back" height="31px" width="40px"></a>
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
 <div class="assign-money">


 

 </div>
 <div class="table" style="margin-top:3%;";>
 <h2>Money Assigned Reports</h2><hr>
    <table>
        <thead class="head">
                <td>ID</td>
                <td>Money Allocated </td>
                <td>Time Allocated</td>
                <!-- <td>Due Date</td> -->
                <td>Customer Number</td>
                <td>Amount Returned</td>
            
        </thead>
        <tbody>
        <?php
    $id_count = 0;
    $account_no=$user_data['account_number'];
    $stmt = $conn->prepare("SELECT * from customer_money where agent_id='$id'");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
      
      ?>
            <tr>
                <td><?php echo $id_count; ?></td>
                <td><?php echo $row['amount_lent']; ?></td>
                <td><?php echo $row['time_allocated']; ?></td>
          
                <td><?php echo $row['customer_number']; ?></td>
                <td><?php echo $row['total_amount']; ?></td>
            </tr>
            <?php $id_count = $id_count + 1 ;} ?>
        </tbody>
    </table>
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