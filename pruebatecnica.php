<?php
// Start session to store CSRF token
session_start();

// Generate CSRF token and store it in the session
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRUEBA TECNICA</title>
    <link rel="stylesheet" href="./styles.css"> <!-- Import styles.css -->
</head>
<body>
    <h1>PRUEBA TÉCNICA MATEO FERRER AGENCIA SHARK </h1>
    <div class="container">
        <!-- Contenedor para mensajes -->
        <div id="messageBox" style="display: none; padding: 10px; margin-bottom: 15px; border-radius: 5px;"></div>

        <form id="contactForm" action="process_form.php" method="POST" novalidate>
            <!-- CSRF Protection -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required minlength="2" maxlength="50">
                <div class="error" id="nameError"></div>
            </div>

            <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" id="email" name="email" required>
                <div class="error" id="emailError"></div>
            </div>

            <div class="form-group">
                <label for="message">Mensaje</label>
                <textarea id="message" name="message" required minlength="10"></textarea>
                <div class="error" id="messageError"></div>
            </div>

            <button type="submit">Enviar Formulario</button>
        </form>
    </div>
    <script src="./logica.js"></script> <!-- Import logica.js -->
</body>
</html>