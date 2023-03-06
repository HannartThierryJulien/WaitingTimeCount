<?php

require_once('prestation.php');
require_once('actionsDBPrestation.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $actionsDBPrestation = new ActionsDBPrestation();
    $prestation = $actionsDBPrestation->getPrestationById($id);
}

if (isset($_POST['submit'])) {

    $newPrestation = new Prestation();

    $heures = intval(substr($_POST["duree"], 0, 2));
    $minutes = intval(substr($_POST["duree"], 3, 2));
    $secondes = intval(substr($_POST["duree"], 6, 2));
    $dureeFormatee = $heures * 3600 + $minutes * 60 + $secondes;

    $newPrestation->setAllAttributes($_POST["id"], $_POST["date"], $_POST["idClient"], $_POST["idTarif"], $dureeFormatee, $_POST["description"], $_POST["facturee"]);

    $actionsDBPrestation = new ActionsDBPrestation();
    $actionsDBPrestation->updatePrestation($newPrestation);

    header("Location: afficherPrestations.php");
    exit;
}

?>

<!-- ------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------- -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Modifier une prestation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Framework Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- CSS Custom-->
    <link href="../config/global.css" rel="stylesheet">
    <!-- Javascript Custom-->
</head>

<body>
    <header>
        <?php
        include '../config/navBar.php';
        ?>
    </header>

    <main>
        <h1>Modifier une prestation</h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $prestation->getId(); ?>">
            <div>
                <label for="date">Date :</label>
                <input type="text" id="date" name="date" value="<?php echo $prestation->getDate(); ?>">
            </div>
            <div>
                <label for="idClient">IdClient :</label>
                <input type="text" id="idClient" name="idClient" value="<?php echo $prestation->getIdClient(); ?>">
            </div>
            <div>
                <label for="idTarif">IdTarif :</label>
                <input type="text" id="idTarif" name="idTarif" value="<?php echo $prestation->getIdTarif(); ?>">
            </div>
            <div>
                <label for="duree">Duree :</label>
                <input type="text" id="duree" name="duree"
                    value="<?php echo gmdate("H\hi\ms\s", intval($prestation->getDuree())); ?>">
            </div>
            <div>
                <label for="description">Description :</label>
                <textarea id="description" name="description"><?php echo $prestation->getDescription(); ?></textarea>
            </div>
            <div>
                <label for="facturee">Facturee :</label>
                <input type="text" id="facturee" name="facturee" value="<?php echo $prestation->isFacturee(); ?>">
            </div>
            <div>
                <input type="submit" name="submit" value="Enregistrer les modifications">
            </div>
        </form>
    </main>
</body>

</html>