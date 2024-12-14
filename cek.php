<?php
//untuk orang yang belum login , jika belum login

if(isset($_SESSION['log'])){

}else{
    header('location:login.php');
}

?>
