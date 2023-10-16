<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/views/subir_imagen.php" method="post" enctype="multipart/form-data">
        <label>Upload imag</label>
        <input type="file" name="imagen">

        <button type="submit">Guardar imagen</button>
    </form>

    <section>
        <?php
        require_once($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");
        $res = $mysqli->query("SELECT * FROM users");

        while ($row = $res->fetch_assoc()) {
            $url = $row["img_url"];
            echo "<img src='$url' alt='Picture' height='100'/>";
        }
        ?>
    </section>
    
</body>
</html>