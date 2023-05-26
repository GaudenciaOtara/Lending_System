<?php
// $username=$_POST[''];
include './Functions/connect.php';
if (isset($_POST['submit'])){

$username=$_POST['username'];
$email=$_POST['email'];
$phone=$_POST['phonenumber'];
$id=$_POST['ID_Number'];
$password=$_POST['password'];
$confirmpassword=$_POST['confirmpassword'];
$check_query = "SELECT * FROM lender_reg WHERE email='$email' OR phonenumber='$phone' OR ID_Number='$id'";
$check_result = mysqli_query($conn, $check_query);
if (mysqli_num_rows($check_result) > 0) {
   if ($row = mysqli_fetch_assoc($check_result)) {
    if ($row['email'] == $email) {
      echo "<p style='color:red;'>Email already exists</p>";
    }
    if ($row['phonenumber'] == $phone) {
      echo "<p style='color:red;'>Phone number already exists</p>";
    }
    if ($row['ID_Number'] == $id) {
      echo "<p style='color:red;'>ID Number already exists</p>";
    }
  }
}
else{
$statement= $conn->prepare("INSERT into lender_reg (username,email,phonenumber,ID_Number,password,confirmpassword) VALUES (?,?,?,?,?,?)");
$statement->bind_param("ssiiss",$username,$email,$phone,$id,$password,$confirmpassword);
$statement->execute();
echo "<p style='color:green;'>Successfully Registered!</p>";
$statement->close();
$conn->close();
echo "
  <script>
    location.replace('login.php');
  </script>
";

}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lender Signup</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <div class="form">
    <p>Create Account</p>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
     <input type="text" placeholder="Username" name="username" required><br>
     <input type="text" placeholder="Email Address" name="email" required><br>
     <input type="tel" placeholder="Phone No" name="phonenumber" required><br>
     <input type="number" placeholder="ID Number|Passport" name="ID_Number" required><br>
     <input type="password" placeholder="Password" name="password" required><br>
     <input type="password" placeholder="Confirm Password" name="confirmpassword" required><br>
     <select name="signupas" onchange="location=this.value;">
     <option value="Lender">LENDER</option>
     <option value="agentsignup.php">AGENT</option>
     <option value="customersignup.php">CUSTOMER</option>
      </select><br>
      <button name="submit">SUBMIT</button>
     <a href="#"> <h5 class="forgotpassword">Forgot password? <a href="login.php" class="login">Login</a></h5></a> 
    </form>
    </div>
</body>
</html>