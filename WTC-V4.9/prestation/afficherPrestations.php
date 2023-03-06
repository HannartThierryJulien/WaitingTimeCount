<?php

require_once('prestation.php');
require_once('actionsDBPrestation.php');

if (isset($_GET['idPrestationASupprimer'])) {
    $actionsDBPrestation = new ActionsDBPrestation();
    $actionsDBPrestation->deletePrestation($_GET['idPrestationASupprimer']);
    header('Location: afficherPrestations.php');
} else if (!empty($_GET['idPrestationASupprimer'])) {
    echo "L'id de la prestation à supprimer n'est pas valide.";
}

?>

<!-- ------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------- -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Afficher prestations</title>
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
            if (confirm("Êtes-vous sûr de vouloir supprimer cette prestation ?")) {
                window.location.href = "afficherPrestations.php?idPrestationASupprimer=" + id;
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
            require_once('prestation.php');
            require_once('actionsDBPrestation.php');

            $actionsDBPrestation = new ActionsDBPrestation();
            $prestations = $actionsDBPrestation->getPrestationsDetaillees();

            // Code pour récupérer les prestations depuis le tableau d'objets
            foreach ($prestations as $prestation) {
                ?>
                <div class="col-sm-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $prestation["date"] . " - " . $prestation["nomClient"]; ?>
                            </h5>
                            <p class="card-text">
                                <strong>Id :</strong>
                                <?php echo $prestation["id"]; ?><br>
                                <strong>Client :</strong>
                                <?php echo $prestation["nomClient"] . ' ' . $prestation["prenomClient"]; ?><br>
                                <strong>Tarif :</strong>
                                <?php echo $prestation["nomTarif"] . ' - ' . $prestation["prixTarif"] . '€/h'; ?><br>
                                <strong>Durée :</strong>
                                <?php echo gmdate("H\h i\m s\s", intval($prestation['duree'])); ?><br>
                                <strong>Description :</strong>
                                <?php echo $prestation["description"]; ?><br>
                                <strong>Facturée :</strong>
                                <?php echo ($prestation["facturee"] == 1) ? "Oui" : "Non"; ?>
                            </p>
                            <button type="button" class="btn"
                                onclick="confirmSuppression(<?php echo $prestation['id']; ?>)">Supprimer</button>
                            <a href="modifierPrestation.php?id=<?php echo $prestation['id']; ?>"
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