<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Socio - SportCenter</title>
    <link rel="stylesheet" href="css/estilos-base.css">
</head>
<body>
    <header class="cabecera">
        <div class="contenedor">
            <div class="logo">SPORT CENTER</div>
            <nav class="menu">
                <a href="principal.php" class="pagina-activa">PÁGINA PRINCIPAL</a>
                <a href="torneos.html">TORNEOS</a>
                <a href="reservas.php">RESERVAR</a>
                <a href="index.html">CERRAR SESIÓN</a>
            </nav>
        </div>
    </header>
    <main>
        <h1 class="titulo-bienvenida">BIENVENIDO AL COMPLEJO SPORTCENTER</h1>
        <div class="bloque-info">
            <div class="contenedor-principal">
                <div class="seccion-izquierda">
                    <h2>🏆 ELIGE TU DEPORTE Y DOMINA LA PISTA</h2>
                    <div id="ul-principal">    
                        <ul>
                            <li> ⚽ FÚTBOL: ¡Reúne a tu equipo y arma el partido! Pistas perfectas para jugar a máxima intensidad, tocar el balón y gritar los mejores goles con tus amigos.</li>
                            <li> 🎾 PÁDEL: El deporte del momento te espera. Disfruta de pistas rápidas y en perfecto estado, ideales para tus mejores bandejas, remates y partidos más dinámicos.</li>
                            <li> 👟 TENIS: Siente el control en cada golpe, mejora tu servicio y compite al más alto nivel en superficies diseñadas para un bote y un juego impecables.</li>
                        </ul>
                    </div>
                    <div>
                        <a href="reservas.php" class="boton"> RESERVAR PISTA </a>
                    </div>
                </div>
                <div class="seccion-derecha">
                    <img src="fotos/inicio.png" alt="Foto del complejo deportivo" class="imagen">
                </div>

            </div>
        </div>
    </main>

    <footer>
        <div class="contenedor-footer">
            <div class="columna-footer">
                <h4 class="titulo-footer">SPORT CENTER</h4>
                <p>Tu complejo deportivo de confianza en la Vega Baja. Excelencia, salud y comunidad.</p>
            </div>
            <div class="columna-footer">
                <h4 class="titulo-footer">CONTACTO</h4>
                <ul class="lista-footer">
                    <li>📍 Orihuela, Alicante</li>
                    <li>📞 +34 966 000 000</li>
                    <li>✉ info@juanjerrez.com</li>
                </ul>
            </div>
            <div class="columna-footer">
                <h4 class="titulo-footer">HORARIOS</h4>
                <ul class="lista-footer">
                    <li>Lunes a Viernes: 7:00 - 23:00</li>
                    <li>Sábados y Domingos: 8:00 - 21:00</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2026 Complejo Deportivo JuanJerrez - Todos los derechos reservados</p>
        </div>
    </footer>
</body>
</html>