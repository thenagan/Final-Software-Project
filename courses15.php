<?php
//List of classes
include ('db.php');
include ('session.php');
?>
<?php
$query = "SELECT * FROM courses";
$results = mysqli_query($con, $query);
$rows = mysqli_num_rows($result);
$cols = mysqli_num_fields($result);
for( $i = 0; $i<$rows; $i++ ) {
   for( $j = 0; $j<$cols; $j++ ) {
     echo mysqli_result($result, $i, $j)."<br>";
   }
}
?>