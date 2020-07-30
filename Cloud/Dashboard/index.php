
<?php
include('login.php'); 
if(isset($_SESSION['login_user'])){
header("location: profile.php"); 
}
?> 
<!DOCTYPE html>
<html>
<head>
  <title>LikeBee - Login</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
 <div id="login">
  <h2>LikeBee - Dashboard</h2>
  <form action="" method="post">
   <label>username :</label>
   <input id="name" name="username" placeholder="username" type="text">
   <label>password :</label>
   <input id="password" name="password" placeholder="**********" type="password"><br><br>
   <input name="submit" type="submit" value=" Login ">
   <span><?php echo $error; ?></span>
  </form>
 </div>
</body>
</html>