/ Iterate over the fetched rows and sum the lent_amount
while ($row = mysqli_fetch_assoc($agent_transactions)) {
    $sumLentAmount += $row['amount_lent'];
    $expectedInterest+=$row['expected_interest'];
    $totalamount+=$row['total_amount'];

}

$dbHost = 'localhost';
$dbName = 'lending_system';
$dbUser = 'root';
$dbPass = '1234';

try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch unique codes and amounts from the database
    $query = $db->query("SELECT unique_code FROM customer_money where customer_number='$phoneNumber'");

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
     $code = $row['unique_code'];
      //$amount = $row['customer_number'];
      echo "<option value=\"$code\">$code</option>";
    }
  } catch(PDOException $e) {
    echo "Database  failed: " . $e->getMessage();
  }

  
 
?>

// <select name="unique_code" id="unique_code_dropdown">

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
 $code = $row['unique_code_dropdown'];
  //$amount = $row['customer_number'];
  echo "<option value=\"$code\">$code</option>";

}