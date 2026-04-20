<!-- HERO -->
<section class="hero-section hero-contact">
    <div class="hero-overlay"></div>

    <!-- AVATARES -->
    <div class="hero-team">
    <div class="hero-member">
        <img src="<?php echo ASSET_URL; ?>/img/G.png" alt="Guillermo">
        <p>Guillermo</p>
    </div>

    <div class="hero-member">
        <img src="<?php echo ASSET_URL; ?>/img/E.png" alt="Esther">
        <p>Esther</p>
    </div>
</div>
<br><br>

    <!-- TEXTO -->
    <div class="hero-content">
        <h1><span>Contacto</span></h1>

        <p class="hero-subtitle">
            Estamos para ayudarte con la mejor atención.
        </p>

        <p class="hero-cta">
            Escríbenos o ven a visitarnos.
        </p>

    </div>
</section>

<section class="contact-section">
    <div class="contact-grid">
        <div class="contact-info">
            <h2>Información de contacto</h2>

            <p>
                Si tienes cualquier duda sobre nuestros productos o pedidos online,
                puedes contactarnos o visitarnos en nuestra tienda.
            </p>

            <ul class="contact-list">

                <!-- DIRECCIÓN -->
                <li>
                    <div class="contact-card">
                        📍 Dirección
                    </div>

                    <div class="contact-box">
                        Calle Isla de Oza 35, 28035 Madrid
                    </div>
                </li>

                <!-- TELÉFONO -->
                <li>
                    <div class="contact-card">
                        📞 Teléfono
                    </div>

                    <div class="contact-box">
                        <a href="tel:+34637807226" class="phone-link">Llamar ahora 637 807 226</a><br><br>
                        <a href="tel:+34639867225" class="phone-link">Llamar ahora 639 867 225</a>
                    </div>
                </li>

                <!-- EMAIL -->
                <li>
                    <div class="contact-card">
                        ✉ Email
                    </div>


                    <div class="contact-box">
                        <a href="mailto:info@gyecarniceros.com?subject=Consulta&body=Hola, me gustaría información sobre...">
                            info@gyecarniceros.com
                        </a>
                    </div>
                </li>

            </ul>

            <h3>Horario</h3>

            <ul class="schedule">
                <li>
                    <span class="day">Lunes - Viernes</span>
                    <span class="time">
                        9:00 - 14:00 <span class="divider">/</span> 17:00 - 20:00
                    </span>
                </li>

                <li>
                    <span class="day">Sábado</span>
                    <span class="time">9:00 - 14:00</span>
                </li>

                <li class="closed">
                    <span class="day">Domingo</span>
                    <span class="time">Cerrado</span>
                </li>
            </ul>
            
        </div>

        <div class="contact-form">
            <h2>Envíanos un mensaje</h2>

            <?php if (!empty($_SESSION['contacto_error'])): ?>
                <div style="background:#fdecea; color:#8a1f17; border:1px solid #f5c2c0; padding:15px; margin-bottom:20px; border-radius:8px;">
                    <?php echo htmlspecialchars($_SESSION['contacto_error']); ?>
                </div>
                <?php unset($_SESSION['contacto_error']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['contacto_ok'])): ?>
                <div style="background:#edf7ed; color:#1e4620; border:1px solid #b7dfb9; padding:15px; margin-bottom:20px; border-radius:8px;">
                    <?php echo htmlspecialchars($_SESSION['contacto_ok']); ?>
                </div>
                <?php unset($_SESSION['contacto_ok']); ?>
            <?php endif; ?>

            <form method="post" action="<?php echo BASE_URL; ?>/?route=contacto-enviar">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Tu email" required>

                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" placeholder="Tu teléfono">

                <label for="asunto">Asunto</label>
                <input type="text" id="asunto" name="asunto" placeholder="Asunto del mensaje" required>

                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje" required></textarea>

                <button type="submit" class="btn btn-primary">
                    Enviar mensaje
                </button>
            </form>
        </div>
    </div>
</section>

<section class="map">
    <div class="map-overlay"></div>
    <iframe
        src="https://www.google.com/maps?q=Calle+Isla+de+Oza+35,+Madrid&output=embed"
        loading="lazy">
    </iframe>
</section>