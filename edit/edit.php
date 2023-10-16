<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Información</title>
    <link rel="stylesheet" type="text/css" href="/edit/stylee.css">
    <link rel="stylesheet" href="/edit/modal/modal.css">
</head>

<body>

    <div class='imagen2'>
        <div><img src="/imagenes/devchallenges.svg" class="devchallenges" alt="devch"></div><br>
        <div class="imagen3">
            <div><img src="/public/perfil/personal1.png" height='30' alt="devch">Xanthe Neal</div><br>
        </div>
    </div>

    <div>
            <!-- Botón Back -->
            <button onclick="goBack()">< Back</button>
        </div>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    <?php
    session_start();

    // Verificar si el usuario está autenticado 
    if (isset($_SESSION['user_id'])) {

        // Recupera los datos de la sesión
        $user_id = $_SESSION['user_id'];


        try {
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $dbname = "login_db";

            $mysqli = new mysqli($hostname, $username, $password, $dbname);
        } catch (\mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        }

        // Consulta SQL para obtener la información actual del usuario
        $query = "SELECT name, bio, phone, email FROM users WHERE id = ?";
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Mostrar la información actual del usuario en el formulario de edición
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $email = $row['email'];
            $bio = $row['bio'];
            $phone = $row['phone'];


            echo "<form action='edit_process.php' method='post'>";
            echo "<span class='changeinfo' >Change Info</span><br>";
            echo "<span class='changeswill'>Changes will be reflected to every services
            </span><br><br>";
            echo "<div><img src='/imagenes/worker.svg' width='50px'</div><span class='photo' >CHANGE PHOTO</span><br>";
            echo "<label for='name'>Name:</label> <br>";
            echo "<input type='text' placeholder='Enter your name...' name='name' value='$name'><br><br>";

            echo "<label for='bio'>Bio:</label><br>";
            echo "<textarea placeholder='Enter your bio...'name='bio' rows='4'>$bio</textarea><br><br>";

            echo "<label for='phone'>Phone:</label><br>";
            echo "<input type='text' placeholder='Enter your phone...' name='phone' value='$phone'><br><br>";

            echo "<label for='email'>Email:</label><br>";
            echo "<input type='email' placeholder='Enter your email...' name='email' value='$email'><br><br>";

            echo "<label for='password'>Password:</label><br>";
            echo "<input type='email' placeholder='Enter your password...' name='email' value='$password'><br><br>";

            echo "<input class='save' type='submit' value='Save'><br>";

            echo "</form>";
        } else {
            echo "No se encontró información del usuario.";
        }

        // Cierra la conexión a la base de datos
        $stmt->close();
        $mysqli->close();
    } else {
        // Si el usuario no está autenticado, muestra un mensaje de error y un enlace para iniciar sesión
        echo "Debes iniciar sesión para editar tu información. <a href='/login/login.php'>Iniciar Sesión</a>";
    }

    ?>

    <!-- Modal HTML -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="profilemain">
                <p class="myprofile">My Profile</p>
            </div><br><br>
            <div class="profilemain2">
                <p class="myprofile">Group Chat</p>
            </div><br>
            <div class="profilemain3">
                <a href="/logout.php">Logout</a>
            </div>
        </div>
    </div>
</body>
<div class="footerend">
    <footer>created by Carlos RV.</footer>
    <footer>devChallenges.io</footer>
</div>

</html>