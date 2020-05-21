<?php


if (isset($_POST['email_data'])) {
    require 'class/class.phpmailer.php';
    $output = '';
    foreach ($_POST['email_data'] as $row) {
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $mail = new PHPMailer;
        $mail->IsSMTP();        
        $mail->Host = 'mail.lionsclubs325a1.org.np';  
        $mail->Port = '587';        
        $mail->SMTPAuth = true;       
        $mail->Username = 'info@lionsclubs325a1.org.np';     
        $mail->Password = 'S{b$-{eujFO8';     
        $mail->SMTPSecure = '';      
        $mail->From = 'info@lionsclubs325a1.org.np';   
        $mail->FromName = 'LIONS CLUB';     
        $mail->AddAddress($row["email"], $row["name"]); 
        $mail->WordWrap = 50;   
        $mail->IsHTML(true);
        $mail->Subject = 'Welcome To LIONS CLUB';
        //An HTML or plain text message body
        $mail->Body = '
                <div style="border:1px solid #4de1f0;border-width: 3px;background:#4de1f0;">
                <div style="margin:20px;">
		<p>Welcome '.$name.'</p>
                <p>Please find your Email - '.$email.'</p>    
		<p>Please find your Password - '.$password.'</p>
                    <br>
		<a href="http://lionsclubs325a1.org.np/" target="_blank">You Can login to Vote From Here.</a>
                </div>
                </div>
		';

        $mail->AltBody = '';
        $result = $mail->Send();      //Send an Email. Return true on success or false on error
        if ($result["code"] == '400') {
            $output .= html_entity_decode($result['full_error']);
        }
    }
    if ($output == '') {
        echo 'ok';
    } else {
        echo $output;
    }
}
?>