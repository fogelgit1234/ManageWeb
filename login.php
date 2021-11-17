<?php require_once "core/load.php" ?>
<?php 
$result='';
if(isset($_POST['submit'])){
    $check = checkUser($conn,$_POST['uname'],$_POST['psw']);
    if($check==1){
        $username = selectUser($conn,$_POST['uname'],$_POST['psw']);
        $_SESSION['id']=$username[0];
        $_SESSION['username']=$username[1];
        echo "<script> location.replace('index.php'); </script>";
    }
    else{
            $result = '<div style="text-align: center" class="alert alert-danger">שם המשתמש או הסיסמא לא נכונים</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>

body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}


@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>
<center>
<h2>תופס התחברות</h2>
<?php echo $result?>
<form action="" method="POST">
 
  

  <div class="container" style='text-align:right;'>
    <label for="uname"><b>שם משתמש</b></label>
    <input  style='text-align:right;' type="text" placeholder="הכנס שם משתמש" name="uname">

    <label for="psw"><b>סיסמא</b></label>
    <input style='text-align:right;' type="password" placeholder="הכנס סיסמא" name="psw" >
        
    <button name='submit' type="submit">התחבר</button>
        <div class="container signin" style="direction: rtl">
        <p>אין לך משתמש? <a href="register.php">הרשם עכשיו!</a></p>
</form>
</center>
</body>
</html>

