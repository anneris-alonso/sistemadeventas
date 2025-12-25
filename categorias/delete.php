<?php
include ('../app/config.php');
include ('../layout/sesion.php');
include ('../layout/parte1.php');

$id_categoria = $_GET['id'];  // Get the category ID from the URL
$id_negocios = $_SESSION['negocio_id'];

try {
    $sql_categoria = "SELECT nombre_categoria 
                       FROM tb_categorias
                       WHERE id_categoria = :id_categoria
                       AND id_negocios = :id_negocios"; // Always include business ID

    $query_categoria = $pdo->prepare($sql_categoria);
    $query_categoria->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
    $query_categoria->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
    $query_categoria->execute();
    $categoria_datos = $query_categoria->fetch(PDO::FETCH_ASSOC);

    if (!$categoria_datos) {
        echo "Categoría no encontrada o no pertenece a este negocio.";
        exit();
    }

    $nombre_categoria = $categoria_datos['nombre_categoria'];

} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}

?>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que deseas eliminar la categoría <strong><?php echo $nombre_categoria; ?></strong>? Esta acción no se puede deshacer.</p>
                <form action="../app/controllers/categorias/delete_categoria.php" method="post">
                    <input type="hidden" name="id_categoria" value="<?php echo $id_categoria; ?>">
                    <input type="hidden" name="id_negocios" value="<?php echo $id_negocios; ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
                </form> </div> </div> </div> </div>



<div class="content-wrapper">  </div> <!-- The content-wrapper for your layout -->

<script>
    $(document).ready(function() {
        $('#confirmDeleteModal').modal('show');
    });
</script>

<?php 
include ('../layout/mensajes.php'); 
include ('../layout/parte2.php'); 
?>
