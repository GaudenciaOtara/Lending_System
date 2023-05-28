<?php
session_start();
include '../Functions/connect.php';
include '../Functions/checksession.php';
check_session();
if (isset($_SESSION['user'])){
    
$var_session=$_SESSION["user"];

$user_query = mysqli_query($conn,"select * from lender_reg where email='$var_session'");
$user_data = mysqli_fetch_assoc($user_query);

if (isset($_POST['search'])) {
     $searchTerm = $_POST['search'];

     $query = "SELECT * FROM agent_reg WHERE username LIKE '$searchTerm%'";

     $result = mysqli_query($conn, $query);

     $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);

   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lender Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/details.css">
</head>
<body>
    <nav>
        <div class="back">
            <a href="./index.php"><img src="../Images/back.png" alt="back" height="31px" width="40px"></a>
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
    <div class="container">
        <h3>Agent Details</h3>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-4">
            <div class="form-group">
                <label for="search">Search:</label>
                <input class="form-control" type="text" name="search" id="search" placeholder="Enter username" value="<?php echo isset($searchTerm) ? $searchTerm : ''; ?>">
            </div>
            <button class="btn btn-outline-primary" type="submit">Search Details</button>
        </form>

        <?php if (isset($row)): ?>
            <form>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" value="<?php echo $row['username']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" value="<?php echo $row['email']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="age">Account Number:</label>
                    <input type="number" class="form-control" id="age" value="<?php echo $row['account_number']; ?>" readonly>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
} else {
    echo "<script>
                location.replace('../login.php');
            </script>";
}
?>
