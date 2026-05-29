<?php 
    $mensaje = "";
    if(isset($_POST['email'])) {
        $pdo = new PDO("mysql:host=localhost;dbname=pistas;charset=utf8", "root", "");

        $email = $_POST['email'];

        try {
            if ($email != "admin@gmail.com") {
                $sql = "SELECT password from usuarios where email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'email' => $email
                ]);

                $contrasena = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($contrasena) {
                    $mensaje = "Su contraseña es: ". $contrasena['password'];
                } else {
                    $mensaje = "Su correo electronico no consta en nuestra base de datos.";
                }
            } else {
                $mensaje = "Contraseña protegida";
            }
        } catch (PDOException $e) {
            $mensaje = "Error en la conexión: " . $e->getMessage();
        }
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar - SportCenter</title>
    <link rel="stylesheet" href="css/estilos-base.css">
</head>
<body>
    <header class="cabecera">
        <div class="contenedor">
            <div class="logo">SPORT CENTER</div>
            <nav class="menu">
                <a href="index.html">INICIO</a>
                <a href="login.php" class="pagina-activa">INICIAR SESIÓN</a>
                <a href="registro.php">REGISTRARTE</a>
            </nav>
        </div>
    </header>

    <main> 
        <div class="bloque-formularios">   
            <div class="caja-principal">
                <h2 class="titulo-seccion">RECUPERAR ACCESO</h2>
                <p class="parrafo-espaciado">Introduce tu correo electrónico para recibir la contraseña.</p>
                <form method="POST">
                    <div class="campo">
                        <label>Email de Socio</label>
                        <?php echo $mensaje; ?>
                        <input type="email" name="email" placeholder="ejemplo@ejemplo.com" required>
                    </div>
                    <input class="boton" type="submit" value="ENVIAR">
                </form>
            </div>
        </div>
    </main>

</body>
</html>