<?php 
session_start();
include('db.php');
$email=$_POST['email'];
$result = mysqli_query($con,"SELECT * FROM tbluser WHERE email='$email'");
$num_rows = mysqli_num_rows($result);
if ($num_rows) {
 header("location: index.php?remarks=failed"); 
}else {
 $email=$_POST['email'];
 $password=$_POST['password'];
 $firstName=$_POST['firstName'];
 $lastName=$_POST['lastName'];
 if(mysqli_query($con,"INSERT INTO tbluser(email, password, firstName, lastName)VALUES( '$email', '$password', '$firstName', '$lastName')")){ 
 header("location: index.php?remarks=success");
 }else{
  $e=mysqli_error($con);
 header("location: index.php?remarks=error&value=$e");  
 }
}
?>