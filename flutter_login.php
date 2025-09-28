<?php
header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);

// Database connection (replace with your credentials)
include("connection.php");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Find user by email, phone, or id_no
$stmt = $conn->prepare("SELECT password FROM register WHERE email = ? OR phone = ?");
$stmt->bind_param("ss", $data['identifier'], $data['identifier']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Incorrect identifier or password']);
    $stmt->close();
    $conn->close();
    exit;
}

$row = $result->fetch_assoc();
if (password_verify($data['password'], $row['password'])) {
    echo json_encode(['success' => true]);
    //$role=$_SESSION['role'];
	//$fn=$_SESSION['first_name'];
	//$ln=$_SESSION['last_name'];
	//$co=$_SESSION['entity_name'];
    //$log_sql = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?,?,?,?,?,?)";
    //$log_stmt = $conn->prepare($log_sql);
    //$log_stmt->bind_param('sssssi', $fn, $ln, $co, $email, $pwd, $role);
    //$log_stmt->execute();
} else {
    echo json_encode(['success' => false, 'message' => 'Incorrect identifier or password']);
}
$stmt->close();
$conn->close();
?>