<?php
session_start();
include '../Functions/connect.php';
include '../Functions/agentchecksession.php';
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


if (isset($_POST['send'])){
    $customer_number=$_POST['customer_number'];
    $amount_lent = $_POST['amount_lent'];
    $unique_code = $_POST['unique_code'];
    $expected_interest=$_POST['expected_interest'];
    $agent_id=$_POST['agent_id'];
    $total_amount=$_POST['total_amount'];
    $amount=$_POST['amount'];
    if ($amount_lent > $amount) {
      echo"
      <script>
      alert('Insufficient Balance to make this transaction');
      </script>
      ";}
 
    // $updated_balance=$user_trans['lent_amount']
   
else{ 
  $updated_balance=$amount-$amount_lent;
  $interest=$amount_lent*0.12;
  echo $interest;

  // $stm= UPDATE `lender_transactions` SET lent_amount`='[value-4]' WHERE 1;
  $updateQuery = "UPDATE lender_transactions SET lent_amount = $updated_balance WHERE unique_code = '$unique_code'";
  mysqli_query($conn, $updateQuery);

    $time = date('H:i:s');
    $statement= $conn->prepare("INSERT into customer_money (customer_number,amount_lent,unique_code,expected_interest,total_amount,agent_id,time_allocated) VALUES (?,?,?,?,?,?,?)");
    $statement->bind_param("idsddis",$customer_number,$amount_lent,$unique_code,$expected_interest,$total_amount,$agent_id,$time);
    $statement->execute();
    $statement->close();
    $state= $conn->prepare("INSERT into updated_values (agent_id,updated_balance,unique_code,expected_interest,total_amount) VALUES (?,?,?,?,?)");
    $state->bind_param("idsdi",$agent_id,$updated_balance,$unique_code,$expected_interest,$total_amount);
    $state->execute();
    $state->close();
    $conn->close();
    header("Location: ./lendermoney.php");
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/index.css">
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

 <div class="table">

 <table>
  <thead class="head">
    <tr>
      <td>ID</td>
      <td>Money Allocated</td>
      <td>Time Allocated</td>
      <td>Unique Code</td>
      <!-- <td>Profit Generated</td> -->
      <td>Allocate</td>
      <td>Send to Lender</td>
    </tr>
  </thead>
  <tbody>
    <?php
    $id_count = 0;
    $account_no=$user_data['account_number'];
    $stmt = $conn->prepare("SELECT * from lender_transactions where agent_account_number='$account_no'");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
      
      ?>
      <tr>
        <td><?php echo $id_count; ?></td>
        <td><?php echo $row['lent_amount']; ?></td>
        <td><?php echo $row['time_allocated']; ?></td>
        <td><?php echo $row['unique_code']; ?></td>
        <!-- <td>12344</td> -->
        <td>
          <button class="allocate-btn" data-toggle="modal" data-target="#allocationModal-<?php echo $row['unique_code']; ?>" data-row-id="<?php echo $id_count; ?>">ALLOCATE</button>
        </td>
        <td><button>SEND</button></td>
      </tr>

      <!-- Bootstrap Modal -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="allocationForm">
        <div class="modal fade" id="allocationModal-<?php echo $row['unique_code']; ?>" tabindex="-1" role="dialog" aria-labelledby="allocationModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="allocationModalLabel-<?php echo $row['unique_code']; ?>">Allocate Funds</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="customerNumber">Customer Number</label>
                  <input type="text" class="form-control" id="customerNumber" name="customer_number" required>
                </div>
                <div class="form-group">
                  <label for="amountToLend">Amount to Lend</label>
                  <input type="number" class="form-control amount-input" id="amountToLend" name="amount_lent" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                  <label for="amountToLend">Unique Code</label>
                  <input type="text" class="form-control" value="<?php echo $row['unique_code']; ?>" name="unique_code" readonly>
                </div>
                <div class="form-group">
                  <label for="expectedInterest">Expected Interest</label>
                  <input type="number" class="form-control expected-interest" id="expectedInterest" name="expected_interest" min="0" step="0.01" readonly>
                </div>

                <div class="form-group">
                  <label for="totalAmountReturned">Total Amount Returned</label>
                  <input type="number" class="form-control total-amount" id="totalAmountReturned" name="total_amount" readonly>
                </div>
                <input type="hidden" class="form-control" value="<?php echo $user_data['id']; ?>" name="agent_id" readonly>
                <input type="hidden" class="form-control" value="<?php echo $row['lent_amount']; ?>" name="amount" readonly>
              </div>
              <div class="modal-footer">
                <button type="submit" name="send">Allocate</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      <?php
      $id_count = $id_count + 1;
    } ?>
  </tbody>
</table>

<script>
  // Get all amount input fields
  var amountInputs = document.querySelectorAll('.amount-input');

  // Attach event listeners to each input field
  amountInputs.forEach(function(input) {
    input.addEventListener('input', function() {
      var amount = parseFloat(this.value);
      var expectedInterest = amount * 0.12;
      var totalAmount = amount + expectedInterest;

      // Update the corresponding fields in the current row
      var modal = this.closest('.modal');
      modal.querySelector('.expected-interest').value = expectedInterest.toFixed(2);
      modal.querySelector('.total-amount').value = totalAmount.toFixed(2);
    });
  });
</script>





 </div>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- <script src="./row_elements.js"></script> -->

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