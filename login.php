<?php 
    // 1. OBLIGATORIO: session_start() tiene que ser SIEMPRE la línea 1 de tu login
    session_start(); 
    
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
            
            if ($usuario == "Admin" && $password == "1234Admin") {
                $_SESSION['usuario_logeado'] = $usuario;
                header("Location: admin.php");   
                exit;
            }
        
            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user_info) {
                // 2. CORREGIDO: Guardamos el usuario en la sesión ANTES de cambiar de página
                $_SESSION['usuario_logeado'] = $usuario; 

                // 3. Redirigimos a la página principal una vez guardado el dato
                header("Location: principal.php");
                exit;
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