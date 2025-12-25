<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include('../app/controllers/clientes/client_list.php');

// Helper function to fetch service name
function obtenerNombreServicio($id_servicios, $pdo)
{
    try {
        $sentencia = $pdo->prepare("SELECT id_servicios, servicio, tipo FROM tb_servicios WHERE id_servicios = :id_servicios");
        $sentencia->bindParam(':id_servicios', $id_servicios, PDO::PARAM_INT);
        if ($sentencia->execute()) {
            $servicio = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $servicio ? $servicio : ["id_servicios" => null, "servicio" => "Servicio Desconocido", "tipo" => ""];
        } else {
            return ["id_servicios" => null, "servicio" => "Error en la consulta del servicio.", "tipo" => ""];
        }
    } catch (PDOException $e) {
        return ["id_servicios" => null, "servicio" => "Error de base de datos al obtener el nombre del servicio", "tipo" => ""];
    }
}

function obtenerPrecioFinalServicio($id_servicios, $pdo)
{
    try {
        $sentencia = $pdo->prepare("SELECT precio_final FROM tb_servicios WHERE id_servicios = :id_servicios");
        $sentencia->bindParam(':id_servicios', $id_servicios, PDO::PARAM_INT);
        if ($sentencia->execute()) {
            $servicio = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $servicio ? $servicio['precio_final'] : 0; // Return 0 if no price is found
        } else {
            return 0; // Return 0 if query fails
        }
    } catch (PDOException $e) {
        return 0; // Return 0 on error
    }
}

// Fetch services for dropdown
$servicios_datos = $pdo->query("SELECT id_servicios, servicio FROM tb_servicios")->fetchAll(PDO::FETCH_ASSOC);
?>

<input type="hidden" id="id_negocios_hidden" value="<?php echo $_SESSION['negocio_id']; ?>">
<script>
    var dt_languages = {
        "colvis": "<?php echo __('column_visibility'); ?>",
        "state_updated_successfully": "<?php echo __('state_updated_successfully'); ?>",
        "service_details_id": "<?php echo __('service_details_id'); ?>",
        "error": "<?php echo __('error'); ?>",
        "emptyTable": "<?php echo __('no_data_available'); ?>",
        "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('clients'); ?>",
        "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
        "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('clients'); ?>)",
        "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('clients'); ?>",
        "loadingRecords": "<?php echo __('loading'); ?>...",
        "processing": "<?php echo __('processing'); ?>...",
        "search": "<?php echo __('search'); ?>:",
        "zeroRecords": "<?php echo __('no_results_found'); ?>",
        "first": "<?php echo __('first'); ?>",
        "last": "<?php echo __('last'); ?>",
        "next": "<?php echo __('next'); ?>",
        "previous": "<?php echo __('previous'); ?>"
    };
