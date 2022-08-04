<div class="contenedor login">
    <?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__ .'/../templates/alertas.php'; ?>

        <form class="formulario" method="POST" action="/" novalidate>
            <div class="campo">
                <label for="usuario_email">Email</label>
                <input 
                    type="email"
                    id="usuario_email"
                    placeholder="Tu Email"
                    name="usuario_email"
                />
            </div>

            <div class="campo">
                <label for="usuario_password">Password</label>
                <input 
                    type="password"
                    id="usuario_password"
                    placeholder="Tu Password"
                    name="usuario_password"
                />
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? obtener una</a>
            <a href="/olvide">¿Olvidaste tu Password?</a>
        </div>
    </div> <!--.contenedor-sm -->
</div>