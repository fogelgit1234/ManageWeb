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

  
        .container {
            padding: 16px;
            background-color: white;
        }

     
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

     
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

      
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


        a {
            color: dodgerblue;
        }

     {
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
<body>
<?php

$header='';
if(isset($_SESSION['id'])) {
   $id = 
    $username= $_SESSION['username'];
    $header.="<nav class='navbar navbar-default'>
    <div class='container-fluid' >
        <div class='navbar-header' >
            <a class='navbar-brand' href = '#' > Fogel Time Management System </a >
        </div >
        <ul class='nav navbar-nav' >
            <li class='active' ><a href = '' >ברוך הבא  <span style='color:green'>$username</span></a ></li >
            <li ><a href = 'logout.php' > התנתק</a ></li>
        </ul >
    </div >
</nav >";
}
else{
    echo "<script>window.location.href='register.php';</script>";
    exit;
}

$result='';
$y=0;
if(isset($_POST['submit'])){
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $start = $_POST['start'];
    $finish = $_POST['finish'];
    $id = $_SESSION['id'];
    if(strlen($class)<=0||strlen($subject)<=0){
        $y=4;
    }
    $x = checkTimes($conn,$date,$start,$finish,$id);
    if($x==1&&$y!=4){
        $p = checkAgain($date,$start,$finish);
        if($p==1){
            $result='<div class="alert alert-danger"> זמן התחלה לא יכל להיות גדל מזמן הסיום</div>';
        }
        else {
            insert_class($conn, $id, $class, $subject, $date, $start, $finish);
            $result = '<div class="alert alert-success">הפרטים עודכנו בהצלחה</div>';
        }

    }
    else{
        if($y==4)
        {
            $result='<div class="alert alert-danger"> לא מילאת את כל הפרטים</div>';
        }
        else {
            $result = '<div class="alert alert-danger"> הזמנים האלה שלך תפוסים כבר</div>';
        }

    }



}
if (isset($_POST['delete'])){
    delete_class($conn,$_POST['id']);
}
?>
<?php echo $header; ?>
<div class="container">
    <center>
        <h3>מערכת לניהול שעות</h3>
        <p> <?php echo $result;?></p>
    </center>
</div>
<center>
    <div class="container">
       

        <table class="table">
            <thead class="success">
            <tr>
                <th>שעת סיום</th>
                <th>שעת התחלה</th>
                <th>יום</th>
                <th>תלמיד/כיתה</th>

            </tr>
            </thead>
            <tbody>
            <?php echo teachingtimes($conn,$_SESSION['id']);?>
            </tbody>
        </table>
        
   

    


    <div>
        <h3>יצרת משימה</h3>
    </div>
    <form action='' method='POST'>


        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4" style="background-color:lavender;">
                   
                       <h3>שעת התחלה</h3>
                    <input type="time" id="start" name="start" style="margin: 10px">
                </div>
                <div class="col-sm-4" style="background-color:lavenderblush;">
                  <h3>שעת סיום</h3>
                    <input type="time" id="finish" name="finish" style="margin: 10px">
                </div>
                <div class="col-sm-4" style="background-color:lavender;">
                    <h3>יום</h3>
                    <input type="date" id="date" name="date" style="margin: 10px">
                </div>
            </div>
        </div>
        <center>
        <div class="container-fluid">
            <div class="row" style="margin-bottom: 30px">
                <div class="col-sm-12">
                    <div class="form-group" >
                        <label for="exampleFormControlTextarea1" style="font-size: 20px;border-radius: 30%;width: 50%">שם המשימה</label>
                        <textarea style="border: 1px solid black;background: -moz-cellhighlight;text-align: right" name="class"  class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
                    </div>
                </div>

        </div>
        </div>
        </center>
        <div class="container-fluid">
            <div class="row" style="margin-bottom: 30px">
                <div class="col-sm-12">
                    <div class="form-group" >
                        <label for="exampleFormControlTextarea1" style="font-size: 20px;border: 1px solid black;padding: 10px;border-radius: 30%">תוכן המשימה</label>
                        <textarea background: -moz-cellhighlight; style='text-align: right' name="subject" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </div>

            </div>
        
        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                    <input style="width:100%" name="submit" class="btn btn-primary" value="עדכן" type="submit" >
                </div>
            
        
    </form>
</center>
<footer style="  background-color: #fceec7;
  height:50px;border: 1px solid red;margin-top: 25px">
    <center>
<br>
© Copyright Daniel Fogel 2021
    </center>
</footer>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

</script>
</body>
</html>
