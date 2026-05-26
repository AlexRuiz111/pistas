<?php
    $mensaje = "";

    if (isset($_POST['usuario'])) {
        $pdo = new PDO("mysql:host=localhost;dbname=pistas;charset=utf8", "root", "");
    
        $password = $_POST['password'];

        $tiene_mayuscula = false;
        $tiene_minuscula = false;
        $tiene_numero = false;

        $letras = str_split($password);
        foreach ($letras as $letra) {
            if ($letra >= 'A' && $letra <= 'Z') { $tiene_mayuscula = true; }
            if ($letra >= 'a' && $letra <= 'z') { $tiene_minuscula = true; }
            if ($letra >= '0' && $letra <= '9') { $tiene_numero = true; }
        }

        if (strlen($password) < 8) {
            $mensaje = "Error: Debe tener mínimo 8 caracteres.";
        } elseif (!$tiene_mayuscula) {
            $mensaje = "Error: Falta una mayúscula.";
        } elseif (!$tiene_minuscula) {
            $mensaje = "Error: Falta una minúscula.";
        } elseif (!$tiene_numero) {
            $mensaje = "Error: Falta un número.";
        } else {
            try {
                $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'nombre'   => $_POST['usuario'],
                    'email'    => $_POST['email'],
                    'password' => $password
                ]);

                echo $mensaje = "¡Contraseña perfecta! Usuario registrado con éxito.";

            } catch (PDOException $e) {
                echo $mensaje = "Error: El usuario o el email ya están registrados.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarte - SportCenter</title>
    <link rel="stylesheet" href="css/estilos-base.css">
</head>
<body>

    <header class="cabecera">
        <div class="contenedor">
            <div class="logo">SPORT CENTER</div>
            <nav class="menu">
                <a href="index.html">INICIO</a>
                <a href="login.php">INICIAR SESIÓN</a>
                <a href="registro.php" class="pagina-activa">REGISTRARTE</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="bloque-formularios">
            <div class="caja-principal">
                <h2 class="titulo-seccion">CREAR CUENTA</h2>
                <form method="POST">
                    <div class="campo"><label>Nombre Usuario</label><input type="text" name="nombre" required></div>
                    <div class="campo"><label>Email</label><input type="email" placeholder="ejemplo@ejemplo.com" name="email" required></div>
                    <div class="campo"><label>Password</label><input type="password" name="password" required></div>
                    <input class="boton" type="submit" value="CREAR USUARIO">
                    <a href="principal.html" class="boton">ACCEDER</a>
                </form>
            </div>
        </div>
    </main>
</body>
</html>