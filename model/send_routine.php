<?php
    session_start();
    include "dbConnect.php";
    $thisyear = date('Y'); // 4자리 연도
    $thismonth = date('n'); // 0을 포함하지 않는 월
    $today = date('j'); // 0을 포함하지 않는 일
    $routine=$_POST['choosed_routine'];
    $combine = $thisyear.'-'.$thismonth.'-'.$today;
    echo $combine."<br>".$routine."<br>".$_SESSION['user_id']."<br>";
    $SendRoutineSql = "
      UPDATE user
      SET user_routine = '$routine',
          user_routine_startday = '$combine'
      WHERE user_id = '$_SESSION[user_id]'";

      $joinSqlResult = mysqli_query($flagtagdb,$SendRoutineSql);

      if($joinSqlResult === false){
        echo '<meta charset="utf-8">
        저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
        echo mysqli_error($flagtagdb);
      } else {
        echo '<meta charset="utf-8"> 성공했습니다. <a href="../index.php">돌아가기</a>';
        echo '<br><br>'.$thisyear.$thismonth.$today;

      }



?>
