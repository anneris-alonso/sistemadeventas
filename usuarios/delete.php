<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

$id_usuario = $_GET['id'];
$id_negocios = $_SESSION['negocio_id'];

try {
    $sql_usuarios = "SELECT id_usuario, nombres, email, rol 
                    FROM tb_usuarios 
                    INNER JOIN tb_roles ON tb_usuarios.id_rol = tb_roles.id_rol 
                    WHERE tb_usuarios.id_usuario =:id_usuario 
                    AND tb_usuarios.id_negocios =:id_negocios";

    $query_usuarios = $pdo->prepare($sql_usuarios);
    $query_usuarios->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $query_usuarios->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
    $query_usuarios->execute();
    $usuarios_datos = $query_usuarios->fetch(PDO::FETCH_ASSOC);

    if (!$usuarios_datos) {
        echo "Usuario no encontrado o no pertenece a este negocio.";
        exit();
    }

    $nombres = $usuarios_datos['nombres'];
    $email = $usuarios_datos['email'];
    $rol = $usuarios_datos['rol'];

} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
} ?>

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
                <p><?php echo __('confirm_delete_message'); ?> <strong><?php echo $nombres; ?></strong>? Esta acción no
                    se puede deshacer.</p>

                <form action="../app/controllers/usuarios/delete_usuario.php" method="post">
                    <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
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