</script>
<script src="clientes.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"></script>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="d-flex justify-content-between align-items-center"><?php echo __('clients_list'); ?>
                        <a href="create.php" class="btn btn-primary mr-1">
                            <i class="fa fa-plus"></i> <?php echo __('add_new'); ?>
                        </a>
                        <div class="d-flex justify-content-center">
                            <button id="btnVistaBasica"
                                class="btn btn-primary mr-1"><?php echo __('basic_view'); ?></button>
                            <button id="btnVistaCompleta"
                                class="btn btn-secondary"><?php echo __('full_view'); ?></button>
                        </div>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('registered_clients'); ?></h3>
                        </div>
                        <div class="card-body" style="display: block;">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th><?php echo __('number'); ?></th>
                                            <th><?php echo __('photo'); ?></th>
                                            <th><?php echo __('name'); ?></th>
                                            <th class="columna-ocultable"><?php echo __('phone'); ?></th>
                                            <th class="columna-ocultable"><?php echo __('email'); ?></th>
                                            <th><?php echo __('service'); ?></th>
                                            <th class="columna-ocultable"><?php echo __('total_to_pay'); ?></th>
                                            <th class="columna-ocultable"><?php echo __('start_date_procedure'); ?></th>
                                            <th class="columna-ocultable"><?php echo __('end_date_procedure'); ?></th>
                                            <th><?php echo __('actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($clients_datos as $cliente):
                                            $id_clients = $cliente['id_clients'];
                                            $servicioId = $cliente['id_servicios'];
                                            $nombreServicio = obtenerNombreServicio($servicioId, $pdo);
                                            $precioFinal = obtenerPrecioFinalServicio($servicioId, $pdo); //Get price
                                            ?>
                                            <tr data-cliente-id="<?php echo $cliente['id_clients']; ?>">
                                                <td><?php echo ++$contador; ?></td>
                                                <td><img src="<?php echo $URL . "/clientes/image_clt/" . $cliente['image_clt']; ?>"
                                                        width="50px" alt="foto cliente"></td>
                                                <td data-column-name="nombre_clt"><?php echo $cliente['nombre_clt']; ?></td>
                                                <td class="columna-ocultable" data-column-name="telefono_clt">
                                                    <?php echo $cliente['telefono_clt']; ?>
                                                </td>
                                                <td class="columna-ocultable" data-column-name="mail_clt">
                                                    <?php echo $cliente['mail_clt']; ?>
                                                </td>
                                                <td data-column-name="servicio">
                                                    <?php echo $nombreServicio['servicio'] . ' - ' . $nombreServicio['tipo']; ?>
                                                </td>
                                                <td class="columna-ocultable" data-column-name="total_a_pagar">
                                                    <?php echo $precioFinal; ?>
                                                </td>
                                                <td class="columna-ocultable" data-column-name="fecha_ini_tramite">
                                                    <?php echo $cliente['fecha_ini_tramite']; ?>
                                                </td>
                                                <td class="columna-ocultable" data-column-name="fecha_fin_tramite">
                                                    <?php echo $cliente['fecha_fin_tramite']; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="update.php?id=<?php echo $id_clients; ?>" type="button"
                                                            class="btn btn-success btn-sm m-1"
                                                            title="<?php echo __('edit_client'); ?>">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <a data-toggle="modal"
                                                            data-target="#modal-detalle-<?php echo $id_clients; ?>"
                                                            type="button" class="btn btn-info btn-sm m-1"
                                                            title="<?php echo __('client_details'); ?>">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="delete.php?id=<?php echo $id_clients; ?>" type="button"
                                                            class="btn btn-danger btn-sm m-1"
                                                            title="<?php echo __('delete_client'); ?>"
                                                            onclick="return confirm('<?php echo __('confirm_delete_client'); ?>')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-detalle-<?php echo $id_clients; ?>">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded shadow">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-user mr-2"></i> <?php echo __('client_details'); ?>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p><strong><?php echo __('name'); ?>:</strong> <?php echo $cliente['nombre_clt']; ?>
                                        </p>
                                        <p><strong><?php echo __('address'); ?>:</strong>
                                            <?php echo $cliente['direccion_clt']; ?></p>
                                        <p><strong><?php echo __('nationality'); ?>:</strong>
                                            <?php echo $cliente['nacionalidad_clt']; ?></p>
                                        <p><strong><?php echo __('citizenship'); ?>:</strong>
                                            <?php echo $cliente['ciudadania_clt']; ?></p>
                                        <p><strong><?php echo __('passport'); ?>:</strong>
                                            <?php echo $cliente['pasaporte_clt']; ?></p>
                                        <p><strong><?php echo __('passport_expiry_date'); ?>:</strong>
                                            <?php echo $cliente['fecha_venc_pass_clt']; ?></p>
                                        <p><strong><?php echo __('civil_status'); ?>:</strong>
                                            <?php echo $cliente['est_civil_clt']; ?></p>
                                        <p><strong><?php echo __('birth_date'); ?>:</strong>
                                            <?php echo $cliente['fecha_nac_clt']; ?></p>
                                        <p><strong><?php echo __('phone'); ?>:</strong>
                                            <?php echo $cliente['telefono_clt']; ?></p>
                                        <p><strong><?php echo __('email'); ?>:</strong> <?php echo $cliente['mail_clt']; ?>
                                        </p>
                                        <p><strong><?php echo __('service'); ?>:</strong>
                                            <?php echo $nombreServicio['servicio'] . ' - ' . $nombreServicio['tipo']; ?></p>
                                        <p><strong><?php echo __('start_date_procedure'); ?>:</strong>
                                            <?php echo $cliente['fecha_ini_tramite']; ?></p>
                                        <p><strong><?php echo __('end_date_procedure'); ?>:</strong>
                                            <?php echo $cliente['fecha_fin_tramite']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo __('close'); ?></button>
                        </div>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>


<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>