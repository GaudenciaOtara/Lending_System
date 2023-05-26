<?php
session_start();
include '../Functions/connect.php';
include '../Functions/checksession.php';
check_session();
if (isset($_SESSION['user'])){
    
$var_session=$_SESSION["user"];

$user_query = mysqli_query($conn,"select * from customer_reg where email='$var_session'");
$user_data = mysqli_fetch_assoc($user_query);
$phoneNumber=$user_data['phonenumber'];
$cus_ID=$user_data['id'];


$agent_transactions = mysqli_query($conn,"select * from customer_money where customer_number='$phoneNumber'");
$agent_trans = mysqli_fetch_assoc($agent_transactions);
$sumLentAmount = 0;  
$expectedInterest=0;
$totalamount=0;


// / Iterate over the fetched rows and sum the lent_amount
while ($row = mysqli_fetch_assoc($agent_transactions)) {
    $sumLentAmount += $row['amount_lent'];
    $expectedInterest+=$row['expected_interest'];
    $totalamount+=$row['total_amount'] ;

}
$customer_transactions = mysqli_query($conn,"select * from customer_returns where customer_id='$cus_ID'");
$customer_trans = mysqli_fetch_assoc($customer_transactions);
$remInterest=0;
$remamount=0;


// / Iterate over the fetched rows and sum the lent_amount
while ($rows = mysqli_fetch_assoc($customer_transactions)) {
    $remInterest+=$rows['expected_interest'];
    $remainingInterest=$expectedInterest-$remInterest;
    $remamount+=$rows['amount_sent'] ;
    $remainingTotal=$totalamount-$remamount;

}


if (isset($_POST['send'])){
    $agent_id=$_POST['agent_id'];
    $amount_sent = $_POST['amount_sent'];
    $unique_code = $_POST['unique_code'];
    $interest = $_POST['expected_interest'];
    $ID = $_POST['customer_id'];

    $statement= $conn->prepare("INSERT into customer_returns (agent_id,amount_sent,unique_code,expected_interest,customer_id) VALUES (?,?,?,?,?)");
    $statement->bind_param("idsdi",$agent_id,$amount_sent,$unique_code,$interest,$ID);
    $statement->execute();
    $statement->close();
    header("Location: ./transactions.php");
    exit();
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
<p>Loan</p>
<hr>
<div class="form">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
     <input type="number" placeholder="Amount Received" value="<?php echo $sumLentAmount; ?>" class="bottom"> 
<?php

       ?>
</form>
</div>
</div>

<div class="form2">
<p>Withdraw</p>
<hr>
<input type="number" placeholder="Amount to Withdraw" value="" class="bottom" name="lender_id"> 
 <button>Withdraw</button>
</div>
<div class="form2">
<p>Interest(12%)</p>
<hr>
<input type="number" placeholder="Accumulated interest" value="<?php echo $expectedInterest; ?>" class="bottom" name="lender_id"> 
</div>
<div class="form2">
<p>Amount(Interest+Principal)</p>
<hr>
<input type="number"  value="<?php echo $totalamount; ?>" class="bottom" name="lender_id">  

</div>
<div class="form2">
<p>Remaining Balance</p>
<hr>
<input type="number"  value="<?php echo $remainingTotal; ?>" class="bottom" name="">  
<input type="number"  value="<?php echo $remainingInterest; ?>" class="bottom" name="">  

</div>
<div class="form2">
<p>Topup</p>
<hr>
<button style="margin-left:1%;";>TOP UP</button>
</div>
<div class="form2">
<p>Loan Payment</p>
<hr>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

<input type="number" placeholder="Agent's ID" value="" class="bottom" name="agent_id">  
<input type="text" placeholder="Amount to send to Agent" value="" class="bottom" name="amount_sent"> 
<input type="text" placeholder="Unique Code" value="" class="bottom" name="unique_code"> 
<input type="text" placeholder="Expected Interest" value="" class="bottom" name="expected_interest"> 
<input type="hidden" placeholder="Customer ID" value="<?php echo $user_data['id']; ?>" class="bottom" name="customer_id"> 



<br>
      
<?php
$stmt = $conn->prepare("SELECT * from customer_money WHERE customer_number='$phoneNumber'");
$stmt->execute();
$result = $stmt->get_result();
?>

<div id="customerSelect">
    <select name="customer" id="customer">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id'] . '">' . $row['id'] . "-" . $row['unique_code'] . '</option>';
        }
        ?>
    </select>
<button style="margin-left:3%; margin-bottom:5%;"; name="send">SEND</button>
</form>
</div>

<div id="customerDetails"></div>

<script>
    function getCustomerDetails() {
        var selectedCustomerId = document.getElementById("customer").value;

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "fetch_customer_details.php?id=" + selectedCustomerId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Parse the JSON response
                var response = JSON.parse(xhr.responseText);

                // Update the input fields with the customer details
                document.getElementsByName("agent_id")[0].value = response.customerName;
                document.getElementsByName("amount_sent")[0].value = response.customerEmail;
                document.getElementsByName("unique_code")[0].value = response.transactionCode;
                document.getElementsByName("expected_interest")[0].value = response.expectedInterest;

                // document.getElementByName("unique_code")[0].value=response.transactionCode;

            }
        };
        xhr.send();
    }

    document.getElementById("customer").addEventListener("change", getCustomerDetails);
</script>

 <br> <br>


</div>
 <br>
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
  