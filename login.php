<?php 
    $mensaje = "";
    if (isset($_POST['nombre'])) {
        $pdo = new PDO("mysql:host=localhost;dbname=pistas;charset=utf8", "root", "");
        
        $usuario = $_POST['nombre'];
        $password = $_POST['password'];

        try {
            $sql = "SELECT nombre, password from usuarios where nombre = :nombre and password = :password";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nombre'   => $usuario,
                'password' => $password
            ]);

            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user_info) {
                header("Location: principal.html");
            } else {
                $mensaje = "Error: El usuario o la contraseña no son correctos.";
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
    <title>Iniciar Sesión - SportCenter</title>
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
                <h2 class="titulo-seccion">INICIAR SESIÓN</h2>
                <?php echo $mensaje; ?>
                <form method="POST">
                    <div class="campo"><label>Nombre de Usuario</label><input type="text" name="nombre" required></div>
                    <div class="campo"><label>Contraseña</label><input type="password" name="password" required></div>
                    <input class="boton" type="submit" value="ENTRAR">
                    <a href="recuperar.php" class="boton">RECUPERAR CONTRASERÑA</a>
                </form>
            </div>
        </div>
    </main>
</body>
</html>