<?php
if (isset($_GET['date'])) {
    $date = $_GET['date'];
}

if (isset($_POST['submit-booking'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $student = $_POST['student'];
    $type = $_POST['type'];
    $timeslot = $_POST['timeslot'];
    $uid = $_POST['uid'];
    $location = $_POST['location'];
    $paid = "N";
    $completed = "N";

    $mysqli = new mysqli('localhost', 'root', '', 'bookingcalendar');
    $stmt = $mysqli->prepare("INSERT INTO bookings(email, uid, student, location , subject , grpind, date, timeslot, paid, completed ) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssssssss', $email, $uid, $student, $location, $subject, $type, $date, $timeslot, $paid, $completed);
    $stmt->execute();
    $msg = "<div class='alert alert-success'>Booking Successful</div>";
    $stmt->close();
    $mysqli->close();
}

$duration = 25;
$cleanup = 5;
$start = "15:00";
$end = "21:00";

function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupinterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();
    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupinterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }

        $slots[] = $intStart->format("H:iA") . "-" . $endPeriod->format("H:iA");
    }
    return $slots;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="160 chr of eyecatchin SEO content for google search written in good english">
    <meta name="keywords" content="keyword1, keyword2, etc">
    <author name="author" content="Yfke"></author>
    <meta name="robots" content="index">
    <meta http-equiv="refresh" content="" 5;url="#">
    <link rel="stylesheet" href="style.css">
    <title>Yfke.</title>
</head>

<body>
    <div class="container">
        <h1 class="center-text">Booking for <?php echo date('d F Y', strtotime($date)); ?></h1>
        <div class="row">
            <?php $timeslots = timeslots($duration, $cleanup, $start, $end);
            foreach ($timeslots as $ts) {
            ?>
                <div class="col-md-2">
                    <div class="form-group">
                        <button class="btn btn-book"><?php echo $ts; ?>
                        </button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <footer>
        <p>&copy;
            <img src="../branding/yfke_logo21.png" alt="Yfkes logo" style="width: 70px">
            <script src="script.js"></script>
        </p>
    </footer>
</body>

</html>