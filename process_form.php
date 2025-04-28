<?php
// Security headers
header('Content-Type: application/json');

try {
    // Validate CSRF token
    validateCSRFToken();

    // Sanitize and validate inputs
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');

    // Validate inputs
    if (empty($name) || strlen($name) < 2 || strlen($name) > 50) {
        throw new Exception('El nombre debe tener entre 2 y 50 caracteres.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Debes ingresar un correo válido.');
    }
    if (empty($message) || strlen($message) < 10) {
        throw new Exception('El mensaje debe tener al menos 10 caracteres.');
    }

    // Process form data (e.g., send email)
    sendEmail($name, $email, $message);

    // Return success response
    echo json_encode(['success' => true, 'message' => 'Formulario enviado correctamente.']);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// Function to validate CSRF token
function validateCSRFToken() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== generateToken()) {
        throw new Exception('Token CSRF inválido.');
    }
}

// Function to generate a CSRF token (for demonstration purposes)
function generateToken() {
    // Replace this with your actual token generation logic
    return 'secure_csrf_token';
}

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Function to send email (dummy implementation)
function sendEmail($name, $email, $message) {
    // Replace this with actual email sending logic (e.g., using PHPMailer or mail())
    // For now, just log the data
    error_log("Email sent to $email with message: $message");
}
?>