<?php
$con=new mysqli("localhost","root","","expensetrecker");
if(!$con)
{
    die(mysqli_error($con));
}
?>