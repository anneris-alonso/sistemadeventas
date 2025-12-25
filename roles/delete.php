<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

$id_rol = $_GET['id'];
$id_negocios = $_SESSION['negocio_id'];

try {
    $sql_roles = "SELECT rol 
                   FROM tb_roles
                   WHERE id_rol = :id_rol
                   AND id_negocios = :id_negocios";

    $query_roles = $pdo->prepare($sql_roles);
    $query_roles->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
    $query_roles->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
    $query_roles->execute();
    $rol_datos = $query_roles->fetch(PDO::FETCH_ASSOC); // Fetch a single row

    if (!$rol_datos) {
        echo "Rol no encontrado o no pertenece a este negocio.";
        exit();
    }

    $rol_nombre = $rol_datos['rol'];

} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel"><?php echo __('confirm_deletion'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo __('confirm_delete_role_message'); ?> <strong><?php echo $rol_nombre; ?></strong>? Esta
                    acción no se puede deshacer.</p>
                <form action="../app/controllers/roles/delete_rol.php" method="post">
                    <input type="hidden" name="id_rol" value="<?php echo $id_rol; ?>">
                    <input type="hidden" name="id_negocios" value="<?php echo $id_negocios; ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal"><?php echo __('cancel'); ?></button>
                <button type="submit" class="btn btn-danger"><?php echo __('delete'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="content-wrapper"> </div>


<script>
    $(document).ready(function () {
        $('#confirmDeleteModal').modal('show');
    });
</script>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>