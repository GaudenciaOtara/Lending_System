<?php
function check_session(){


if (!isset($_SESSION['user'])) {
    
    echo
    "<script>
        alert('You are not logged in! ');
        window.location.replace('../login.php');                
    </script>";
    
}
 

}
?>