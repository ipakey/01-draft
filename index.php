<?php
function build_calendar($month, $year)
{
    if (isset($_GET['month'])) {
        $month = $_GET['month'];
        $year = $_GET['year'];
    }

    $mysqli = new mysqli('localhost', 'root', '', 'bookingcalendar');
    $stmt = $mysqli->prepare("SELECT *from bookings where MONTH(date)=? AND YEAR(date)=?");
    $stmt->bind_param('ss', $month, $year);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['date'];
            }
            $stmt->close();
        }
    }

    //First create an array of days of the week
    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thusday', 'Friday', 'Saturday');

    //get the first day of the month
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

    //get number of days in month
    $numberOfDays = date('t', $firstDayOfMonth);

    //get other information about the first day of this month
    $dateComponents = getDate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');


    //create html table

    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center class='table-head'><h2 class=header>$monthName $year</h2></tr><tr><center class='table-head'>";
    $calendar .= "<a class='btn' href='?month=" . date("m", mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date("Y", mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous Month</a>";

    $calendar .= "<a class='btn ' href='?month=" . date("m") . "&year=" . date("Y") . "'>Current Month</a>";

    $calendar .= "<a class='btn ' href='?month=" . date("m", mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date("Y", mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center>";

    $calendar .= "<tr class='header'>";
    //calendar headers
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }
    $calendar .= "</tr>";
    $calendar .= "<tr>";
    //the variable $daysOfWeek will ensure 7 columns in table
    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td></td>";
        }
    }

    //initiate day counter
    $currentDay = 1;
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);


    while ($currentDay <= $numberOfDays) {

        // if 7th coumn reachedthen start a new row
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $dayName = strtolower(date('I', strtotime($date)));
        $eventNum = 0;

        $today = $date == date('Y-m-d') ? "today" : "";
        if ($date < date('Y-m-d')) {
            $calendar .= "<td><button class='btn-na'><h4>$currentDay</h4>N/A</button></td>";
        } elseif (in_array($date, $bookings)) {
            $calendar .= "<td><button class='btn-na'><h4>$currentDay</h4>Gone</button></td>";
        } else {
            $calendar .= "<td class='" . $today . "'><button id='submit-bkg' type='submit'class='btn-bk'><a class='date-book' href='./assets/pages/book.php?date=" . $date . "'><h4 >$currentDay</h4>Book</a></button></td>";
        }



        // if ($dateToday == $date) {
        //     $calendar .= "<td class='today' rel='$date'><h4>$currentDay</h4></td>";
        // } else {
        //     $calendar .= "<td class='' rel='$date'><h4>$currentDay</h4></td>";
        // }


        // $calendar .= "<td><h4><center>$currentDay</center></h4></td>";

        //increment counters
        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($i = 0; $i < $remainingDays; $i++) {
            $calendar .= "<td></td>";
        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    echo $calendar;
}

?>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="description" content="160 chr of eyecatchin SEO content for google search written in good english" />
    <meta name="keywords" content="keyword1, keyword2, etc" />
    <author name="author" content="Yfke"></author>
    <meta name="robots" content="index" />
    <meta http-equiv="refresh" content="" 5;url="#" />
    <link rel="stylesheet" href="./styles/style.css" />
    <title>Y. Bookings</title>
</head>

<body>
    <header>
        <h1>My Schedule</h1>
    </header>
    <container>
        <div class="row">
            <div class="col-md-12">
                <?php
                $dateComponents = getDate();
                $month = $dateComponents['mon'];
                $year = $dateComponents['year'];
                echo build_calendar($month, $year);
                ?>
            </div>
        </div>
    </container>
    <footer>
        <p>
            &copy;
            <img src="./assets/branding/rose_Logo_22.png" alt="Yfkes logo" style="width: 70px" />
            <!-- <script src="./scripts/script.js"></script> -->
        </p>
    </footer>
</body>

</html>