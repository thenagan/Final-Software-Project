<?php
	include('Session.php');
?>
<!DOCTYPE html>
<html>
<head>
 <meta content='text/html; charset=UTF-8' http-equiv='Content-Type'/>
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<h1 align='center'>Hello Student <?php echo $loggedin_session; ?>,</h1>
<h5 align='center'>You are now logged in. you can logout by clicking on signout link given below.</h5>
<div id="contentbox">
<?php
$sql="SELECT * FROM tbluser where id=$loggedin_id";
$result=mysqli_query($con,$sql);
?>
<?php
while($rows=mysqli_fetch_array($result)){
?>
<div id="signup">
<div id="signup-st">
<form action="" method="POST" id="signin" id="reg">
<div id="reg-head" class="headrg">Your Profile</div>
<table border="0" align="center" cellpadding="2" cellspacing="0">
<tr id="lg-1">
<td class="tl-1"> <div align="left" id="tb-name">Reg id:</div> </td>
<td class="tl-4"><?php echo $rows['id']; ?></td>
</tr>
<tr id="lg-1">
<td class="tl-1"><div align="left" id="tb-name">Email:</div></td>
<td class="tl-4"><?php echo $rows['email']; ?></td>
</tr>
</table>
</form>
</div>
</div>
<div id="login">
<div id="login-sg">
<div id="st"><a href="profile2.php" id="st-btn">Go to profile</a></div>
<div id="st"><a href="courses15.php" id="st-btn">Register for classes</a></div>
<div id="st"><a href="logout.php" id="st-btn">Sign Out</a></div>
</div>
</div>
<?php 
//close while loop 
}
?>
</div>
</div>
</div>
</br>
</body>
</html>