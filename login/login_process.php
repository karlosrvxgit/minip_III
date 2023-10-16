<?php
session_start();

// Verifica si se enviaron datos de inicio de sesión
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Recupera los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Conecta a la base de datos
    try {
        $hostname = "localhost";
        $username = "root";
        $db_password = "";
        $dbname = "login_db";

        $mysqli = new mysqli($hostname, $username, $db_password, $dbname);

        // Verifica la conexión a la base de datos
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
    } catch (\mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }

    // Consulta SQL para verificar las credenciales del usuario
    $query = "SELECT id, name, email, password FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // El usuario existe en la base de datos
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verifica la contraseña utilizando password_verify
        if (password_verify($password, $hashed_password)) {
            // Inicio de sesión exitoso, establece las variables de sesión
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];

            // Redirige al usuario a la página de información personal
            header('Location: /views/perfil.php');
            exit();
        } else {
            // Contraseña incorrecta, muestra un mensaje de error
            echo "Contraseña incorrecta. <a href='/login/login.php'>Volver a intentar</a>";
        }
    } else {
        // El usuario no existe, muestra un mensaje de error
        echo "No se encontró un usuario con ese email. <a href='/login/login.php'>Volver a intentar</a>";
    }

    // Cierra la conexión a la base de datos
    $stmt->close();
    $mysqli->close();
} else {
    // Si no se enviaron datos de inicio de sesión, muestra un mensaje de error
    echo "Se requieren datos de inicio de sesión. <a href='/login/login.php'>Volver a intentar</a>";
}
?>
