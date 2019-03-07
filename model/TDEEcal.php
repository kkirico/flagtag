<?php
  include "dbConnect.php";
  session_start();

  $calculator_height=$_POST['calculator_height'];
  $calculator_weight=$_POST['calculator_weight'];
  $calculator_sex=$_POST['calculator_sex'];
  $calculator_age=$_POST['calculator_age'];
  $calculator_workoutdayperweek=$_POST['calculator_workoutdayperweek'];
  $calculator_goalweight=$_POST['calculator_goalweight'];
  $calculator_goalperiod=$_POST['calculator_goalperiod'];

  if ($calculator_sex==male){
    $BMR=66+(13.8 * $calculator_weight)+(5 * $calculator_height)-(6.8 * $calculator_age);
  }
  else{
    $BMR=655+(9.6 * $calculator_weight)+(1.8 * $calculator_height)-(4.7 * $calculator_age);
  }
  $TDEE= $BMR * $calculator_workoutdayperweek;
  $DIETcalorie_per_day = $TDEE + ($calculator_goalweight - $calculator_weight)*7000/$calculator_goalperiod;

  if(isset($_SESSION)){
    $sql = "UPDATE user
            SET
            BMR = $BMR,
            TDEE = $TDEE,
            goalCaloriePerDay = $DIETcalorie_per_day
            WHERE user_id ='".$_SESSION['user_id']."'";
    $modifySqlResult = mysqli_query($flagtagdb,$sql);
    if($modifySqlResult===false){
      echo "오류<br>";
      echo mysqli_error($flagtagdb);
    }
    echo $_SESSION['user_id'].'님<br>';
  }

  echo '<meta charset="utf-8"> BMR(기초대사량):'.$BMR;
  echo'<br><meta charset="utf-8"> TDEE(하루필요열량):'.$TDEE;
  echo'<br><meta charset="utf-8"> 목표 체중에 따르는 하루 섭취열량:'.$DIETcalorie_per_day;
  echo'<br>mypage에 정보가 추가 되었습니다.';
  echo'<br><br> <a href="../index.php">홈</a>';

?>
