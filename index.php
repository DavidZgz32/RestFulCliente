<?php
$curl = curl_init();
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


$listaProductos = muestraProductos($curl);

if (isset($_POST['opciones'])) {

    switch ($_POST['opciones']) {
        case 'Listar Producto':
            $cod = $_POST['codigos'];
            curl_setopt($curl, CURLOPT_URL, "http://localhost/Practica_RestFullServer/productos/$cod");
            $product = curl_exec($curl);
            $producto = json_decode($product, TRUE);
            break;
        case 'Listar Productos':

            $respuesta = muestraProductos($curl);
            break;
        case 'Borrar':
            $delete = array(0 => $_POST['cod']);

            curl_setopt($curl, CURLOPT_URL, "http://localhost/Practica_RestFullServer/index.php");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($delete));
            $mensajeAct = curl_exec($curl);
            $listaProductos = muestraProductos($curl);
            break;
        case 'Insertar':
            $datos = [$_POST['cod'],$_POST['nombre'], $_POST['nomb']
                , $_POST['desc'], $_POST['precio'], $_POST['familia']];
            
            curl_setopt($curl, CURLOPT_URL, "http://localhost/Practica_RestFullServer/index.php");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datos));
            $mensajeAct = curl_exec($curl);
            $listaProductos = muestraProductos($curl);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
            break;
        case 'Actualizar':

            //$datosPost=['usuariol'=>'dwes',  password' =>'abc123.'  ];
            $datos = [$_POST['nombre'], $_POST['nomb']
                , $_POST['desc'], $_POST['precio'], $_POST['familia'], $_POST['cod']];
            curl_setopt($curl, CURLOPT_URL, "http://localhost/Practica_RestFullServer/index.php");
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datos));
            $mensajeAct = curl_exec($curl);
            break;
//        default :
//            curl_setopt($curl, CURLOPT_URL, "http://localhost/Practica_RestFullServer/");
//            $respuesta = curl_exec($curl);
//            break;
    }
    //$respuesta = json_decode($respuesta, TRUE);
}

function muestraProductos($curl) {
    curl_setopt($curl, CURLOPT_URL, "http://localhost/Practica_RestFullServer/");
    $listaProductos = curl_exec($curl);
    return json_decode($listaProductos, TRUE);
}
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="index.php" method="POST">
            <?php echo $mensajeAct; ?>
            <fieldset>
                <legend>Acciones sobre productos</legend>
                codigo <input type="text" name="cod" id=""<?php if (isset($producto)) echo "value='" . $producto['cod'] . "'" ?>><br />
                Nombre corto<input type="text" name="nomb" id=""<?php if (isset($producto)) echo "value='" . $producto['nombre_corto'] . "'" ?>><br />
                Nombre<input type="text" name="nombre" id=""<?php if (isset($producto)) echo "value='" . $producto['nombre'] . "'" ?>><br />
                Descripcion<input type="text" name="desc" id=""<?php if (isset($producto)) echo "value='" . $producto['descripcion'] . "'" ?>><br />
                Precio venta publica<input type="text" name="precio" id=""<?php if (isset($producto)) echo "value='" . $producto['PVP'] . "'" ?>><br />
                Familia<input type="text" name="familia" id=""<?php if (isset($producto)) echo "value='" . $producto['familia'] . "'" ?>><br />

                <select name="codigos" >
                    <?php
                    foreach ($listaProductos as $respu) {
                        if ($producto['cod'] == $respu['cod']) {
                            echo "<option value='" . $respu['cod'] . "' selected>" . $respu['cod'] . "</option>";
                        } else {
                            echo "<option value='" . $respu['cod'] . "'>" . $respu['cod'] . "</option>";
                        }
                    }
                    ?>
                </select><br />
                <input type="submit" value="Listar Producto" name="opciones">
                <input type="submit" value="Listar Productos" name="opciones">
                <input type="submit" value="Borrar" name="opciones">
                <input type="submit" value="Insertar" name="opciones">
                <input type="submit" value="Actualizar" name="opciones">

            </fieldset>
        </form>

        <?php
        if ($_POST['opciones'] == 'Listar Productos') {

            foreach ($respuesta as $respu) {
                echo "<h3>" . $respu['nombre_corto'] . "</h3>";
            }
        }
        ?>
    </body>
</html>

