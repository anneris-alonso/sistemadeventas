$(document).ready(function () {

    var table = $('#example1').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "language": {
            "emptyTable": dt_languages.emptyTable,
            "info": dt_languages.info,
            "infoEmpty": dt_languages.infoEmpty,
            "infoFiltered": dt_languages.infoFiltered,
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": dt_languages.lengthMenu,
            "loadingRecords": dt_languages.loadingRecords,
            "processing": dt_languages.processing,
            "search": dt_languages.search,
            "zeroRecords": dt_languages.zeroRecords,
            "paginate": {
                "first": dt_languages.first,
                "last": dt_languages.last,
                "next": dt_languages.next,
                "previous": dt_languages.previous
            },
            "buttons": {
                "colvis": dt_languages.colvis
            }
        }
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    var idNegocio = $('#id_negocios_hidden').val();



    $('.cambiar-estado').on('change', function () {
        var originalValue = $(this).closest('tr').find('td[data-column-name="status_clt"]').text();
        var precioFinal = parseFloat($(this).data('precio-final'));

        $(this).next('.actualizar-estado').show().data('original-value', originalValue);

        if (nuevoEstado === "Pago") {
            row.find('td[data-column-name="total_a_pagar"]').text("0");
        } else {
            row.find('td[data-column-name="total_a_pagar"]').text(precioFinal);
        }



    });

    $(document).on('click', '.actualizar-estado', function () {
        var row = $(this).closest('tr');
        var clienteId = $(this).data('cliente-id');
        var nuevoEstado = $(this).prev('.cambiar-estado').val();

        var originalValue = $(this).data('original-value');

        var precioFinal = parseFloat(row.find('select.cambiar-estado').data('precio-final'));

        if (nuevoEstado === "Pago") {
            precioFinal = 0;
        }


        $.ajax({
            url: '../app/controllers/clientes/update_status.php',
            type: 'POST',
            data: {
                id_clients: clienteId,
                status_clt: nuevoEstado,
                id_negocios: idNegocio,
                precio_final: precioFinal
            },
            success: function (response) {
                console.log("Server Response:", response);


                if (response.includes("Estado actualizado correctamente.")) {
                    alert(dt_languages.state_updated_successfully);

                    row.find('td[data-column-name="status_clt"]').text(nuevoEstado);



                    var table = row.closest('table.dataTable').DataTable();
                    row.find('td[data-column-name="status_clt"]').text(nuevoEstado);

                    table.rows().invalidate().draw(false);

                    $('.actualizar-estado[data-cliente-id="' + clienteId + '"]').hide();

                } else {
                    alert(dt_languages.error + ": " + response);
                }


            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Error updating status: " + xhr.responseText);
            }
        });
    });


    $("#btnVistaBasica").click(function () {
        $(".columna-ocultable").hide();
        if ($(this).hasClass('btn-primary') && $("#btnVistaCompleta").hasClass('btn-secondary')) {
            $(this).removeClass('btn-primary').addClass('btn-secondary');
            $("#btnVistaCompleta").removeClass('btn-secondary').addClass('btn-primary');
        } else if ($(this).hasClass('btn-secondary') && $("#btnVistaCompleta").hasClass('btn-primary')) {
            $(this).removeClass('btn-secondary').addClass('btn-primary');
            $("#btnVistaCompleta").removeClass('btn-primary').addClass('btn-secondary');
        }
    });

    $("#btnVistaCompleta").click(function () {
        $(".columna-ocultable").show();
        if ($(this).hasClass('btn-primary') && $("#btnVistaBasica").hasClass('btn-secondary')) {
            $(this).removeClass('btn-primary').addClass('btn-secondary');
            $("#btnVistaBasica").removeClass('btn-secondary').addClass('btn-primary');
        } else if ($(this).hasClass('btn-secondary') && $("#btnVistaBasica").hasClass('btn-primary')) {
            $(this).removeClass('btn-secondary').addClass('btn-primary');
            $("#btnVistaBasica").removeClass('btn-primary').addClass('btn-secondary');
        }
    });
    // Mostrar detalles del servicio al hacer clic en el botón "Detalles"
    $(document).on('click', '.ver-detalles-servicio', function (event) {
        event.preventDefault();
        var servicioId = $(this).data('servicio-id');

        // Aquí debes implementar la lógica para mostrar los detalles del servicio
        // Puedes usar AJAX para obtener los detalles del servidor o mostrar un modal con la información
        alert(dt_languages.service_details_id + servicioId);
    });

    // Ocultar columnas de la vista básica al cargar la página
    $(".columna-ocultable").hide();

    // En el evento submit del formulario del cliente
    $("#clienteForm").submit(function (event) {
        event.preventDefault();

        // Guardar los datos del formulario en localStorage
        var nombreCliente = $("#nombre_clt").val();
        var telefonoCliente = $("#telefono_clt").val();
        var mailCliente = $("#mail_clt").val();
        // ... guardar otros datos del formulario ...
        localStorage.setItem("nombreCliente", nombreCliente);
        localStorage.setItem("telefonoCliente", telefonoCliente);
        localStorage.setItem("mailCliente", mailCliente);
        // ... guardar otros datos del formulario ...

        // Enviar el formulario mediante AJAX
        var formData = $(this).serialize();

        $.ajax({
            url: "/clientes/app/controllers/clientes/create.php",
            type: "POST",
            data: formData,
            success: function (response) {
                // Manejar la respuesta del servidor (mostrar mensaje de éxito, redirigir, etc.)
            }
        });
    });

    // En el evento hidden.bs.modal del modal
    $("#modal-create").on("hidden.bs.modal", function () {
        // Recuperar los datos del formulario de localStorage
        var nombreCliente = localStorage.getItem("nombreCliente");
        var telefonoCliente = localStorage.getItem("telefonoCliente");
        var mailCliente = localStorage.getItem("mailCliente");
        // ... recuperar otros datos del formulario ...

        // Rellenar el formulario del cliente
        $("#nombre_clt").val(nombreCliente);
        $("#telefono_clt").val(telefonoCliente);
        $("#mail_clt").val(mailCliente);
        // ... rellenar otros datos del formulario ...

        // Limpiar localStorage
        localStorage.removeItem("nombreCliente");
        localStorage.removeItem("telefonoCliente");
        localStorage.removeItem("mailCliente");
        // ... limpiar otros datos del formulario ...
    });
});