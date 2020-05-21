<?php
error_reporting(1);
ob_start();
session_start();
include 'db.php';
include_once 'header.php';

date_default_timezone_set("Asia/Kolkata");
$current_time = date("h:i:s a");
$begin = "10:00 am";
$end = "6:00 pm";

$date1 = DateTime::createFromFormat('H:i a', $current_time);
$date2 = DateTime::createFromFormat('H:i a', $begin);
$date3 = DateTime::createFromFormat('H:i a', $end);



if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email === 'admin@admin.com') {
        $q = "(SELECT * FROM admin where Email = '$email' AND Password = '$password')";
    } else {
        $q = "(SELECT * FROM voterslist where Email = '$email' AND Pass = '" . md5($password) . "')";
    }
    $checkuser = $connection->query($q);
    if (mysqli_num_rows($checkuser) > 0) {
        $row = $checkuser->fetch_array(MYSQLI_ASSOC);
        $id = $row['ID'];
        if ($row['IsAdmin'] == 1) {
            $_SESSION['ID'] = $id;
            $success = "<h5 class='text-success'> Login Successful.</h5><script>setTimeout(\"location.href = 'Application/';\",3000);</script>";
        } else if ($row['IsAdmin'] == 0 AND $row['Status'] == 0) {
            if ($date1 > $date2 && $date1 < $date3) {
                $_SESSION['ID'] = $id;
                $success = "<h5 class='text-success'> Login Successful.</h5><script>setTimeout(\"location.href = 'caster/castvote.php';\",3000);</script>";
            } else {
                $error = "<h5 class='text-danger text-center'>You Cannot Login Before Time</h5>";
            }
        } else if ($row['IsAdmin'] == 0 AND $row['Status'] == 1) {
            $_SESSION['ID'] = $id;
            $success = "<h5 class='text-success'> You Have Cast your Vote. Thank you And Wait For Result</h5>";
        } else {
            $error = "<h5 class='text-danger'>User Not Available</h5>";
        }
    } else {
        $error = "<h5 class='text-danger'>Error finding the Email - " . $email . "</h5>";
    }
}
?>
<body>

    <section class="login-block" style="height: 754px;">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3">
                    <h4 class="text-center">LOGIN TO VOTE</h4>
                    <hr>
                </div>

                <div class="col-sm-4">
                    <h4 class="text-center">CANDIDATE LIST</h4>
                    <hr>
                </div>

                <div class="col-sm-5">
                    <h4 class="text-right">
                        VOTING HOURS - (10 AM to 5 PM Only)
                        <hr>
                    </h4>
                </div>

                <div class="col-lg-3 login-sec">
                    <?php
                    if (isset($success)) {
                        echo $success;
                    } else if (isset($error)) {
                        echo $error;
                    }
                    ?>
                    <h2 class="text-center">Login Now</h2>
                    <form action="" method="post" id="form" autocomplete="off">
                        <div class="form-group">
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Your Password" required>
                        </div>
                        <div class="form-check">
                            <button type="submit" name="submit" class="btn btn-sm btn-danger float-right" id="loginsubmit">Submit</button>
                        </div>

                    </form>
                </div>

                <div class="col-lg-9 kyare" style="border-left:1px solid #E6776C;border-width: 5px;background:linear-gradient(to bottom, #FFB88C, #4de1f0);">
                    
                    <div id="flip1">
                        <div class="row" >
                            <?php
                            $sql = mysqli_query($connection, "select * from candidates");
                            while ($rowc = mysqli_fetch_array($sql)) {
                                ?>
                                <div class="col-sm-3">
                                    <div class="card" style="top:10px;width: 12rem;height: 300px;">
                                        <img class="img img-thumbnail" src="dist/<?php echo $rowc['Photo'] ?>" width="200" >
                                        <div class="card-body">
                                            <p class="card-text text-danger"><?php echo $rowc['CandidateName']; ?></p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item" style="font-size: 12px;"><?php echo $rowc['PositionName']; ?></li>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div id="flip2">
                        <div class="row">
                            <?php
                            $totalsql = mysqli_query($connection, "select count(PollID)totalpoll from poll Where PollRemarks = 'Yes'");
                            $rowtotal = mysqli_fetch_array($totalsql);
                            $actcount = mysqli_query($connection, "SELECT PositionID,CandidateID,count(PollID)PollID FROM poll WHERE  PollRemarks = 'Yes' GROUP BY CandidateID,PositionID");
                            while ($rowuserwise = mysqli_fetch_array($actcount)) {
                                $percentage = ( $rowuserwise["PollID"] / $rowtotal["totalpoll"] ) * 100;
                                if (is_float($percentage)) {
                                    $percentage = number_format($percentage, 2);
                                }

                                $getcandidate = mysqli_query($connection, "select * from candidates where CID = '" . $rowuserwise['CandidateID'] . "' AND PositionID = '" . $rowuserwise['PositionID'] . "'");
                                $row = mysqli_fetch_array($getcandidate);
                                ?>
                                <div class="col-sm-3" style="top:10px;width: 12rem;height: 300px;">
                                    <img src="dist/<?php echo $row['Photo']; ?>" class="img img-thumbnail" alt="Candidate Image" width="200"/>
                                    <div class="progress-group">
                                        <span class="progress-text"><?php echo $row['CandidateName'] . " <br/> (" . $row['PositionName'] . ")"; ?></span>
                                        <span class="progress-number"><b><?php echo "<br>".$percentage . " %"; ?></b></span>
                                        <div class="progress xs">
                                            <div class="progress-bar <?php echo $a; ?>" style="width: <?php echo $percentage; ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>


                <div  class="col-lg-8" style="margin:10px;">
                    <button type="submit" name="submit" class="btn btn-success btn-sm float-right first" id="getresult">Get Vote Result</button>
                    <button type="submit" name="submit" class="btn btn-danger btn-sm float-right second" id="returnto">Return</button>
                </div>

            </div>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>

    <script>

        // Form - 4
        $(".second,#flip2").hide();
        $("#getresult").click(function (e) {
            e.preventDefault();

            if ($(window).width() >= 576) {
                $(".kyare").toggleClass('rotate-Y');
            }

            $("#flip1").hide();
            $(".first").hide();

            $(".second").show();
            $("#flip2").fadeIn(1000);
        });

        $("#returnto").click(function (e) {
            e.preventDefault();
            //Toggling animation class
            if ($(window).width() >= 576) {
                $(".kyare").toggleClass('rotate-Y');
            }

            $("#flip1").fadeIn(1000);
            $(".first").show();

            $(".second").hide();
            $("#flip2").hide();
        });

    </script>


</body>
</html>