<?php

function insert_class($conn,$id,$class,$subject,$date,$start,$finish){

    $stmt = $conn->prepare("INSERT INTO manage(user_id,class_name,subject,day,begint,endt)VALUES('$id','$class','$subject','$date','$start','$finish')");
    $stmt->execute();

}
function teachingtimes($conn,$user_id)
{
    $sql = "SELECT * FROM manage where user_id = '$user_id' ORDER by day desc,endt desc ";
    $details = $conn->query($sql);
    $result1='';
    while ($row = $details->fetch_assoc()){
            $result1 = $result1."<form  style='margin:30px;border:1px solid black;' action='' method='POST'> <div class='container-fluid'><div class='row' style='border:1px solid lightblue'>
    <div class='col-sm-2' style='background-color:#FF7043;opacity:0.8;padding:10px'
    <h4>שעת הסיום</h4>
    $row[endt]
    
    </div>
    <div class='col-sm-2' style='background-color:#FFEE58;opacity:0.8;padding:10px;margin-top:10px;'>
        <span>שעת התחלה</span>
    $row[begint]</div>
    <div class='col-sm-2'  style='background-color:#66BB6A;opacity:0.8;padding:10px;margin-top:10px;'>
    <span>יום</span>
    $row[day]
    </div>
    <div class='col-sm-2' style='background-color:#78909C;opacity:0.8;padding:10px;margin-top:10px;'>
    <span>שם המשימה<span>
    $row[class_name]
    </div>
    <div class='col-sm-2' style='background-color:#E1F5FE;padding:10px;margin-top:10px;'>  <button class='btn btn-primary' type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#$row[id]'>צפה במשימה</button>

        <!-- Modal -->
  <div class='modal fade' id='$row[id]' role='dialog'>
    <div class='modal-dialog'>
    
      <!-- Modal content-->
      <div class='modal-content'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title' style='text-align: center'>תוכן המשימה שלך</h4>
        </div>
        <div class='modal-body'>
          <p style='text-align: right;'>$row[subject]</p>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' data-dismiss='modal'>סגור</button>
        </div>
      </div>
      
    </div>
  
</div>
 <input type='hidden' name='id' value=" . $row['id'] . " >
    <div class='col-sm-2' style='background-color:#E1F5FE;padding:10px;margin-top:10px;'><button   type='submit' name='delete' class='btn btn-danger'>מחק משימה</button></div>

    </div></form>";

        }

        return $result1;

}
function checkTimes($conn,$date,$start,$finish,$id){

    $stmt = $conn->prepare("SELECT day FROM manage WHERE day = '$date' AND user_id='$id'");
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows>0){
        $sql = "SELECT begint,endt FROM manage WHERE day = '$date' AND user_id='$id' ";
        $details = $conn->query($sql);
        $start1 = $date;
        $end1= $date;
        $finish.= $date;
        $start.=$date;
        $start=strtotime($start);
        $end=strtotime($finish);
        while($row = $details->fetch_assoc()){
            $start1.=$row['begint'];
            $end1.=$row['endt'];
            $start1=strtotime($start1);
            $end1=strtotime($end1);

            if($start>=$start1&&$start<=$end1 || $end>=$start1&&$end<=$end1){
                return 0;

            }
            if($start<= $start1 && $end>=$start1&&$end<=$end1){
                return 0;
            }
            if($start>=$start1 && $start<=$end1 && $end>=$end1)
            {
                return 0;
            }
            $start1 = $date;
            $end1= $date;


        }
        return 1;
    } else{
        return 1;
    }

}

function delete_class($conn,$id){
    $stmt = $conn->prepare("DELETE FROM manage WHERE id = $id");
    $stmt->execute();

}

function checkEmail($conn,$email){
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = '$email'");
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows>0){
        return 0;
    }
    else{
        return 1;
    }
}
function checkPassword($psw,$psw1){
    if(strlen($psw)<=5 ||strlen($psw1)<=5){
        return 1;
    }
    if($psw != $psw1){
        return 2;
    }
    return 3;

}
function insertUser($conn,$email,$psw,$psw1){
    $stmt = $conn->prepare("INSERT INTO users(username,pass1,pass2)VALUES('$email','$psw','$psw1')");
    $stmt->execute();
    
}
function selectUser($conn,$username,$pw1){
    $stmt = $conn->prepare("SELECT id,username FROM users WHERE username = '$username' AND pass1 = '$pw1'");
    $stmt->execute();
    $result1 = $stmt->get_result();
    while ($row = $result1->fetch_assoc()){
        $id = $row['id'];
        $username=$row['username'];
    }
      return array($id, $username);
    }

function checkUser($conn,$username,$password){
    $stmt = $conn->prepare("SELECT id,username FROM users WHERE username = '$username' AND pass1 = '$password'");
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows>0){
        return 1;
    }
    else{
        return 0;
    }

}
function checkAgain($date,$start,$finish){
    $finish.= $date;
    $start.=$date;
    $start=strtotime($start);
    $end=strtotime($finish);
    if($start>$end){
        return 1;
    }

}
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}