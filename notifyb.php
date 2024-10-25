<?php
// Include required files for database and Twilio
include 'db.php';
require __DIR__ . '/vendor/autoload.php'; // Assuming you installed Twilio SDK using Composer

use Twilio\Rest\Client;

// Twilio Credentials
$twilioSid = 'AC4ec26bf071eb076ed0e711a9967fd3c6';
$twilioAuthToken = '458ada148889ae52d1251c061cf5d243';
$twilioWhatsAppFrom = 'whatsapp:+14155238886'; // Twilio WhatsApp number

// Create Twilio Client
$client = new Client($twilioSid, $twilioAuthToken);

// Handle the form submission via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Fetch all users from the `users` table in the `user_management` database
    $sql = "SELECT reg_no, ph_no FROM user_management.boys_users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reg_no = $row['reg_no'];
            $ph_no = $row['ph_no'];

            // Fetch the bill amount for the user from the `mess_bills` table in `attendance_system` database
            $sql_bill = "SELECT bill_amount FROM attendance_system.boys_mess_bills WHERE reg_no = ? AND month = ? AND year = ?";
            $stmt_bill = $conn->prepare($sql_bill);
            $stmt_bill->bind_param("sii", $reg_no, $month, $year);
            $stmt_bill->execute();
            $result_bill = $stmt_bill->get_result();

            if ($result_bill->num_rows > 0) {
                $bill_row = $result_bill->fetch_assoc();
                $bill_amount = number_format($bill_row['bill_amount'], 2);

                // Send WhatsApp message using Twilio API
                $message = "Dear Student (Reg No: $reg_no), your mess bill for $month/$year is ₹$bill_amount. Please pay the bill at the earliest.";
                
                try {
                    $client->messages->create(
                        'whatsapp:+91' . $ph_no, // User's WhatsApp number (assuming Indian numbers)
                        [
                            'from' => $twilioWhatsAppFrom,
                            'body' => $message
                        ]
                    );
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => "Failed to send notification to $reg_no: " . $e->getMessage()]);
                    exit;
                }
            }
            $stmt_bill->close();
        }
        echo json_encode(['status' => 'success', 'message' => 'Notifications sent']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No users found.']);
    }

    $conn->close();
    exit;
}
