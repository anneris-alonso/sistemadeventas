<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include('../app/controllers/clientes/client_list.php');

// Helper function to fetch service name
function obtenerNombreServicio($id_servicios, $pdo) {
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

function obtenerPrecioFinalServicio($id_servicios, $pdo) {
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

<input type="hidden" id="id_negocios_hidden" value="<?php echo $_SESSION['negocio_id'];?>">
<script src="clientes.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"></script>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="d-flex justify-content-between align-items-center">Listado de Clientes
                        <a href="create.php" class="btn btn-primary mr-1">
                            <i class="fa fa-plus"></i> Agregar Nuevo
                        </a>
                        <div class="d-flex justify-content-center">
                            <button id="btnVistaBasica" class="btn btn-primary mr-1">Vista Básica</button>
                            <button id="btnVistaCompleta" class="btn btn-secondary">Vista Completa</button>
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
                            <h3 class="card-title">Clientes registrados</h3>
                        </div>
                        <div class="card-body" style="display: block;">
                           <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nro</th>
                                            <th>Foto</th>
                                            <th>Nombre</th>
                                            <th class="columna-ocultable">Teléfono</th>
                                            <th class="columna-ocultable">Email</th>
                                            <th>Servicio</th>
                                            <th class="columna-ocultable">Total a Pagar</th>
                                            <th class="columna-ocultable">Fecha Inicio Trámite</th>
                                            <th class="columna-ocultable">Fecha Fin Trámite</th>
                                            <th>Acciones</th>
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
                                        <tr data-cliente-id="<?php echo $cliente['id_clients'];?>">
                                            <td><?php echo ++$contador;?></td>
                                            <td><img src="<?php echo $URL. "/clientes/image_clt/". $cliente['image_clt'];?>" width="50px" alt="foto cliente"></td>
                                            <td data-column-name="nombre_clt"><?php echo $cliente['nombre_clt'];?></td>
                                            <td class="columna-ocultable" data-column-name="telefono_clt"><?php echo $cliente['telefono_clt'];?></td>
                                            <td class="columna-ocultable" data-column-name="mail_clt"><?php echo $cliente['mail_clt'];?></td>
                                            <td data-column-name="servicio"><?php echo $nombreServicio['servicio']. ' - '. $nombreServicio['tipo'];?></td>
                                            <td class="columna-ocultable" data-column-name="total_a_pagar"><?php echo $precioFinal; ?></td>
                                            <td class="columna-ocultable" data-column-name="fecha_ini_tramite"><?php echo $cliente['fecha_ini_tramite'];?></td>
                                            <td class="columna-ocultable" data-column-name="fecha_fin_tramite"><?php echo $cliente['fecha_fin_tramite'];?></td>
                                            <td>
                                            <div class="btn-group">
                                                <a href="update.php?id=<?php echo $id_clients; ?>" type="button" class="btn btn-success btn-sm m-1" title="Editar Cliente">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                                <a data-toggle="modal" data-target="#modal-detalle-<?php echo $id_clients;?>" type="button" class="btn btn-info btn-sm m-1" title="Detalles del Cliente">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="delete.php?id=<?php echo $id_clients; ?>" type="button" class="btn btn-danger btn-sm m-1" title="Eliminar Cliente" onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente?')">
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
                                        <i class="fas fa-user mr-2"></i> Detalles del Cliente
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p><strong>Nombre:</strong> <?php echo $cliente['nombre_clt']; ?></p>
                                                <p><strong>Dirección:</strong> <?php echo $cliente['direccion_clt']; ?></p>
                                                <p><strong>Nacionalidad:</strong> <?php echo $cliente['nacionalidad_clt']; ?></p>
                                                <p><strong>Ciudadanía:</strong> <?php echo $cliente['ciudadania_clt']; ?></p>
                                                <p><strong>Pasaporte:</strong> <?php echo $cliente['pasaporte_clt']; ?></p>
                                                <p><strong>Fecha Venc. Pasaporte:</strong> <?php echo $cliente['fecha_venc_pass_clt']; ?></p>                                            
                                                <p><strong>Estado Civil:</strong> <?php echo $cliente['est_civil_clt']; ?></p>
                                                <p><strong>Fecha Nacimiento:</strong> <?php echo $cliente['fecha_nac_clt']; ?></p>
                                                <p><strong>Teléfono:</strong> <?php echo $cliente['telefono_clt']; ?></p>
                                                <p><strong>Email:</strong> <?php echo $cliente['mail_clt']; ?></p>
                                                <p><strong>Servicio:</strong> <?php echo $nombreServicio['servicio'] . ' - ' . $nombreServicio['tipo']; ?></p>
                                                <p><strong>Fecha Inicio Trámite:</strong> <?php echo $cliente['fecha_ini_tramite']; ?></p>
                                                <p><strong>Fecha Fin Trámite:</strong> <?php echo $cliente['fecha_fin_tramite']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
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


<?php include('../layout/mensajes.php');?>
<?php include('../layout/parte2.php');?>