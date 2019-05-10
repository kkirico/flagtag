<!doctype html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/routine.css">
  </head>
  <body>
    <h1>Select Routine</h1>
    <a href="?menu=chooseRoutine">추천 루틴 보러가기</a>
    <form action="/model/send_routine.php" method="post">
      <select name="choosed_routine">
        <option value="JimWendler">JimWendler</option>
        <option value="StartingStrength">StartingStrength</option>
        <option value="MadCow">MadCow</option>
        <option value="StrongLifting">StrongLifting</option>
      </select>
      <input type="submit" name="확인" value="루틴시작"></input>
    <table class = "table table-striped"><tbody>

        <?php

        include "./model/dbConnect.php";
        include "./model/roundoff.php";
        include_once "./model/constructRoutine.php";
        date_default_timezone_set('Asia/Seoul');

        //user 정보를 가져오는 부분
        $SendUserRoutineSql = "SELECT user_routine, user_routine_startday,1RM_squat,1RM_benchpress,1RM_deadlift
                              FROM user
                              WHERE user_id='$_SESSION[user_id]'";
        $routineSqlResult = mysqli_query($flagtagdb,$SendUserRoutineSql);
        $user_information = mysqli_fetch_array($routineSqlResult);
        if($routineSqlResult===false){
          echo "user 루틴 이름을 가져오는 과정에서 문제가 생겼습니다.<br>";
          echo mysqli_error($flagtagdb)."<br><br>";
        }



        //루틴을 db에서 가져오는 함수
        $userRoutine = getRoutine($user_information['user_routine']);

        $userRoutine->getRoutineStartDay($user_information['user_routine_startday']);
        $userRoutine->calculateTodayIsNthDay();
/*
        echo '<pre>';
        var_dump($userRoutine);
        echo '</pre>';
*/
        //루틴 날짜 길이만큼
        for($day=0;$day<$userRoutine->howLongisRoutine;$day++){
          $rr = $day+1;
          echo "<tr><td id='day'>"."day".$rr."</td></tr>";

          if($userRoutine->NthDayRoutine[$day]->isBreak=="true"){

            echo "<tr><td>break</td></tr>";
            continue;
          }
          //운동 종류 수 만큼
          for($types=0; $types<count($userRoutine->NthDayRoutine[$day]->setsOftheType); $types++){



            echo "<tr><td>".$userRoutine->NthDayRoutine[$day]->setsOftheType[$types][1]->type."</td></tr>";
            echo "<tr><td><table class='oneType'>";

            for($i=0;$i<3;$i++){
              echo '<tr>';
              for($sets=0;$sets<count($userRoutine->NthDayRoutine[$day]->setsOftheType[$types]);$sets++){
                echo '<td>';
                if($i==0){
                  echo $userRoutine->NthDayRoutine[$day]->setsOftheType[$types][$sets]->setNum."세트";
                }else if($i==1){
                  $thisType = $userRoutine->NthDayRoutine[$day]->setsOftheType[$types][$sets]->type;
                  $thisWeight = $userRoutine->NthDayRoutine[$day]->setsOftheType[$types][$sets]->weight;
                  //weight가 0이 아닐 때만 출력
                  if($thisWeight!=0){
                    final_weight($thisType,$thisWeight);
                     echo "kg  ";
                  }

                }else if($i==2){
                  echo $userRoutine->NthDayRoutine[$day]->setsOftheType[$types][$sets]->rep."반복";
                }

                echo '</td>';
              }
              echo '</tr>';
            }



            echo "</tbody></table></td></tr>";
          }

        }


          ?>




    </table>

  </body>
</html>
