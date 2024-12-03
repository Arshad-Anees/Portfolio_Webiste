<?php
// Replace with your real receiving email address
$receiving_email_address = 'maarshad4958@gmail.com';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
        exit;
    }

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Email subject and body
    $email_subject = "New Message from $name - $subject";
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";

    // Send email
    if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'There was an error sending your message. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
