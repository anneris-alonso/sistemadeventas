<?php
?>

<div class="row">
    <div class="col-md-12">
        <div id="respuesta_registro_categoria">

        </div>
        <form action="../app/controllers/categorias/registro_de_categorias.php" method="post" id="form_create_categoria">
            <div class="form-group">
                <label for="nombre_categoria">Nombre de la categoría</label>
                <input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control" placeholder="Escriba aquí la categoría..." required>
                <span class="text-danger" id="error-nombre_categoria"></span>
            </div>
            <hr>
            <div class="form-group">
                <button type="button" id="btn_cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_create_categoria" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#btn_create_categoria').click(function() {
        var url = '../app/controllers/categorias/registro_de_categorias.php';
        var data = $('#form_create_categoria').serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(datos) {
                $('#respuesta_registro_categoria').html(datos);
                $('#nombre_categoria').val('');
            }
        });
    });

    $('#btn_cancelar').click(function() {
        $('#respuesta_registro_categoria').empty();
    });
</script>
