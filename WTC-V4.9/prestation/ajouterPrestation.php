<?php

require_once('prestation.php');
require_once('actionsDBPrestation.php');

if (array_key_exists('ajouterPrestation', $_POST)) {

    $prestationToAdd = new Prestation();
    $prestationToAdd->setAttributesForInsert($_POST["idClient"], $_POST["idTarif"], $_POST["chrono"], $_POST["description"], 0);

    $actionsDBPrestation = new ActionsDBPrestation();
    $actionsDBPrestation->addPrestation($prestationToAdd);

    header("Location: afficherPrestations.php");
}

?>

<!-- ------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------- -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ajouter prestation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Framework Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- JQuerry -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- CSS Custom-->
    <link href="../config/global.css" rel="stylesheet">
    <!-- Javascript Custom-->
    <script src="prestation.js"></script>
</head>

<body>
    <header>
        <?php
        include '../config/navBar.php';
        ?>
    </header>

    <main class="container py-5">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card border-0 shadow">
                    <div class="card-header bg-transparent text-center">
                        <h1 class="mb-0">Ajouter une prestation</h1>
                    </div>
                    <div class="card-body">
                        <div id="time" class="text-center">
                            <span class="digit" id="hr">00</span><span class="txt">h </span>
                            <span class="digit" id="min">00</span><span class="txt">m </span>
                            <span class="digit" id="sec"> 00</span><span class="txt">s </span>
                        </div>

                        <form method="post">
                            <div class="mb-3">
                                <label for="clientsList" class="form-label">Client :</label>
                                <select class="form-select" id="clientsList" name="idClient" required>
                                    <?php
                                    require_once('../client/client.php');
                                    require_once('../client/actionsDBClient.php');

                                    $actionsDBClient = new ActionsDBClient();
                                    $clients = $actionsDBClient->getClients();

                                    foreach ($clients as $client) {
                                        ?>
                                        <option value="<?php echo $client->getId(); ?>">
                                            <?php echo $client->getNom() . " " . $client->getPrenom(); ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tarifsList" class="form-label">Tarif :</label>
                                <select class="form-select" id="tarifsList" name="idTarif" required>
                                    <?php
                                    require_once '../database/database.php';
                                    $db = new Database();
                                    $pdo = $db->getConnection();
                                    $stmt = $pdo->prepare('SELECT * FROM tarif');
                                    $stmt->execute();
                                    while ($tarif = $stmt->fetch()) {
                                        ?>
                                        <option value="<?php echo $tarif['id']; ?>">
                                            <?php echo $tarif['nom'] . " : " . $tarif['montantParHeure'] . " €/h"; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description :</label>
                                <input type="text" id="description" name="description" class="form-control" required>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <input type="button" id="start" value="Démarrer" class="btn mx-2">
                                <input type="button" id="pause" value="Pause" class="btn mx-2">
                                <input type="button" id="stop" value="Arrêter" class="btn mx-2">
                                <input type="hidden" id="chrono" value="0" name="chrono">
                                <button type="submit" name="ajouterPrestation" class="btn mx-2">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>