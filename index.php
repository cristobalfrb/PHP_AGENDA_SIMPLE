
<?php


$valor = (!empty(isset($_GET['q'])) ) ? $_GET['q'] : "";


?>


<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pagina funcion como agenda">
    <meta name="author" content="Cristobal Ruiz">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Agenda de contacto personal</title>

    <link href="./styles.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <meta name="theme-color" content="#7952b3">
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">Agenda Web Simple</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                    </li>
                </ul>
                <form class="d-flex" method="GET" action="./index.php">
                    <input class="form-control me-2" type="search" name="q" placeholder="Buscar por Nombre" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="page-header text-center">
            Agenda de Contactos personal
            <?php
                if($valor != ""){
                    echo "<i>- buscando: $valor</i>";
                }
            ?>
        </h1>
        <div class="row mt-4">
            <div class="col-sm-12">
                <button type="button" id="btnNuevo" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><span class="fa fa-plus me-1"></span>Nuevo</button>
            </div>
        </div>

        <?php
        session_start();
        if (isset($_SESSION['message'])) {
        ?>

            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>


        <?php
            unset($_SESSION['message']);
        }  // Fin del IF   
        ?>

        <table id="tabla_contactos" class="mt-4 table table-bordered table-striped">
            <thead>
                <th>ID</th>
                <th>NOMBRE CONTACTO</th>
                <th>CELULAR</th>
                <th>EMAIL</th>
                <th>DIRECCION</th>
                <th>ACCIONES</th>
            </thead>
            <tbody>
                <?php
                include_once('./conexion.php');

                $database = new ConectarBD();
                $db = $database->open();

                try {

                    $sql = ($valor == "") ? "SELECT * FROM personas" : "SELECT * FROM personas WHERE nombre COLLATE UTF8_GENERAL_CI LIKE '%$valor%'";
                    
                    foreach ($db->query($sql) as $row) {
                ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['nombre'] ?></td>
                            <td><?php echo $row['telefono'] ?></td>
                            <td><?php echo $row['correo'] ?></td>
                            <td><?php echo $row['direccion'] ?></td>
                            <td nowrap>
                                <button type="button" id="edit:<?php echo $row['id']; ?>" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                                    <span class="fa fa-edit me-1"></span>Editar
                                </button>
                                <a href="./eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"><span class="fa fa-trash me-1"></span>Eliminar</a>
                            </td>
                        </tr>
                <?php
                    }
                } catch (PDOException $e) {
                    echo "Existe problema en la conexion: " . $e->getMessage();
                }
                $database->close();
                ?>
            </tbody>
        </table>


    </div>

    <?php
    include_once('./add_modal.php');
    ?>


    <script src="bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7225277ba0.js" crossorigin="anonymous"></script>
    <script src="./agenda.js"></script>
</body>

</html>