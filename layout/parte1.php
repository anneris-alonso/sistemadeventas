<?php
$URL = 'http://localhost/www.sistemadeventas.com'; // Or http://localhost/www.sistemadeventas.com
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de ventas</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <script src="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>

    <link rel="stylesheet" href="<?php echo $URL; ?>/public/style.css">
    <script>
        const globalURL = "<?php echo $URL; ?>"; // Use PHP to echo the URL
    </script>
    <script src="https://kit.fontawesome.com/5dd1f4223f.js" crossorigin="anonymous"></script>

    <style>
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color:rgb(8, 255, 82);
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1000; /* Ensure it's on top */
        }

        .floating-button i {
            font-size: 24px;
        }

        .messages-sidebar {
            position: fixed;
            top: 0;
            right: -500px; /* Inicialmente oculto */
            width: 500px;
            height: 100%;
            background-color: #f0f0f0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            transition: right 0.3s ease;
            z-index: 1001; /* Asegura que esté por encima del botón flotante */
            display: flex; /* Use flexbox */
            flex-direction: column; /* Stack items vertically */
        }

        .messages-sidebar.show {
            right: 0; /* Muestra la barra lateral */
        }

        .messages-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #ddd;
            flex-shrink: 0; /* Prevent header from shrinking */
        }

        .messages-header button {
            cursor: pointer;
        }

        #messages-list {
            padding: 0; /* Remove padding */
            flex-grow: 1; /* Allow messages-list to take up remaining space */
            overflow-y: auto; /* Add scrollbar if needed */
            height: 100%; /* Ensure it takes full height */
        }

        #messages-iframe {
            width: 480px; /* Take up full width of sidebar */
            height: 100%;
            border: none;
            background-color: transparent; /* Make the iframe background transparent */
            z-index: 100;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
        <a href="#" id="open-messages-sidebar" class="floating-button">
            <i class="fas fa-comment-dots"></i>
        </a>

        <aside class="messages-sidebar" id="messages-sidebar">
            <div class="messages-header">
                <h3>Gemini Chat</h3>
                <button id="close-messages-sidebar">X</button>
            </div>
            <div id="messages-list">
                <iframe id="messages-iframe" src="<?php echo $URL; ?>/messages/index.php"></iframe>
            </div>
        </aside>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messagesButton = document.getElementById('open-messages-sidebar');
            const messagesSidebar = document.getElementById('messages-sidebar');
            const closeMessagesButton = document.getElementById('close-messages-sidebar');

            messagesButton.addEventListener('click', function(event) {
                event.preventDefault();
                messagesSidebar.classList.add('show');
            });

            closeMessagesButton.addEventListener('click', function() {
                messagesSidebar.classList.remove('show');
            });
        });
    </script>

    <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars fa-lg"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav mr-auto d-flex justify-content-center w-100">
            <li class="nav-item">
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sl">
                        <input class="form-control form-control-navbar rounded-pill" type="search" placeholder="Buscar" aria-label="Buscar" style="background-color: white;">
                    </div>
                </form>
            </li>
        </ul>

    </nav>


    <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
        <ul class="navbar-nav mr-auto d-flex justify-content-center w-100">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $URL; ?>">
                    <i class="fas fa-home fa-lg"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $URL; ?>/clientes">
                    <i class="fas fa-user-plus fa-lg"></i>
                </a>
            </li>

            <?php
            // Obtener el nombre del rol a partir del ID del usuario y del ID del negocio
            try {
                $stmt = $pdo->prepare("SELECT r.rol 
                                FROM tb_roles r
                                INNER JOIN tb_usuarios u ON r.id_rol = u.id_rol
                                WHERE u.id_usuario = :id_usuario 
                                AND u.id_negocios = :id_negocios");
                $stmt->bindParam(':id_usuario', $id_usuario_sesion, PDO::PARAM_INT);
                $stmt->bindParam(':id_negocios', $_SESSION['negocio_id'], PDO::PARAM_INT);
                $stmt->execute();
                $rol_nombre = $stmt->fetchColumn();
            } catch (PDOException $e) {
                $rol_nombre = "Error al obtener el rol"; // Manejar el error de alguna manera
            }

            // Fetch permissions for the current user's role
            $stmt = $pdo->prepare("SELECT permission_name FROM tb_role_permissions WHERE id_rol = (SELECT id_rol FROM tb_usuarios WHERE id_usuario = :id_usuario)");
            $stmt->bindParam(':id_usuario', $id_usuario_sesion, PDO::PARAM_INT);
            $stmt->execute();
            $user_permissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

            function hasPermission($permission_name)
            {
                global $user_permissions;
                return in_array($permission_name, $user_permissions);
            }
?>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $URL; ?>/general">
                    <i class="fas fa-chart-line fa-lg"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $URL; ?>/almacen">
                    <i class="fas fa-warehouse fa-lg"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#notificationModal">
                    <i class="fas fa-bell fa-lg"></i>
                </a>
            </li>
        </ul>
    </nav>

    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notificaciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Aqui van las actualizaciones del sistema.<a href="<?php echo $URL; ?>/clientes/index.php" class="btn btn-primary">Ir</a></p>
                    <p>Aqui van las actualizaciones del sistema.</p>
                    <p>Aqui van las actualizaciones del sistema.</p>
                    <p>Aqui van las actualizaciones del sistema.</p>
                    <!-- You can add more content or dynamic notifications here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?php echo $URL; ?>" class="brand-link">
            <img src="<?php echo $URL; ?>/public/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">CTRV</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block text-white"><?php echo $nombres_sesion; ?></a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">



                    <?php if (hasPermission('usuarios')) : ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/usuarios" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Empleados</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('proveedores')) : ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/proveedores" class="nav-link">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>Proveedores</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('servicios')) : ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/servicios" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Servicios</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('servicios')) : ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/servicios" class="nav-link">
                                <i class="nav-icon fas fa-camera"></i>
                                <p>Proyectos</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('sugerencias')) : ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/sugerencias" class="nav-link">
                                <i class="nav-icon fas fa-comment"></i>
                                <p>Sugerencias</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('compras')) : ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    Finanzas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo $URL; ?>/cuentas_por_cobrar" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cuentas por cobrar</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $URL; ?>/cuentas_por_pagar" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cuentas por Pagar</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $URL; ?>/banco" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Banco</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $URL; ?>/general" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>General</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $URL; ?>/pagos" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Historial de Pagos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('clientes')) : ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/clientes" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('almacen')) : ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/almacen" class="nav-link">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>Almacen</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a href="<?php echo $URL; ?>/app/controllers/login/cerrar_sesion.php" class="nav-link bg-danger ">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Cerrar Sesión</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


    <script src="<?php echo $URL; ?>/js/chat.js"></script>
    <script src="<?php echo $URL; ?>/js/gemini.js"></script>
</body>
