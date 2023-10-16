<?php
session_start();

// Verifica si se enviaron datos de registro
if (
    
    isset($_POST['email']) &&
    isset($_POST['password'])
) {
    //Recupera los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash de la contraseña 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $dbname = "login_db";
    
        $mysqli = new mysqli($hostname, $username, $password, $dbname);
    
    } catch (\mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }

    // Consulta SQL para insertar un nuevo usuario
    $query = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param('ss',$email, $hashed_password);

    if ($stmt->execute()) {
        // Registro exitoso, establece las variables de sesión
        $_SESSION['user_id'] = $mysqli->insert_id;
        
        $_SESSION['user_email'] = $email;
     

        // Redirige al usuario a la página de información personal
        header('Location: /views/perfil.php');
        exit();
    } else {
        // Error al registrar al usuario, muestra un mensaje de error
        echo "Error al registrar al usuario. <a href='/register/register.php'>Volver a intentar</a>";
    }

    // Cierra la conexión a la base de datos
    $stmt->close();
    $mysqli->close();
    // $db->close();
} else {
    // Si no se enviaron datos de registro, muestra un mensaje de error
    echo "Se requieren datos de registro. <a href='/register/register.php'>Volver a intentar</a>";
}
?>