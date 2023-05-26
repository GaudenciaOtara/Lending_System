<?php
session_start();
include './Functions/connect.php';
 if (isset($_POST['submit'])){
	$user_query = mysqli_query($conn,"select * from lender_reg where email='{$_POST["email"]}' and password='{$_POST["password"]}'");
	$user_data = mysqli_fetch_assoc($user_query);
  
	if(empty($user_data)){
	  echo "user not found";
	}else{
	  $_SESSION["user"] = $user_data['email'];
	  echo("
		<script>
		  window.location.replace('./Lender_Dashboard/index.php');
		</script>
	  ");
	}
  
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lender Login</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <div class="form">
    <p>Create Account</p>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
     <input type="text" placeholder="Email Address" name="email" required><br>
     <input type="password" placeholder="Password" name="password" required><br>
     <select name="signupas" onchange="location=this.value;">
     <option value="Lender">LENDER</option>
     <option value="agentlogin.php">AGENT</option>
     <option value="customerlogin.php">CUSTOMER</option>
      </select><br>
      <button name="submit" class="button">SUBMIT</button>
     <a href="#"> <h5 class="forgotpassword">Forgot password? <a href="signup.php" class="login">Signup</a></h5></a> 
    </form>
    </div>
</body>
</html>