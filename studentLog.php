<?php
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

        function exportTableToExcel(tableID, filename = 'table_mti') {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            // Specify file name
            filename = filename ? filename + '.xls' : 'excel_data.xls';

            // Create download link element
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                // Setting the file name
                downloadLink.download = filename;

                //triggering the function
                downloadLink.click();
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous">
    </script>
    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/user_log.js"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <section>
            <!--User table-->
            <h1 class="slideInDown animated">Here are the Student daily check-ins </h1>
            <div class="form-style-5 slideInDown animated">

                <!-- <form method="POST" action="Export_Excel.php">
                    <input type="date" name="date_sel" id="date_sel">
                    <button type="button" name="student_log" id="student_log">Select Date</button>

                    <input type="submit" name="To_Excel" value="Export to Excel">

                </form> -->

                <button onclick="exportTableToExcel('tblData')">Export To Excel File</button>


            </div>
            <div class="tbl-header slideInRight animated">
                <?php

                require 'connectDB.php';


                $sql2 = "SELECT id,username FROM users ";
                $sql3 = "SELECT username,checkindate FROM users_logs";
                $result2 = mysqli_query($conn, $sql2);
                $result3 = mysqli_query($conn, $sql3);

                for ($i = 0; $i < $result2->num_rows; $i++) {
                    $row = $result2->fetch_row();
                    $arr1[$i] = $row[1];
                    // print($arr[$i]);
                }
                // get array holds arrays username , checkin date
                $arr2 = $result3->fetch_all();
                // var_dump($arr2[$i][1][0]);
                echo "<table id='tblData'>";
                echo "<tr>";
                echo "<th>User Name</th>";
                echo "<th>Week1</th>";
                echo "<th>Week2</th>";
                echo "<th>Week3</th>";
                echo "<th>Week4</th>";
                echo "<th>Week5</th>";
                echo "<th>Week6</th>";
                echo "</tr>";

                for ($i = 0; $i < count($arr1); $i++) {
                    echo "<tr>";
                    echo "<td>" . $arr1[$i] . "</td>";
                    // echo "</tr>";

                    for ($x = 0; $x < count($arr2); $x++) {

                        if ($arr2[$x][0] == $arr1[$i]) {
                            echo "<td> " . $arr2[$x][1] . "</td>";
                        }
                    }
                }

                echo " </table>";

                ?>

            </div>
            <div class="tbl-content slideInRight animated">
                <div id="studentlog"></div>
            </div>
        </section>
    </main>
</body>

</html>