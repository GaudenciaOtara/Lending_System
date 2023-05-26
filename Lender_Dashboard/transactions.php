<?php
session_start();
include '../Functions/connect.php';
include '../Functions/checksession.php';
check_session();
if (isset($_SESSION['user'])){
    
$var_session=$_SESSION["user"];

$user_query = mysqli_query($conn,"select * from lender_reg where email='$var_session'");
$user_data = mysqli_fetch_assoc($user_query);
$query = "SELECT account_number FROM agent_reg";
$result = mysqli_query($conn, $query);
$lender_details = mysqli_query($conn,"select * from lender_transactions where lender_id={$user_data['id']}");
$lender = mysqli_fetch_assoc($lender_details);


function generateUniqueCode($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    
    $charactersLength = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = mt_rand(0, $charactersLength - 1);
        $code .= $characters[$randomIndex];
    }
    
    return $code;
}

if (isset($_POST['lend'])){
$uniqueCode = generateUniqueCode(8);
$agent_number=$_POST['agent_account_number'];
$account_balance = $_POST['account_balance'];
$amount_lent = $_POST['lent_amount'];
$lender_id=$_POST['lender_id'];

$accountExists = false;
while ($agent = mysqli_fetch_assoc($result)) {
    if ($agent_number === $agent['account_number']) {
        $accountExists = true;
        break;
    }
}

if (!$accountExists) {
    echo "
    <script>
    alert('Account Number does not exist');
    </script>
    ";
}
elseif ($amount_lent > $account_balance) {
    echo"
    <script>
    alert('Insufficient Balance to make this transaction');
    </script>
    ";}
else{
    $time = date('H:i:s');
    $updatedBalance = $account_balance - $amount_lent;
    $updateQuery = "UPDATE lender_transactions SET account_balance = $updatedBalance WHERE lender_id = {$user_data['id']}";
    mysqli_query($conn, $updateQuery);
    $updatetable = "UPDATE lender_reg SET account_balance = $updatedBalance WHERE id = {$user_data['id']}";
    mysqli_query($conn, $updatetable);

$statement= $conn->prepare("INSERT into lender_transactions (agent_account_number,lent_amount,lender_id,time_allocated,unique_code) VALUES (?,?,?,?,?)");
$statement->bind_param("iiiss",$agent_number,$amount_lent,$lender_id,$time,$uniqueCode);
$statement->execute();
$statement->close();
$conn->close();
header("Location: ./transactions.php");
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
    <title>Transactions</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/transactions.css">

</head>
<body>
    <nav>
    <div class="back">
    <a href="./index.php"><img src="../Images/back.png" alt="back" height="31px" width="40px"></a>
    </div>
<div class="details">

<h3>Business Transactions</h3>
 
</div>
<div class="settings">
  <a href="settings.php"><img src="../Images/settings.png" alt="back" height="31px" width="40px"></a>
</div>
</nav>
<br>
<div class="profile">
<p>Money Credited</p>
<hr>
<div class="form">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
       
    <input type="text" value="<?php echo  $user_data['account_balance']?>" name="account_balance" readonly>

    <input type="number" placeholder="Amount to lend" name="lent_amount" >
    <br>
    <input type="number" placeholder="Account Number" class="bottom" name="agent_account_number"> 
    <input type="hidden" value="<?php echo $user_data['id']?>" class="bottom" name="lender_id"> 

   
<button  class="bottom" name="lend" >LEND</button>
</form>
</div>
</div>

<div class="form2">
<p>Money Returned</p>
<hr>
<select name="" id="">
    <option value="">Customer1</option>
</select>
</div>
<div class="form2">
<p>Profit</p>
<hr>
<select name="" id="">  
    <option value="">Customer1</option>
</select>
</div>
<a href="details.php"><button class="agentdetails">AGENTS DETAILS</button></a>
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