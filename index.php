<?php

session_start();

$connect = mysqli_connect("127.0.0.1:3308", "root", "Carlos123Cagua", "compras");

if (isset($_POST['add_to_cart'])) {

    if (isset($_SESSION['cart'])) {

        $session_array_id = array_column($_SESSION['cart'], "id");



        if (!in_array($_GET['id'], $session_array_id)) {

            $session_array = array(
                'id' => $_GET['id'],
                "nombre" => $_POST['nombre'],
                "precio" => $_POST['precio'],
                "quantity" => $_POST['quantity']

            );

            $_SESSION['cart'][] = $session_array;

        }

    } else {

        $session_array = array(
            'id' => $_GET['id'],
            "nombre" => $_POST['nombre'],
            "precio" => $_POST['precio'],
            "quantity" => $_POST['quantity']

        );

        $_SESSION['cart'][] = $session_array;

    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Carro</title>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>


    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-center">Carrito de compras Datos</h2>
                    <div class="col-md-12">
                        <div class="row">

                            <a href="index.html">Seguir Comprando</a>

                            <?php

                            $query = "SELECT * FROM prod";
                            $result = mysqli_query($connect, $query);


                            while ($row = mysqli_fetch_array($result)) { ?>
                                <div class="col-md-4">
                                    <form method="post" action="index.php?id=<?= $row['id'] ?>">
                                        <img src="imagen_producto_1.jpg" alt="Producto 1" style="height: 150px;">
                                        <h5 class="text-center">
                                            <?= $row['nombre']; ?>
                                        </h5>
                                        <h5 class="text-center">
                                            $
                                            <?= number_format($row['precio'], 2); ?>
                                        </h5>
                                        <input type="hidden" name="nombre" value="<?= $row['nombre'] ?>">
                                        <input type="hidden" name="precio" value="<?= $row['precio'] ?>">
                                        <input type="number" name="quantity" value="1" class="form-control">
                                        <input type="submit" name="add_to_cart" class="btn btn-warning btn-block my-2"
                                            value="Añadir producto">

                                    </form>
                                </div>
                            <?php }

                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="text-center">Selecionar producto</h2>

                    <?php

                    $total = 0;

                    $output = "";

                    $output .= "

                    <table class = 'table table-bordered table-striped'>
                    <tr>
                    <th>Id</th>
                    <th>Nombre del articulo</th>
                    <th>Precio del articulo</th>
                    <th>Cantidad de articulos</th>
                    <th>Total precio</th>
                    <th>Accion</th>
                    </tr>

                    ";


                    if (!empty($_SESSION['cart'])) {

                        foreach ($_SESSION['cart'] as $key => $value) {
                            $output .= "
                            <tr>
                    <td>" . $value['id'] . "</td>
                    <td>" . $value['nombre'] . "</td>
                    <td>" . $value['precio'] . "</td>
                    <td>" . $value['quantity'] . "</td>
                    <td>$" . number_format($value['precio'] * $value['quantity'], 2) . "</td>
                    <td>
                    <a href='index.php?action=remove&id=" . $value['id'] . "'>
                    <button class='btn btn-danger btn-block'>Remove</button>
                    </a>
                    </td>
                            ";

                            $total = $total + $value['quantity'] * $value['precio'];
                        }
                        $output .= "
                        <tr>
                        <td colspan='3'></td>
                        <td><b>Total Precio</b></td>
                        <td>" . number_format($total, 2) . "</td>
                        <td>
                    <a href='index.php?action=clearall'>
                    <button class='btn btn-warning'>Limpiar</button>
                    </a>
                    </td>
                        </tr>
                        ";

                    }


                    echo $output;
                    ?>

                </div>
            </div>
        </div>
    </div>

    <?php

    if (isset($_GET['action'])) {

        if ($_GET['action'] == "clearall") {
            unset($_SESSION['cart']);
        }

        if ($_GET['action'] == "remove") {
            foreach ($_SESSION['cart'] as $key => $value) {

                if ($value['id'] == $_GET['id']) {
                    unset($_SESSION['cart'][$key]);

                }

            }
        }
    }

    ?>


</body>

</html>