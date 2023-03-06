<?php

require_once('client.php');
require_once('actionsDBClient.php');

if (isset($_GET['idClientASupprimer'])) {
    $actionsDBClient = new ActionsDBClient();
    $actionsDBClient->deleteClient($_GET['idClientASupprimer']);
    header('Location: afficherClients.php');
} else if (!empty($_GET['idClientASupprimer'])) {
    echo "L'id du cient à supprimer n'est pas valide.";
}

?>

<!-- ------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------- -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Afficher clients</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- CSS et Javascript Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- CSS Custom-->
    <link href="../config/global.css" rel="stylesheet">
    <!-- Javascript Custom-->
    <script>
        function confirmSuppression(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce client ?")) {
                window.location.href = "afficherClients.php?idClientASupprimer=" + id;
            }
        }
    </script>
</head>

<body>
    <header>
        <?php
        include '../config/navBar.php';
        ?>
    </header>

    <main class="container mt-5">
        <div class="row">
            <?php
            require_once('client.php');
            require_once('actionsDBClient.php');

            $actionsDBClient = new ActionsDBClient();
            $clients = $actionsDBClient->getClients();

            // Code pour récupérer les clients depuis le tableau d'objets
            foreach ($clients as $client) {
                ?>
                <div class="col-sm-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $client->getNom() . " " . $client->getPrenom(); ?>
                            </h5>
                            <p class="card-text">
                                <strong>Id :</strong>
                                <?php echo $client->getId(); ?><br>
                                <strong>Email :</strong>
                                <?php echo $client->getMail(); ?><br>
                                <strong>Téléphone :</strong>
                                <?php echo $client->getTelephone(); ?><br>
                                <strong>Adresse :</strong>
                                <?php echo $client->getAdresse(); ?><br>
                                <strong>Description :</strong>
                                <?php echo $client->getDescription(); ?>
                            </p>
                            <button type="button" class="btn"
                                onclick="confirmSuppression(<?php echo $client->getId(); ?>)">Supprimer</button>
                            <a href="modifierClient.php?id=<?php echo $client->getId(); ?>"
                                class="btn">Modifier</a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </main>

</body>

</html>