<?php
session_start();

$deporte = $_GET['deporte'] ?? '';
$hora = $_GET['hora'] ?? '';

if (isset($_POST['confirmar'])) {
    $pdo = new PDO("mysql:host=localhost;dbname=pistas;charset=utf8", "root", "");
    $usuario = $_SESSION['usuario_logeado'];

    if ($deporte == 'futbol') {
        $sql = "UPDATE reservas_futbol SET socio = :socio, estado = 'OCUPADA' WHERE hora = :hora";
    } elseif ($deporte == 'padel') {
        $sql = "UPDATE reservas_padel SET socio = :socio, estado = 'OCUPADA' WHERE hora = :hora";
    } elseif ($deporte == 'tenis') {
        $sql = "UPDATE reservas_tenis SET socio = :socio, estado = 'OCUPADA' WHERE hora = :hora";
    }

    if (isset($sql)) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['socio' => $usuario, 'hora' => $hora]);
    }
    
    header("Location: reservas.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago - SportCenter</title>
    <link rel="stylesheet" href="css/estilos-base.css">
</head>
<body>
    <main>
        <div class="bloque-formularios">
            <div class="caja-principal">
                <h2 class="titulo-seccion">MÉTODO DE PAGO</h2>
                <p style="text-align: center; color: white;">Reserva para <?php echo strtoupper($deporte); ?> - <?php echo $hora; ?></p>
                
                <form class="contenedor-formulario" method="POST" action="pago.php?deporte=<?php echo $deporte; ?>&hora=<?php echo $hora; ?>">
                    <div class="campo"><label>Número de Tarjeta</label><input type="text" placeholder="0000 0000 0000 0000" required></div>
                    <button type="submit" name="confirmar" class="boton">CONFIRMAR PAGO</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>