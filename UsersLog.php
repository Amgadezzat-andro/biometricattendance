<?php
require 'connectDB.php';

$status = session_status();
var_dump($status);
if ($status == PHP_SESSION_NONE) {
  //There is no active session
  session_start();
} else
if ($status == PHP_SESSION_DISABLED) {
  //Sessions are not availablea
} else
if ($status == PHP_SESSION_ACTIVE) {
  //Destroy current and start new one
  session_destroy();
  session_start();
}


// $sql2 = "SELECT id,username FROM users ";
// $sql3 = "SELECT username,checkindate FROM users_logs";
// $result2 = mysqli_query($conn, $sql2);
// $result3 = mysqli_query($conn, $sql3);



// for ($i = 0; $i < $result2->num_rows; $i++) {
//   $row = $result2->fetch_row();
//   $arr1[$i] = $row[1];
//   // print($arr[$i]);
// }


// // get array holds arrays username , checkin date
// $arr2 = $result3->fetch_all();



// // var_dump($arr2[$i][1][0]);


// echo "<table>";
// echo "<tr>";
// echo "<th>User Name</th>";
// echo "<th>Day1</th>";
// echo "<th>Day2</th>";
// echo "<th>Day3</th>";
// echo "<th>Day4</th>";
// echo "<th>Day5</th>";
// echo "<th>Day6</th>";
// echo "</tr>";


// for ($i = 0; $i < count($arr1); $i++) {
//   echo "<tr>";
//   echo "<td>" . $arr1[$i] . "</td>";
//   // echo "</tr>";

//   for ($x = 0; $x < count($arr2); $x++) {

//     if ($arr2[$x][0] == $arr1[$i]) {
      
//       // echo "<tr>";
//       // echo "<td>&nbsp;</td>";
//       echo "<td> " . $arr2[$x][1] . "</td>";
//       // echo "</tr>";
//     }
    
//   }

// }

// echo " </table>";








// var_dump($result2->fetch_row());



// for($i=0; $i < $result2->num_rows;$i++){
//   $row = $result2 -> fetch_row();
//   $arr[$i] = $row[1];
// printf ("%s (%s)\n", $row[0], $row[1]);

// for($x=0; $x < $result3->num_rows; $x++){
//   $row2 = $result3 -> fetch_all();
//   $arr2[$x] = $row2[$x];
// if($arr2[$x] == $arr[$i]){
//     print("Hello");
// }
// }

// while($row2 = $result3->fetch_row()){
//   if($row2[0]==$row[1]){
//   printf ("Hello");
//   }
// }
// printf ("%s (%s)\n", $row[0], $row[1]);
// var_dump($row[0]);

// }




?>
<!DOCTYPE html>
<html>

<head>
  <title>Students Logs</title>
  <link rel="stylesheet" type="text/css" href="css/userslog.css">
  <script>
    $(window).on("load resize ", function() {
      var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
      $('.tbl-header').css({
        'padding-right': scrollWidth
      });
    }).resize();
  </script>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous">
  </script>
  <script src="js/jquery-2.2.3.min.js"></script>
  <script src="js/user_log.js"></script>
  <script>
    $(document).ready(function() {
      $.ajax({
        url: "user_log_up.php",
        type: 'POST',
        data: {
          'select_date': 1,
        }
      });
      setInterval(function() {
        $.ajax({
          url: "user_log_up.php",
          type: 'POST',
          data: {
            'select_date': 0,
          }
        }).done(function(data) {
          $('#userslog').html(data);
        });
      }, 5000);
    });
  </script>
</head>

<body>
  <?php include 'header.php'; ?>
  <main>
    <section>
      <!--User table-->
      <h1 class="slideInDown animated">Here are the Users daily logs</h1>
      <div class="form-style-5 slideInDown animated">
        <form method="POST" action="Export_Excel.php">

          <input type="date" name="date_sel" id="date_sel">
          <button type="button" name="user_log" id="user_log">Select Date</button>
          <input type="submit" name="To_Excel" value="Export to Excel">
          <!-- <input type="submit" name="To_Excel2" value="Export to Excel 2"> -->
        </form>
      </div>
      <div class="tbl-header slideInRight animated">
        <table cellpadding="0" cellspacing="0" border="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Serial Number</th>
              <th>Fingerprint ID</th>
              <th>Date</th>
              <th>Time In</th>
              <th>Time Out</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="tbl-content slideInRight animated">
        <div id="userslog"></div>
      </div>
    </section>
  </main>
</body>

</html>