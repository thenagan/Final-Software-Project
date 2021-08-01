<!DOCTYPE html>
<html>
<head>
 <meta content='text/html; charset=UTF-8' http-equiv='Content-Type'/>
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "db.php";
 
// Define variables and initialize with empty values
$email = $password = $firstname = $lastname = "";
$email_err = $password_err = $firstname_err = $lastname_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
	
	// Check if first name is empty
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter First Name";
    } else{
        $firstname = trim($_POST["firstname"]);
    }
	
	// Check if password is empty
    if(empty(trim($_POST["lastname"]))){
        $password_err = "Please enter your Last Name.";
    } else{
        $lastname = trim($_POST["lastname"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
	

    
    // Validate credentials
    if(empty($username_err) && empty($password_err) && empty($firstname_err) && empty($lastname_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, firstname, lastname, password FROM tbluser WHERE email = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_firstname, $param_lastname);
            
            // Set parameters
            $param_email = $email;
			$param_firstname = $firstname;
			$param_lastname = $lastname;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $firstname, $lastname, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
							$_SESSION["firstname"] = $firstname;
							$_SESSION["lastname"] = $lastname;
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
			

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
	
	// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate first name
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a first name.";
    }  
	else{
        // Prepare a select statement
        $sql = "SELECT id FROM tbluser WHERE firstname = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_firstname);
            
            // Set parameters
            $param_firstname = trim($_POST["firstname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
			
			// Close statement
            mysqli_stmt_close($stmt);
		}
	}
			
			// Prepare a select statement
        $sql = "SELECT id FROM tbluser WHERE firstname = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_lastname);
            
            // Set parameters
            $param_lastname = trim($_POST["lastname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
	// Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) > 0){
        $password_err = "Password must have atleast 1 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO tbluser (email, firstname, lastname, password) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_email, $param_firstname, $param_lastname, $param_password);
            
            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
			$param_firstname = $firstname;
			$param_lastname = $lastname;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
    
    // Close connection
    mysqli_close($con);
}
?>
</div>
<form name="reg" action="execute.php" onsubmit="return validateForm()" method="post" id="reg">
<table border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
<td class="t-1"><div align="left" id="tb-name">Email:</div></td>
<td><input type="email" id="tb-box" name="email" /></td>
</tr>
<tr>
<td class="t-1"><div align="left" id="tb-name">Password:</div></td>
<td><input id="tb-box" type="password" name="password" /></td>
</tr>
<tr>
<td class="tl-1"><div align="left" id="tb-name">First name:</div></td>
<td><input id="tb-box" type="firstname" name="firstname" /></td>
</tr>
<td class="tl-1"><div align="left" id="tb-name">Last name:</div></td>
<td><input id="tb-box" type="lastname" name="lastname" /></td>
</tr>
</table>
<div id="st"><input name="submit" type="submit" value="Submit" id="st-btn"/></div>
</form>
</div>
</div>
</div>
</div>
</div>
</body>
</html>