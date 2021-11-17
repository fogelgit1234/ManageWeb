<?php require_once "core/load.php"?>



<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: black;
        }

        * {
            box-sizing: border-box;
        }

        /* Add padding to containers */
        .container {
            padding: 16px;
            background-color: white;
        }

        /* Full-width input fields */
        input[type=text], input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        /* Set a style for the submit button */
        .registerbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .registerbtn:hover {
            opacity: 1;
        }

        /* Add a blue text color to links */
        a {
            color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
            background-color: #f1f1f1;
            text-align: center;
        }
    </style>
</head>
<title>מערכת לניהול שעות</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<?php
$result='';
$result1='';
$result2='';
if(isset($_POST['submit'])){
 
    $check = checkEmail($conn,$_POST['email']);
    if($check==0){
        $result='<div style="text-align: center" class="alert alert-danger">שם משתמש זה כבר בשימוש</div>';
    }
    $check1 = checkPassword($_POST['psw'],$_POST['psw1']);
    if($check1==1){
        $result1='<div style="text-align: center" class="alert alert-danger">הסיסמא קצרה מידי</div>';
    }
    if($check1==2) {
        $result2 = '<div style="text-align: center" class="alert alert-danger">הסיסמא לא תואמת</div>';
    }
    if($check==1&&$check1==3){
        insertUser($conn,$_POST['email'],$_POST['psw'],$_POST['psw1']);
        $username = selectUser($conn,$_POST['email'],$_POST['psw']);
        $_SESSION['id'] = $username[0];
        $_SESSION['username'] = $username[1];
        echo "<script>window.location.href='index.php';</script>";
    }

}
?>
<p> <?php echo $result;?></p>
<p> <?php echo $result1;?></p>
<p> <?php echo $result2;?></p>

<form action="" method="POST">
    <div class="container" style="text-align: right;">
        <h1>הרשמה</h1>
        <p>אנה מלא את הפרטים כדאי לפתוח משתמש</p>
        <hr>

        <label for="email"><b>שם משתמש</b></label>
        <input type="text" style="text-align: right" maxlength="10" minlength="4" placeholder="בחר שם משתמש" name="email" id="email" required>

        <label for="psw"><b> סיסמא</b></label>
        <input type="password" style="text-align: right" placeholder="בחר סיסמא" name="psw" id="psw" required>

        <label for="psw-repeat"><b>חזור על הסיסמא</b></label>
        <input type="password"  style="text-align: right" placeholder="אימות סיסמא" name="psw1" id="psw-repeat" required>
        <hr>

        <button type="submit" name="submit" class="registerbtn">הרשמה</button>
    </div>

    <div class="container signin" style="direction: rtl">
        <p>יש לך כבר משתמש? <a href="login.php">התחבר!</a></p>
    </div>
</form>