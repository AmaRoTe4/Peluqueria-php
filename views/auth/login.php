<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php foreach($errores as $err):?>
    <div class="message errores">
        <?php echo $err; ?>
    </div>
<?php endforeach?>

<form class="formulario" method="POST" action="/login">
    <div class="campo">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            placeholder="Tu Email"
            name="email"
            value="<?php echo s($usuario->email) ?>"
        />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            placeholder="Tu Password"
            name="password"
            value="<?php echo s($usuario->password) ?>"
        />
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/create">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/forgot">¿Olvidaste tu password?</a>
</div>