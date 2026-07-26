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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database using the configuration constants
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Generate a unique ticket ID (you can use a combination of date, time, and random number).
    $ticket_id = date("YmdHis") . mt_rand(1000, 9999);

    // Save the feedback and ticket details to a database.
    $sql = "INSERT INTO feedback (name, email, message, ticket_no) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $message, $ticket_id);
    // Ensure you have a database connection set up.


    if ($stmt->execute()) {
        $mail = new PHPMailer(true);

        try {
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
            $toUser = $_POST["email"];
            $nameUser = $_POST["name"];

            // Recipient for admin
            $toAdmin = $emailConfig['admin_email'];
            // Define the URL for the ticket status page
            $ticketStatusURL = BASE_URL."ticket_status.php?ticketID=" . $ticket_id;
            // Content for user
            $mail->setFrom($emailConfig['from_email'], $emailConfig['from_name']);
            $mail->addAddress($toUser, $nameUser);
            $mail->isHTML(false); // Set email format to HTML or false for plain text
            $mail->Subject = "Feedback Submitted - Ticket ID: $ticket_id";
            // Send an email to the user with the ticket ID and status.
            $user_message = "Thank you for your feedback!\n\nYour ticket ID is: $ticket_id\n\nMessage: $message\n\nHere is the link to check the status of your ticket:\n $ticketStatusURL \n\n Thank you for using our services.\n";
            $mail->Body = $user_message;

            $mail->send();

            // Content for admin
            $mail->clearAddresses(); // Clear the previous recipient (user)
            $mail->addAddress($toAdmin);
            $mail->Subject = "New Feedback Submitted - Ticket ID: $ticket_id";
            $admin_message = "New Feedback Submitted:\n\nTicket ID: $ticket_id\n\nName: $name\nEmail: $email\nMessage: $message";
            $mail->Body = $admin_message;

            $mail->send();

            //echo 'Message has been sent';
            ob_end_clean();
            // Define the relative path or URL you want to redirect to
            $redirect_path = "feedback.php?status=success";

            // Combine the base URL and the relative path to create the complete URL
            $complete_url = BASE_URL . $redirect_path;
            // echo $complete_url;exit();
            // Use the complete URL in the Location header
            header("Location: $complete_url");
            exit;

            // Redirect the user back to the form with a success message.
            /*header("Location: feedback.php?status=success");
            exit;*/
        } catch (Exception $e) {
            ob_end_clean();
            // Define the relative path or URL you want to redirect to
            $redirect_path = "feedback.php?status=error";

            // Combine the base URL and the relative path to create the complete URL
            $complete_url = BASE_URL . $redirect_path;
            // echo $complete_url;exit();
            // Use the complete URL in the Location header
            header("Location: $complete_url");
            exit;
            
            /*echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            exit();
            // Redirect the user back to the form with a error message.
            header("Location: feedback.php?status=error");
            exit;*/
        }
    }
    // Close the database connection
    $conn->close();
}
?>
