<?php
// cuentas_por_pagar/update.php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Include the listado_de_proveedores.php file
include('../app/controllers/proveedores/listado_de_proveedores.php');
include('../app/controllers/cuentas_por_pagar/cargar_cuenta.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('update_account_payable'); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('update_data_carefully'); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="../app/controllers/cuentas_por_pagar/update.php" method="post">
                                <input type="hidden" name="id_cuentas_pagar" value="<?php echo $id_cuentas_pagar; ?>">
                                <div class="form-group">
                                    <label for="id_proveedor"><?php echo __('provider'); ?>:</label>
                                    <select name="id_proveedor" id="id_proveedor" class="form-control" required>
                                        <option value=""><?php echo __('select_provider'); ?></option>
                                        <?php foreach ($proveedores_datos as $proveedor): ?>
                                            <option value="<?= $proveedor['id_proveedor'] ?>" <?php if ($id_proveedor == $proveedor['id_proveedor']) {
                                                 echo "selected";
                                             } ?>>
                                                <?= $proveedor['nombre_proveedor'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="numero_factura"><?php echo __('invoice_number'); ?>:</label>
                                    <input type="text" name="numero_factura" id="numero_factura" class="form-control"
                                        value="<?= $numero_factura ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_emision"><?php echo __('issue_date'); ?>:</label>
                                    <input type="date" name="fecha_emision" id="fecha_emision" class="form-control"
                                        value="<?= $fecha_emision ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_vencimiento"><?php echo __('due_date'); ?>:</label>
                                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"
                                        class="form-control" value="<?= $fecha_vencimiento ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="monto_total"><?php echo __('total_amount'); ?>:</label>
                                    <input type="number" name="monto_total" id="monto_total" step="0.01"
                                        class="form-control" value="<?= $monto_total ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="saldo_pendiente"><?php echo __('pending_balance'); ?>:</label>
                                    <input type="number" name="saldo_pendiente" id="saldo_pendiente" step="0.01"
                                        class="form-control" value="<?= $saldo_pendiente ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="estado"><?php echo __('status'); ?>:</label>
                                    <select name="estado" id="estado" class="form-control" required>
                                        <option value="pendiente" <?php if ($estado == "pendiente") {
                                            echo "selected";
                                        } ?>>
                                            <?php echo __('pending'); ?></option>
                                        <option value="parcialmente pagado" <?php if ($estado == "parcialmente pagado") {
                                            echo "selected";
                                        } ?>><?php echo __('partially_paid'); ?></option>
                                        <option value="pagado" <?php if ($estado == "pagado") {
                                            echo "selected";
                                        } ?>>
                                            <?php echo __('paid'); ?></option>
                                    </select>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <a href="index.php" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
                                    <button type="submit" class="btn btn-primary"><?php echo __('update'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>