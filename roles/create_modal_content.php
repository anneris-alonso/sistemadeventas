<?php
?>
<div class="row">
    <div class="col-md-12">
        <div id="respuesta_registro_rol">

        </div>
        <form action="../app/controllers/roles/create.php" method="post" id="form_create_rol">
            <div class="form-group">
                <label for="">Nombre del Rol</label>
                <input type="text" name="rol" id="rol" class="form-control" placeholder="Escriba aquí el rol..." required>
            </div>
            <div class="form-group">
                <label for="">Permisos</label><br>
                <input type="checkbox" name="permissions[]" value="clientes"> Clientes<br>
                <input type="checkbox" name="permissions[]" value="compras"> Finanzas<br>
                <input type="checkbox" name="permissions[]" value="almacen"> Almacen<br>
                <input type="checkbox" name="permissions[]" value="proveedores"> Proveedores<br>
                <input type="checkbox" name="permissions[]" value="servicios"> Servicios<br>
                <input type="checkbox" name="permissions[]" value="sugerencias"> Sugerencias<br>
                <input type="checkbox" name="permissions[]" value="usuarios"> Usuarios<br>
                <input type="checkbox" name="permissions[]" value="roles"> Roles<br>
                <input type="checkbox" name="permissions[]" value="categorias"> Categorías<br>
                <input type="checkbox" name="permissions[]" value="perdidas"> Pérdidas<br>
                <!-- ...No se muestran...-->
                <input type="checkbox" name="permissions[]" value="inversiones"> Inversiones<br>
                <!-- ...No se muestran...-->
            </div>
            <hr>
            <div class="form-group">
                <button type="button" id="btn_cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_create_rol" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#btn_create_rol').click(function() {
        var url = '../app/controllers/roles/create.php';
        var data = $('#form_create_rol').serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(datos) {
                $('#respuesta_registro_rol').html(datos);
                $('#rol').val('');
            }
        });
    });

    $('#btn_cancelar').click(function() {
        $('#respuesta_registro_rol').empty();
    });
</script>
