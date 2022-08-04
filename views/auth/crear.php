<div class="contenedor crear">
    <?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

        <?php include_once __DIR__ .'/../templates/alertas.php'; ?>

        <form class="formulario" method="POST" action="/crear">
            <div class="campo">
                <label for="usuario_nombre"> Nombre</label>
                <input 
                    type="text"
                    id="usuario_nombre"
                    placeholder="Tu Nombre"
                    name="usuario_nombre"
                    value="<?php  echo $usuario->usuario_nombre; ?>"
                />
            </div>

            <div class="campo">
                <label for="usuario_email">Email</label>
                <input 
                    type="email"
                    id="usuario_email"
                    placeholder="Tu Email"
                    name="usuario_email"
                    value="<?php  echo $usuario->usuario_email; ?>"
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

            <div class="campo">
                <label for="usuario_password2">Repetir Password</label>
                <input 
                    type="password"
                    id="usuario_password2"
                    placeholder="Repite tu Password"
                    name="usuario_password2"
                />
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/olvide">¿Olvidaste tu Password?</a>
        </div>
    </div> <!--.contenedor-sm -->
</div>