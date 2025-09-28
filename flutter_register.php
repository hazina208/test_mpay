<?php
header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);

// Database connection (replace with your credentials)
include("connection.php");

//$conn = new mysqli($host, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Check for existing email, phone, id_no
// Check for existing email, phone, id_no
//$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR phone_number = ? OR id_no = ?");
//$stmt->bind_param("sss", $data['email'], $data['phone_number'], $data['id_no']);

$stmt = $conn->prepare("SELECT id FROM register WHERE email = ? OR phone = ?");
$stmt->bind_param("ss", $data['email'], $data['phone_number']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email or phone number already exists']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Hash password
$hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO register (phone, entity, entity_name, first_name, last_name, middle_name, email, password, show_pass, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $data['phone_number'], $data['entity'], $data['entity_name'], $data['first_name'], $data['last_name'], $data['middle_name'], $data['email'], $hashedPassword, $data['password'], $data['role']);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed']);
}
$stmt->close();
$conn->close();
?>