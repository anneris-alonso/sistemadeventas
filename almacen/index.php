<?php
include_once __DIR__ . '/../app/config.php'; // Adjust path - __DIR__ is BEST
include_once __DIR__ . '/../layout/sesion.php'; // Includes session_start()

// *** CRITICAL: Login Check and Redirect ***
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$id_negocios = $_SESSION['negocio_id']; // Get id_negocios from session


include('../layout/parte1.php'); // Adjust path if needed

// *** Product Query (with JOIN for Category) ***
try {
    $sql_productos = "SELECT id_producto, nombre, codigo, id_categoria, imagen, descripcion, stock, stock_minimo, stock_maximo , precio_compra, precio_venta, fecha_ingreso, u.email
                  FROM tb_almacen p
                  INNER JOIN tb_usuarios u ON p.id_usuario = u.id_usuario
                  WHERE p.id_negocios = :id_negocios";
    $query_productos = $pdo->prepare($sql_productos);
    $query_productos->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
    $query_productos->execute();
    $productos_datos = $query_productos->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Database error fetching products (index.php): " . $e->getMessage());
    $productos_datos = []; // Set to an empty array on error
    $_SESSION['error_message'] = "An error occurred while fetching products. Please try again later.";
}

// *** User Query (Likely not needed, but I'm leaving it for consistency) ***
try {
    $sql_usuarios = "SELECT id_usuario, nombres FROM tb_usuarios WHERE id_negocios = :id_negocios";
    $query_usuarios = $pdo->prepare($sql_usuarios);
    $query_usuarios->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
    $query_usuarios->execute();
    $usuarios_datos = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Database error fetching users (index.php): " . $e->getMessage());
    $usuarios_datos = []; // Set to empty array
    // You probably don't need a separate error message for this
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('products_list'); ?>
                        <a href="create.php" class="btn btn-primary">
                            <i class="fa fa-plus"></i> <?php echo __('add_new'); ?>
                        </a>
                        <!-- New Button to Manage Categories -->
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#categoriesModal">
                            <i class="fa fa-list"></i> <?php echo __('manage_categories'); ?>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#registerLossModal"> <?php echo __('register_loss'); ?> </button>
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
                            <h3 class="card-title"><?php echo __('registered_products'); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th><?php echo __('number'); ?></th>
                                            <th><?php echo __('code'); ?></th>
                                            <th><?php echo __('category'); ?></th>
                                            <th><?php echo __('image'); ?></th>
                                            <th><?php echo __('name'); ?></th>
                                            <th><?php echo __('description'); ?></th>
                                            <th><?php echo __('stock'); ?></th>
                                            <th><?php echo __('purchase_price'); ?></th>
                                            <th><?php echo __('sale_price'); ?></th>
                                            <th><?php echo __('purchase_date'); ?></th>
                                            <th><?php echo __('user'); ?></th>
                                            <th><?php echo __('actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        if (empty($productos_datos)) {
                                            echo '<tr><td colspan="12">No products found for this business.</td></tr>';
                                        } else {
                                            foreach ($productos_datos as $productos_dato) {
                                                $id_producto = $productos_dato['id_producto'];
                                                ?>
                                                <tr>
                                                    <td><?php echo ++$contador; ?></td>
                                                    <td><?php echo htmlspecialchars($productos_dato['codigo']); ?></td>
                                                    <td><?php echo htmlspecialchars($productos_dato['id_categoria']); ?></td>
                                                    <td>
                                                        <img src="<?php echo $URL . "/almacen/img_productos/" . htmlspecialchars($productos_dato['imagen']); ?>"
                                                            width="50px" alt="Imagen del producto">
                                                    </td>
                                                    <td><?php echo htmlspecialchars($productos_dato['nombre']); ?></td>
                                                    <td><?php echo htmlspecialchars($productos_dato['descripcion']); ?></td>
                                                    <?php
                                                    $stock_actual = $productos_dato['stock'];
                                                    $stock_maximo = $productos_dato['stock_maximo'];
                                                    $stock_minimo = $productos_dato['stock_minimo'];
                                                    if ($stock_actual < $stock_minimo) { ?>
                                                        <td style="background-color: #ee868b">
                                                            <?php echo htmlspecialchars($productos_dato['stock']); ?></td>
                                                    <?php } else if ($stock_actual > $stock_maximo) { ?>
                                                            <td style="background-color: #8ac68d">
                                                            <?php echo htmlspecialchars($productos_dato['stock']); ?></td>
                                                    <?php } else { ?>
                                                            <td><?php echo htmlspecialchars($productos_dato['stock']); ?></td>
                                                    <?php } ?>
                                                    <td><?php echo htmlspecialchars($productos_dato['precio_compra']); ?></td>
                                                    <td><?php echo htmlspecialchars($productos_dato['precio_venta']); ?></td>
                                                    <td><?php echo htmlspecialchars($productos_dato['fecha_ingreso']); ?></td>
                                                    <td><?php echo htmlspecialchars($productos_dato['email']); ?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="show.php?id=<?php echo $id_producto; ?>" type="button"
                                                                class="btn btn-info btn-sm m-1"
                                                                title="<?php echo __('view_product'); ?>">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="update.php?id=<?php echo $id_producto; ?>" type="button"
                                                                class="btn btn-success btn-sm m-1"
                                                                title="<?php echo __('edit_product'); ?>">
                                                                <i class="fa fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="delete.php?id=<?php echo $id_producto; ?>" type="button"
                                                                class="btn btn-danger btn-sm m-1"
                                                                title="<?php echo __('delete_product'); ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>

    <div class="modal fade" id="categoriesModal" tabindex="-1" role="dialog" aria-labelledby="categoriesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoriesModalLabel"><?php echo __('manage_categories'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php include('../categorias/index.php'); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><?php echo __('close'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registerLossModal" tabindex="-1" role="dialog" aria-labelledby="registerLossModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerLossModalLabel"><?php echo __('register_product_loss'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../app/controllers/perdidas/create.php" method="post">

                        <div class="form-group">
                            <label for="id_producto"><?php echo __('product'); ?>:</label>
                            <select class="form-control" id="id_producto" name="id_producto" required>
                                <option value=""><?php echo __('select_product'); ?></option>
                                <?php foreach ($productos_datos as $producto): ?>
                                    <option value="<?php echo $producto['id_producto']; ?>" <?php
                                       // Repopulate selected product on error
                                       if (isset($_SESSION['form_data']['id_producto']) && $_SESSION['form_data']['id_producto'] == $producto['id_producto']) {
                                           echo 'selected';
                                       }
                                       ?>>
                                        <?php echo htmlspecialchars($producto['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="motivo_baja"><?php echo __('reason'); ?>:</label>
                            <textarea class="form-control" id="motivo_baja" name="motivo_baja" rows="3"
                                required><?php echo isset($_SESSION['form_data']['motivo_baja']) ? htmlspecialchars($_SESSION['form_data']['motivo_baja']) : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="fecha_baja"><?php echo __('date'); ?>:</label>
                            <input type="date" class="form-control" id="fecha_baja" name="fecha_baja" required
                                value="<?php echo isset($_SESSION['form_data']['fecha_baja']) ? htmlspecialchars($_SESSION['form_data']['fecha_baja']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="cantidad"><?php echo __('quantity'); ?>:</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required
                                value="<?php echo isset($_SESSION['form_data']['cantidad']) ? htmlspecialchars($_SESSION['form_data']['cantidad']) : '1'; ?>">
                        </div>

                        <input type="submit" value="<?php echo __('register_loss'); ?>" class="btn btn-primary">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><?php echo __('close'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Display success message
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
        unset($_SESSION['success_message']); // Clear the message
    }

    // Display error message
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
        unset($_SESSION['error_message']); // Clear the message
    }

    // Display validation errors:
    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
        echo '<div class="alert alert-danger"><ul>';
        foreach ($_SESSION['errors'] as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul></div>';
        unset($_SESSION['errors']); // Clear errors
    }
    ?>

    <script>
        $(document).ready(function () {
            // Check if there are any error messages displayed
            if ($('.alert-danger').length > 0) {
                // Re-open the modal
                $('#registerLossModal').modal('show');  // Corrected modal ID
            }
        });
        $(document).ready(function () {
            $('#categoriesModal').on('hidden.bs.modal', function (e) {
                location.reload();
            });
        });
    </script>

    <?php
    include('../layout/mensajes.php');  // Include message handling (if separate)
    include('../layout/parte2.php');
    ?>
    <script>
        $(function () {
            $("#example1").DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "<?php echo __('no_data_available'); ?>",
                    "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('products'); ?>",
                    "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                    "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('products'); ?>)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('products'); ?>",
                    "loadingRecords": "<?php echo __('loading'); ?>...",
                    "processing": "<?php echo __('processing'); ?>...",
                    "search": "<?php echo __('search'); ?>:",
                    "zeroRecords": "<?php echo __('no_results_found'); ?>",
                    "paginate": {
                        "first": "<?php echo __('first'); ?>",
                        "last": "<?php echo __('last'); ?>",
                        "next": "<?php echo __('next'); ?>",
                        "previous": "<?php echo __('previous'); ?>"
                    }
                },
                "responsive": true, "lengthChange": true, "autoWidth": false,
                buttons: [{
                    extend: 'collection',
                    text: '<?php echo __('reports'); ?>',
                    orientation: 'landscape',
                    buttons: [{
                        text: '<?php echo __('copy'); ?>',
                        extend: 'copy',
                    }, {
                        extend: 'pdf'
                    }, {
                        extend: 'csv'
                    }, {
                        extend: 'excel'
                    }, {
                        text: '<?php echo __('print'); ?>',
                        extend: 'print'
                    }]
                },
                {
                    extend: 'colvis',
                    text: '<?php echo __('column_visibility'); ?>',
                    collectionLayout: 'fixed three-column'
                }
                ],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>