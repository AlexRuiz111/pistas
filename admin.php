<?php
    // CREAR USUARIO

    $pdo = new PDO("mysql:host=localhost;dbname=pistas;charset=utf8", "root", "");

    $mensaje = "";
    if (isset($_POST['nombre'])) {

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
                    'nombre'   => $_POST['nombre'],
                    'email'    => $_POST['email'],
                    'password' => $password
                ]);

                $mensaje = "Usuario registrado con éxito.";
                    
            } catch (PDOException $e) {
                $mensaje = "El usuario o correo ya existen";
            }
        }
    }
    // MOSTRAR USUARIOS
    $num_registros = 5;
    $pagina = isset($_POST["pagina"])? $_POST["pagina"]:1;

    $sql = "SELECT count(*) from usuarios where true";
    $stmt = $pdo->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_NUM);
    $stmt->execute();
    $rows = $stmt->fetch();
    $total_usuarios = $rows[0];
    $total_registros = ceil($total_usuarios / $num_registros);

    if(isset($_POST["siguiente"])) {
        $pagina++;
    }

    if(isset($_POST["anterior"]) && $pagina > 1) {
        $pagina--;
    }

    if(isset($_POST["primera"])) {
        $pagina = 1;
    }

    if(isset($_POST["ultima"])) {
        $pagina = $total_registros;
    }

    $inicio = ($pagina * $num_registros) - $num_registros;


    $consulta = $pdo->query("SELECT nombre, email, password FROM usuarios limit $inicio,5");

    // ELIMINAR USUARIOS
    if (isset($_POST["eliminar"])) {
        $borrar_email = $_POST["eliminar"];

        $sql_borrar = "DELETE from usuarios where email = :email";
        $stmt_borrar = $pdo->prepare($sql_borrar);
        $stmt_borrar->execute(['email' => $borrar_email]);

        $consulta = $pdo->query("SELECT nombre, email, password FROM usuarios limit $inicio,5");
    }

    // MODIFICAR USUARIOS
    $mensaje_mod = "";

    if (isset($_POST["mod_usuario"])) {
        $email_id = $_POST["mod_usuario"];
        $nuevo_nombre = $_POST["mod_nombre"];
        $nuevo_email = $_POST["mod_email"];
        $nueva_pass = $_POST["mod_password"];

        try {
            $sql_update = "UPDATE usuarios SET nombre = :nombre, email = :nuevo_email, password = :pass where email = :email_id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([
                'nombre' => $nuevo_nombre,
                'nuevo_email' => $nuevo_email,
                'pass' => $nueva_pass,
                'email_id' => $email_id
            ]);

            $mensaje_mod= "Usuario modificado.";
            $consulta = $pdo->query("SELECT nombre, email, password FROM usuarios LIMIT $inicio, 5");
        } catch (PDOException $e) {
            $mensaje_mod = "El correo ya está registrado por otro usuario.";
        }
    }

    // RESERVAR PISTAS / ELIMINAR RESERVAS
    if (isset($_POST['cancelar_reserva'])) {
        $hora = $_POST['hora'];
        $deporte = $_POST['deporte'];
        $tabla = "reservas_" . $deporte;
        
        $sql_cancelar = "UPDATE $tabla SET socio = '---', estado = 'LIBRE' WHERE hora = :hora";
        $stmt_cancelar = $pdo->prepare($sql_cancelar);
        $stmt_cancelar->execute(['hora' => $hora]);
    }

    if (isset($_POST['reservar_admin'])) {
        $hora = $_POST['hora'];
        $deporte = $_POST['deporte'];
        $tabla = "reservas_" . $deporte;
        
        $sql_reservar = "UPDATE $tabla SET socio = 'Admin', estado = 'OCUPADA' WHERE hora = :hora";
        $stmt_reservar = $pdo->prepare($sql_reservar);
        $stmt_reservar->execute(['hora' => $hora]);
    }

    $num_registros_pistas = 5;
    $pagina_pistas = isset($_POST["pagina_pistas"]) ? $_POST["pagina_pistas"] : 1;

    $sql_total_pistas = "
        SELECT (SELECT COUNT(*) FROM reservas_futbol) + 
               (SELECT COUNT(*) FROM reservas_padel) + 
               (SELECT COUNT(*) FROM reservas_tenis) AS total
    ";
    $stmt_tot_pistas = $pdo->query($sql_total_pistas);
    $total_pistas = $stmt_tot_pistas->fetchColumn();
    $total_registros_pistas = ceil($total_pistas / $num_registros_pistas);

    if (isset($_POST["siguiente_pistas"])) {
        $pagina_pistas++;
    }
    if (isset($_POST["anterior_pistas"]) && $pagina_pistas > 1) {
        $pagina_pistas--;
    }
    if (isset($_POST["primera_pistas"])) {
        $pagina_pistas = 1;
    }
    if (isset($_POST["ultima_pistas"])) {
        $pagina_pistas = $total_registros_pistas;
    }

    $inicio_pistas = ($pagina_pistas * $num_registros_pistas) - $num_registros_pistas;

   $query_pistas = "
        SELECT 'futbol' AS deporte, 'Fútbol' AS nombre_pista, hora, socio, estado FROM reservas_futbol
        UNION ALL
        SELECT 'padel' AS deporte, 'Pádel' AS nombre_pista, hora, socio, estado FROM reservas_padel
        UNION ALL
        SELECT 'tenis' AS deporte, 'Tenis' AS nombre_pista, hora, socio, estado FROM reservas_tenis
        ORDER BY nombre_pista ASC, hora ASC
        LIMIT $inicio_pistas, $num_registros_pistas
    ";
    $consulta_pistas = $pdo->query($query_pistas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - SportCenter</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<header class="cabecera">
    <div class="contenedor">
        <div class="logo">SPORT CENTER</div>
        <nav class="menu">
            <a href="login.php" class="logout">CERRAR SESIÓN</a>
        </nav>
    </div>
</header>

<main>
    <h1 class="titulo-bienvenida">PANEL DE ADMINISTRACIÓN</h1>

    <div class="panel-fila"> 
        <div class="bloque-admin">
            <h3>Usuarios Registrados</h3>
            <p>Lista actual de usuarios en el sistema. Puedes eliminar cuentas directamente.</p>
            
            <div class="tabla-contenedor">
                <table class="tabla-admin">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Contraseña</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) { 
                    ?>
                    <tr>
                        <td><?php echo $fila['nombre']; ?></td>
                        <td><?php echo $fila['email']; ?></td>
                        <td><?php echo $fila['password']; ?></td>
                        <td>
                            <form method="POST">
                                <button type="submit" class="boton boton-peligro" name="eliminar" value="<?php echo $fila['email']; ?>"> Eliminar </button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <form method="POST">
                    <input type="submit" class="boton" name="primera" value="<<">
                    <input type="submit" class="boton" name="anterior" value="<">
                    <input type="number" class="boton" name="pagina" value="<?php echo $pagina ?>">
                    <input type="submit" class="boton" name="siguiente" value=">">
                    <input type="submit" class="boton" name="ir" value="ir">  
                    <input type="submit" class="boton" name="ultima" value=">>">
                </form>
            </div>
        </div>

        <div class="bloque-admin">
            <h3>Control y Reserva de Pistas</h3>
            <p>Consulta el estado de ocupación de las instalaciones y gestiona las reservas.</p>
            
            <div class="tabla-contenedor">
                <table class="tabla-admin">
                    <thead>
                        <tr>
                            <th>Pista</th>
                            <th>Horario</th>
                            <th>Socio</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pista = $consulta_pistas->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $pista['nombre_pista']; ?></td>
                                <td><?php echo $pista['hora']; ?></td>
                                <td><?php echo $pista['socio']; ?></td>
                                <td>
                                    <span class="<?php echo ($pista['estado'] == 'OCUPADA') ? 'estado-ocupada' : 'estado-libre'; ?>">
                                        <?php echo $pista['estado']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($pista['estado'] == 'OCUPADA') { ?>
                                        <form method="POST">
                                            <input type="hidden" name="hora" value="<?php echo $pista['hora']; ?>">
                                            <input type="hidden" name="deporte" value="<?php echo $pista['deporte']; ?>">
                                            <input type="hidden" name="pagina_pistas" value="<?php echo $pagina_pistas; ?>">
                                            <button type="submit" name="cancelar_reserva" class="boton boton-peligro">Cancelar</button>
                                        </form>
                                    <?php } else { ?>
                                        <form method="POST">
                                            <input type="hidden" name="hora" value="<?php echo $pista['hora']; ?>">
                                            <input type="hidden" name="deporte" value="<?php echo $pista['deporte']; ?>">
                                            <input type="hidden" name="pagina_pistas" value="<?php echo $pagina_pistas; ?>">
                                            <button type="submit" name="reservar_admin" class="boton">Reservar</button>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <form method="POST">
                    <input type="submit" class="boton" name="primera_pistas" value="<<">
                    <input type="submit" class="boton" name="anterior_pistas" value="<">
                    <input type="number" class="boton" name="pagina_pistas" value="<?php echo $pagina_pistas ?>">
                    <input type="submit" class="boton" name="siguiente_pistas" value=">">
                    <input type="submit" class="boton" name="ir_pistas" value="ir">  
                    <input type="submit" class="boton" name="ultima_pistas" value=">>">
                </form>
            </div>
        </div>
    </div>

    <div class="panel-fila">
        <div class="bloque-admin">
            <h3>Crear Usuario</h3>
            <p>Registra una nueva cuenta de acceso en la plataforma.</p>
            
            <div class="tabla-contenedor">
                <form method="POST" class="formulario-panel">
                    <div class="campo">
                        <label>Nombre de Usuario</label>
                        <input type="text" name="nombre" required>
                    </div>
                    <div class="campo">
                        <label>Correo Electrónico</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="campo">
                        <label>Contraseña</label>
                        <input type="password" name="password" required>
                    </div>
                    <?php echo $mensaje; ?>
                    <input type="submit" class="boton boton-guardar" value="ENVIAR">
                </form>
            </div>    
        </div>

        <div class="bloque-admin">
            <h3>Modificar Usuario</h3>
            <p>Introduce el ID o usuario para actualizar sus credenciales actuales.</p>
            
            <div class="tabla-contenedor">
                <form method="POST" class="formulario-panel">
                    <div class="campo">
                        <label> Email del usuario a modificar </label>
                        <input type="text" name="mod_usuario" required>
                    </div>
                    <div class="campo">
                        <label>Nuevo nombre de Usuario </label>
                        <input type="text" name="mod_nombre">
                    </div>
                    <div class="campo">
                        <label>Nuevo Correo</label>
                        <input type="email" name="mod_email">
                    </div>
                    <div class="campo">
                        <label>Nueva Contraseña</label>
                        <input type="password" name="mod_password">
                    </div>
                    <?php echo $mensaje_mod; ?>
                    <button type="submit" class="boton boton-guardar">MODIFICAR USUARIO</button>
                </form>
            </div>    
        </div>
    </div>
</main>

</body>
</html>