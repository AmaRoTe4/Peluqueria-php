<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>

<?php foreach($errores as $err):?>
    <div class="message errores">
        <?php echo $err; ?>
    </div>
<?php endforeach?>

<?php if(!$recover) return ?>

<form class="formulario" method="POST" action="/recover?token=<?php echo $token ?>">
    <div class="campo">
        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu Nuevo Password"
        />
    </div>
    <input type="submit" class="boton" value="Guardar Nuevo Password">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
    <a href="/create">¿Aún no tienes cuenta? Obtener una</a>
</div>