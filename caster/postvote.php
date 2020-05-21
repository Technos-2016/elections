<?php

error_reporting(1);
include_once '../db.php';
$uid = $_POST['uid'];
$vote = $_POST['vote'];
$count = count($vote);
if ($count == 0) {
    echo "<script>alert('Please select First');location.href = 'castvote.php';</script>";
} else if ($count == 1) {
    echo "<script>alert('Please select atleast one VDG');location.href = 'castvote.php';</script>";
} else if ($count == 4) {
    echo "<script>alert('Please select only one value from Vice DG Position');location.href = 'castvote.php';</script>";
} else if ($count == 3) {
    foreach ($vote as $key => $value) {
        $v1 = explode(",", $value);
        $insert = "INSERT INTO poll(UserID,PositionID,CandidateID,PollRemarks)VALUES('$uid','$key','$v1[1]','$v1[0]')";
        //echo $insert;
        $run = mysqli_query($connection, $insert);
        if ($run) {
            mysqli_query($connection, "UPDATE voterslist SET Status = 1 WHERE ID = '$uid'");
            $getsql = mysqli_query($connection, "select * from voterslist where ID = '$uid'");
            $row = mysqli_fetch_array($getsql);
            require 'class/class.phpmailer.php';
            $email = $row['Email'];
            $name = $row['Name'];
            $mail = new PHPMailer;
            $mail->IsSMTP();        //Sets Mailer to send message using SMTP
            $mail->Host = 'mail.lionsclubs325a1.org.np';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
            $mail->Port = '587';        //Sets the default SMTP server port
            $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
            $mail->Username = 'info@lionsclubs325a1.org.np';     //Sets SMTP username
            $mail->Password = 'S{b$-{eujFO8';     //Sets SMTP password
            $mail->SMTPSecure = '';       //Sets connection prefix. Options are "", "ssl" or "tls"
            $mail->From = 'info@lionsclubs325a1.org.np';   //Sets the From email address for the message
            $mail->FromName = 'LIONS CLUB INTERNATIONAL';     //Sets the From name of the message
            $mail->AddAddress($email, $name); //Adds a "To" address
            $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
            $mail->IsHTML(true);       //Sets message type to HTML
            $mail->Subject = 'Thank You';
            //An HTML or plain text message body
            $mail->Body = '
		<p>Welcome '.$name.'</p>
                <p>Thank You for voting stay updated to get result!</p>';
            $mail->AltBody = '';
            $result = $mail->Send();      //Send an Email. Return true on success or false on error
            if ($result["code"] == '400') {
                echo "<script>alert('Error Generating Email');location.href = 'logout.php';</script>";
            } else {
                echo "<script>alert('Thank you for submitting your valuable vote');location.href = 'logout.php';</script>";
            }
        }
    }
}
?>