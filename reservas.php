<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Pista - SportCenter</title>
    <link rel="stylesheet" href="css/estilos-base.css">
</head>
<body>
    <header class="cabecera">
        <div class="contenedor">
            <div class="logo">SPORT CENTER</div>
            <nav class="menu">
                <a href="principal.html">PÁGINA PRINCIPAL</a>
                <a href="torneos.html">TORNEOS</a>
                <a href="reservas.html" class="pagina-activa">RESERVAR</a>
                <a href="index.html">CERRAR SESIÓN</a>
            </nav>
        </div>
    </header>

    <main>
        <h2 class="titulo-seccion">RESERVA TU DEPORTE</h2>
        <div class="bloque-info">
            <div class="contenedor-principal">
                <div class="seccion-izquierda columna-deporte">
                    <h3>FÚTBOL</h3>
                    <p>¡Reúne a tu equipo y vive el partido como un profesional! Disfruta de nuestros campos de césped artificial de última generación, diseñados con tecnología avanzada para ofrecer el mejor agarre, amortiguación óptima y un bote de balón perfecto. Reducen el riesgo de lesiones y garantizan una experiencia de juego superior bajo cualquier condición climática. No dejes tu partido de la semana al azar: asegura tu campo ahora, demuestra tu talento y comparte un tercer tiempo inolvidable con tus amigos.</p>
                    <a href="horarios-futbol.php" class="boton">¡RESERVA TU CAMPO YA!</a>
                </div>
                <div class="seccion-derecha">
                    <img src="fotos/futbol.jpg" class="imagen" alt="Campo de Fútbol">
                </div>
            </div>
        </div>

        <div class="bloque-info">
            <div class="contenedor-principal">
                <div class="seccion-izquierda columna-deporte">
                    <h3> Tenis</h3>
                    <p>Tanto si buscas un peloteo intenso para desconectar como si estás preparando tu próximo torneo, nuestras pistas de tenis son el escenario ideal. Elige entre la velocidad de nuestras pistas rápidas o la técnica de la tierra batida, ambas con un mantenimiento diario impecable, iluminación LED profesional antideslumbrante y las medidas reglamentarias óptimas. Cada punto cuenta: mejora tu revés, ponte a prueba y domina la pista. Las horas más solicitadas se agotan rápido, ¡organiza tu partido hoy mismo!</p>
                    <a href="horarios-tenis.php" class="boton">RESERVA TU PISTA DE TENIS</a>
                </div>
                <div class="seccion-derecha">
                    <img src="fotos/tenis.jpg" class="imagen" alt="Pista de Tenis">
                </div>
            </div>
        </div>

        <div class="bloque-info">
            <div class="contenedor-principal">
                <div class="seccion-izquierda columna-deporte">
                    <h3> Padel </h3>
                    <p>Siente la verdadera adrenalina del pádel en nuestras espectaculares pistas panorámicas de última generación. Olvídate de los rebotes extraños: nuestros cristales templados de máxima visibilidad y el césped monofilamento Premium te garantizan un juego dinámico, rápido y 100% fluido. Además, contamos con una iluminación simétrica que elimina las sombras para que no pierdas de vista ni un solo remate. Es el deporte del momento y las mejores franjas horarias vuelan. ¡Elige tu hora, saca tu mejor pala y reserva ya!</p>
                    <a href="horarios-padel.php" class="boton"> RESERVA TU PISTA DE PÁDEL </a>
                </div>
                <div class="seccion-derecha">
                    <img src="fotos/padel.jpg" class="imagen" alt="Pista de Padel">
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