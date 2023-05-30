<?php
session_start();
Require '../Functions/connect.php';
Require '../Functions/checksession.php';
check_session();
if (isset($_SESSION['user'])){
    
$var_session=$_SESSION["user"];

$user_query = mysqli_query($conn,"select * from lender_reg where email='$var_session'");
$user_data = mysqli_fetch_assoc($user_query);
$lender_id=$user_data['id'];
$lender_transactions = mysqli_query($conn,"select * from lender_transactions where id='$lender_id'");
$lender_trans = mysqli_fetch_assoc($lender_transactions);
$updated_details = mysqli_query($conn, "SELECT * FROM lender_transactions WHERE lender_id={$user_data['id']}");
$updated_commision = mysqli_query($conn, "SELECT * FROM agent_commision WHERE lender_id={$user_data['id']}");
$sum = 0;
while ($row = mysqli_fetch_assoc($updated_details)) {
    $sum += $row['lent_amount'];
}
$comm = 0;
while ($row = mysqli_fetch_assoc($updated_commision)) {
    $comm += $row['commision'];
}
$updated_returns = mysqli_query($conn, "SELECT * FROM agent_returns WHERE lender_id={$user_data['id']}");
$returns = 0;
while ($rowss= mysqli_fetch_assoc($updated_returns)) {
    $returns += $rowss['total_amount'];
}
$lender_id = $user_data['id'];

$sql = "SELECT SUM(amount) AS balance
        FROM top_up
        WHERE lender_id = '$lender_id'";

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $balance = $row['balance'];
} else {
    echo "Error executing query: " . $conn->error;
}

$updated_balance = $balance - $sum+$returns-$comm;

$updates = "UPDATE lender_reg
            SET updated_balance = $updated_balance
            WHERE id = '$lender_id'";

if ($conn->query($updates) === TRUE) {
     
} else {
    echo "Error updating table: " . $conn->error;
}


if (isset($_POST['commision_send'])){
  $lender_id=$_POST['lender_id'];
  $agent_acc_no = $_POST['agent_account_number'];
  $unique_code = $_POST['unique_code'];
  $commision = $_POST['commision'];
  // $ID = $_POST['customer_id'];
  echo $commision;
echo $agent_acc_no;
echo $unique_code;
  $statement= $conn->prepare("INSERT into agent_commision (agent_account_number,unique_code,commision,lender_id) VALUES (?,?,?,?)");
  $statement->bind_param("isdi",$agent_acc_no,$unique_code,$commision,$lender_id);
  $statement->execute();
  $statement->close();
  header("Location: ./index.php");
  exit();
}
?>

 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lender Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <nav>
    <div class="back">
    <a href="../Functions/logout.php"><img src="../Images/back.png" alt="back" height="31px" width="40px"></a>
    </div>
<div class="details">

<h3>Lender</h3>
<p>Hi <?php echo $user_data['username']; ?>!</p>
</div>
<div class="settings">
  <a href="settings.php"><img src="../Images/settings.png" alt="back" height="31px" width="40px"></a>
</div>
</nav>
<br>
<h4>Your Account Balance is <?php echo"Ksh ". $updated_balance;?></h4>
<div class="buttons">
   <a href="profile.php"> <button>Personal Details</button></a>
   <a href="transactions.php"> <button class="button2">Business Transactions </button></a>
</div>
<div class="buttons">
<button id="topUpButton" data-toggle="modal" data-target="#topUpModal">Top Up</button>
<button id="commissionButton" class="bottom" data-toggle="modal" data-target="#commissionModal" style="margin-left:1%;";>Send Commision</button>
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
      <form id="topUpForm" action="../PAYMENT/process_topup.php" method="POST">
          <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="text" class="form-control" id="amount" name="amount" required>
          </div>
          <div class="form-group">
            <label for="phoneNumber">Phone Number:</label>
            <input type="number" class="form-control" id="phoneNumber" name="phoneNumber" required>
          </div>
           
            <input type="hidden" class="form-control" id="lender_id" name="lender_id" value="<?php echo $user_data['id'];?>" required>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>




 
<!-- SEND COMMISION Modal -->
<div class="modal fade" id="commissionModal" tabindex="-1" role="dialog" aria-labelledby="commissionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="commissionModalLabel">Commission Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <div class="form-group">
            <label for="name">Account Number</label>
            <input type="number" class="form-control" id="name" name="agent_account_number" placeholder="Enter Value">
          </div>
          <div class="form-group">
            <label for="Commision">Expected Commision</label>
            <input type="text" class="form-control" id="email" name="commision" placeholder="Enter your Value">
          </div>
          <div class="form-group">
            <label for="subject">Unique Code</label>
            <input type="text" class="form-control" id="subject" name="unique_code" placeholder="Enter Value">
            <input type="hidden" class="form-control" value="<?php echo $user_data['id'];?>" name="lender_id">

          </div>
          <div class="form-group">
            <label for="selectOption">Options</label>
            <select class="form-control" id="selectOption">
    <option value="">Select Transaction Code</option> 
            <?php
        $state = $conn->prepare("SELECT * FROM agent_returns where lender_id='$lender_id' ");
        $state->execute();
        $res = $state->get_result();
        while ($rows = $res->fetch_assoc()) {
          echo '<option value="' . $rows['unique_code'] . '">' . $rows['unique_code'] . '</option>';
        }
        ?>
            </select>
          </div>
      
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="commision_send">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  function getCustomerDetails() {
    var selectedUniqueCode = document.getElementById("selectOption").value;

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_customer_details.php?unique_code=" + selectedUniqueCode, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        // Parse the JSON response
        var response = JSON.parse(xhr.responseText);

        // Update the input fields with the customer details
        document.getElementById("name").value = response.agent_account_number;
        document.getElementById("email").value = response.commision;
        document.getElementById("subject").value = response.unique_code;
      }
    };
    xhr.send();
  }

  document.getElementById("selectOption").addEventListener("change", getCustomerDetails);
</script>

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