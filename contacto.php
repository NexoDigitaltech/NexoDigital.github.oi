<?php
// Prevenir spam
if (empty($_POST['nombre']) || empty($_POST['mensaje'])) {
    header("Location: index.php?status=empty");
    exit;
}
// Configuración básica
$destinatario = "sistemasmicheltc22@gmail.com";
$asunto = "Nuevo mensaje desde NexoDigital";

// Validar que el formulario se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener datos del formulario y sanitizarlos
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
    $servicio = filter_var($_POST['servicio'], FILTER_SANITIZE_STRING);
    $mensaje = filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING);

    // Construir el cuerpo del email (formato HTML para mejor legibilidad)
    $cuerpo = "
    <html>
    <body>
        <h2 style='color: #2A5BDD;'>Nuevo contacto desde el sitio web</h2>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>WhatsApp:</strong> $telefono</p>
        <p><strong>Servicio de interés:</strong> $servicio</p>
        <p><strong>Mensaje:</strong><br> $mensaje</p>
        <hr>
        <p><small>Enviado el " . date('d/m/Y H:i:s') . "</small></p>
    </body>
    </html>
    ";

    // Cabeceras para email HTML y codificación UTF-8
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: $nombre <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Intentar enviar el email
    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
        // Redirigir con mensaje de éxito
        header("Location: index.php?status=success");
    } else {
        // Redirigir con mensaje de error
        header("Location: index.php?status=error");
    }

} else {
    // Si no es POST, redirigir
    header("Location: index.php");
}
?>