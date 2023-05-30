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
$acc_no=$user_data['account_number'];
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

  if (isset($_POST['return'])){
    $unique_code=$_POST['unique_code'];
    $lender_id=$_POST['lender_id'];
    $agent_acc_no=$_POST['agent_account_number'];
    $amount_sent = $_POST['total_amount'];
    $commision = $_POST['expected_commision'];
    // $ID = $_POST['customer_id'];

    $statement= $conn->prepare("INSERT into agent_returns (unique_code,lender_id,agent_account_number,total_amount,expected_commision) VALUES (?,?,?,?,?)");
    $statement->bind_param("siidd",$unique_code,$lender_id,$agent_acc_no,$amount_sent,$commision);
    $statement->execute();
    $statement->close();
    header("Location: ./lendermoney.php");
    exit();
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
<div class="sendtolender">
<button class="allocate-btn" data-toggle="modal" data-target="#sendModal">SEND</button>

</div>
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
      <!-- <td>Send to Lender</td> -->
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
    
      </tr>

      <!-- Send Bootstrap Modal -->
      <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="sendModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sendModalLabel">Send to Lender</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <div class="form-group">
            <label for="input1">Unique Code</label>
            <input type="text" class="form-control" id="input1" placeholder="Enter value" name="unique_code">
          </div>
          <div class="form-group">
            <label for="input2">Lender ID</label>
            <input type="text" class="form-control" id="input2" placeholder="Enter value" name="lender_id">
          </div>
          <div class="form-group">
            <label for="input3">Agent Account Number</label>
            <input type="text" class="form-control" id="input3" placeholder="Enter value" name="agent_account_number">
          </div>
          <div class="form-group">
            <label for="input4">Total Amount Sent</label>
            <input type="text" class="form-control" id="input4" placeholder="Enter value" name="total_amount">
          </div>
          <div class="form-group">
            <label for="input5">Expected Commission</label>
            <input type="text" class="form-control" id="input5" placeholder="Enter value" name="expected_commision">
          </div>
          <div class="form-group">
            <label for="select">Dropdown Select</label>
            <select class="form-control" id="select" onchange="fetchData(this.value)">
    <option value="">Select Transaction Code</option> 
        <?php
        $state = $conn->prepare("SELECT * FROM lender_transactions where agent_account_number='$acc_no' ");
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
        <button type="submit" class="btn btn-primary" name="return">Send</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Updating Javascript -->
<script>
  function fetchData(selectedValue) {
    $.ajax({
      url: 'fetch_data.php',
      method: 'POST',
      data: { selectedValue: selectedValue },
      success: function(response) {
        document.getElementById('input1').value = response.uniqueCode;
        document.getElementById('input2').value = response.lenderID;
        document.getElementById('input3').value = response.agentAccountNumber;
        document.getElementById('input4').value = response.totalAmountSent;
        document.getElementById('input5').value = calculateExpectedCommission(response.totalAmountSent);
      },
      error: function() {
        // Handle errors if any
      }
    });
  }

  function calculateExpectedCommission(totalAmount) {
    // Calculate 3% of the total amount
    var commission = totalAmount * 0.03;
    return commission.toFixed(2); // Round to 2 decimal places if needed
  }
</script>
<!-- End of Modal Updating Javascript -->

      <!-- End of Send Modal -->

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