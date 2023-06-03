<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<div id="app">
    <nav class="tabs">
        <button type="button" data-paso="1">
            Servicios
        </button>

        <button type="button" data-paso="2">
            Tus datos y citas
        </button>

        <button type="button" data-paso="3">
            Resumen
        </button>
    </nav>
    <div class="seccion" id="paso-1">
        <h2>Servicios</h2>
        <p>Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div class="seccion" id="paso-2">
        <h2>Tus datos y cita</h2>
        <p>coloca tus datos y fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input disbled id="nombre" type="text" placeholder="Tu Nombre" value="<?php echo $nombre ?>" />
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input id="fecha" type="date" />
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input id="hora" type="time" />
            </div>

        </form>
    </div>
    <div class="seccion" id="paso-3">
        <h2>Resumen</h2>
        <p>Verifica que la info se correcta</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton" >
            &laquo; Anterior
        </button>
        <button id="siguiente" class="boton" >
            Siguiente &raquo;
        </button>
    </div>
</div>

<?php 
    $script = "script
        <script src='build/js/app.js'>
        </script>
    ";
?>