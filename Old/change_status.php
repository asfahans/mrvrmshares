<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Include the database configuration
include('config.php');

// Include the email configuration
$emailConfig = include 'email_config.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $feedbackId = $_GET['id'];
    $newStatus = $_GET['status']; // Get the desired status from the URL parameter

    // Prepare and execute the SQL UPDATE query
    $sql = "UPDATE feedback SET ticket_status = ? WHERE ticket_no = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $newStatus, $feedbackId); // 'i' for integer
    if ($stmt->execute()) {
        // Get the user's email address from the database
        $sql2 = "SELECT email FROM feedback WHERE ticket_no = ?";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bind_param("i", $feedbackId); // 'i' for integer
        $stmt2->execute();
        $stmt2->bind_result($userEmail);

        if ($stmt2->fetch()) {
            if($newStatus == 1)
            {
                $status_code = 'In Process';
            }else{
                $status_code = 'Closed';
            }
            $mail = new PHPMailer(true);

            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
            $mail->isSMTP();
            $mail->Host = $emailConfig['host']; // SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = $emailConfig['username']; // SMTP username
            $mail->Password = $emailConfig['password']; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = $emailConfig['port']; // SMTP port

            // Recipient for user
            $toUser = $userEmail;

            // Define the URL for the ticket status page
            $ticketStatusURL = BASE_URL."ticket_status.php?ticketID=" . $ticket_id;
            // Content for user
            $mail->setFrom($emailConfig['from_email'], $emailConfig['from_name']);
            $mail->addAddress($toUser, $nameUser);
            $mail->isHTML(false); // Set email format to HTML or false for plain text
            $mail->Subject = "Feedback Status Update";
            $message = "Dear User,\n\n";
            $message .= "The status of your feedback has been updated to: " . $status_code . "\n";
            $message .= "Thank you for your feedback!\n";
            $mail->Body = $message;

            $mail->send();
            
        }
        $stmt2->close();
        // Update successful
        header("Location: feedback_list.php");
        exit;
    } else {
        // Handle the update error here
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$db->close();
?>
