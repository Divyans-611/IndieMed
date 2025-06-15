<?php
$host = "sql308.infinityfree.com";
$username = "if0_39238132";
$password = "Ynow8rEH1ceExFb";
$database = "if0_39238132_indiemed_db";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$full_name = $_POST['full_name'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$doctor = $_POST['doctor'];
$appointment_date = $_POST['appointment_date'];
$appointment_time = $_POST['appointment_time'];
$reason = $_POST['reason'];
$existing_patient = isset($_POST['existing_patient']) ? 1 : 0;
$patient_id = $_POST['patient_id'] ?? null;

$sql = "INSERT INTO appointments 
    (full_name, dob, email, phone, doctor, appointment_date, appointment_time, reason, existing_patient, patient_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssii", 
    $full_name, $dob, $email, $phone, $doctor, 
    $appointment_date, $appointment_time, $reason, 
    $existing_patient, $patient_id
);

if ($stmt->execute()) {
    echo "Appointment booked successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>