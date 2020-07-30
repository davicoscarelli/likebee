<?php
$conn = mysqli_connect("localhost", "likebee", "", "likebee");
session_start();  
$user_check = $_SESSION['login_user']; 
$query_login = "SELECT username from login where username = '$user_check'"; 
$sql_login = mysqli_query($conn, $query_login); 
$login_row = mysqli_fetch_assoc($sql_login); 
$login_session = $login_row['username'];

$nothing = False;
$query_markers = "SELECT * from markers";
$sql_markers = mysqli_query($conn, $query_markers);
$name = array();
$m=0;
while ($markers_rows = mysqli_fetch_assoc($sql_markers)){
  if ($markers_rows['username'] == $login_session){
	$name[$m] = $markers_rows['name'];
	$Id_marker[$m] = $markers_rows['id'];
	$m=$m+1;
	}
  else{
  	$nothing = True;
  }

}

?>