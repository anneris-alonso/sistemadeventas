<?php
// app/controllers/pagos/listado_de_pagos.php

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validate the business ID
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"];
} else {
    // Handle the error if the business ID is invalid
    die("Error: ID de negocio inválido.");
}

try {
    $sql_pagos = "SELECT 
                        p.*,
                        CASE
                          WHEN p.tipo_cuenta = 'cobrar' THEN cl.nombre_clt
                          WHEN p.tipo_cuenta = 'pagar' THEN pr.nombre_proveedor
                          ELSE ''
                        END AS cuenta,
                        cc.id_cuentas_por_cobrar as id_cuenta_cobrar,
                        cp.id_cuentas_por_pagar as id_cuenta_pagar
                    FROM 
                        tb_pagos p
                    LEFT JOIN tb_cuentas_por_cobrar cc ON p.id_cuenta = cc.id_cuentas_por_cobrar AND p.tipo_cuenta = 'cobrar'
                    LEFT JOIN tb_clients cl ON cc.id_clients = cl.id_clients
                    LEFT JOIN cuentas_por_pagar cp ON p.id_cuenta = cp.id_cuentas_por_pagar AND p.tipo_cuenta = 'pagar'
                    LEFT JOIN tb_proveedores pr ON cp.id_proveedor = pr.id_proveedor
                    WHERE 
                        p.id_negocios = :id_negocios
                    ORDER BY
                        p.fyh_creacion DESC;
                    ";


    $query_pagos = $pdo->prepare($sql_pagos);
    $query_pagos->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
    $query_pagos->execute();
    $pagos_datos = $query_pagos->fetchAll(PDO::FETCH_ASSOC);

    if (empty($pagos_datos)) {
        echo "No se encontraron pagos";
    }
} catch (PDOException $e) {
    // Handle the query error
    die("Error en la consulta: " . $e->getMessage());
}
?>
