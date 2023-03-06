<?php

require_once('facture.php');
require_once('actionsDBFacture.php');

if (isset($_GET['idFactureASupprimer'])) {
    $actionsDBFacture = new ActionsDBFacture();
    $actionsDBFacture->deleteFacture($_GET['idFactureASupprimer']);
    header('Location: afficherFactures.php');
} else if (!empty($_GET['idFactureASupprimer'])) {
    echo "L'id de la facture à supprimer n'est pas valide.";
}

if (isset($_GET['idFacturePayee'])) {
    $actionsDBFacture = new ActionsDBFacture();
    $actionsDBFacture->changerStatusFacture($_GET['idFacturePayee']);
    header('Location: afficherFactures.php');
} else if (!empty($_GET['idFacturePayee'])) {
    echo "L'id de la facture qui a été payée n'est pas valide.";
}

?>

<!-- ------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------- -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Afficher factures</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- CSS et Javascript Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!--Javascript JQuerry-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!--CSS et Javascript DataTables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!-- CSS Custom-->
    <link href="../config/global.css" rel="stylesheet">
    <!-- Javascript Custom-->
    <script>
        function confirmSuppression(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette facture ?")) {
                window.location.href = "afficherFactures.php?idFactureASupprimer=" + id;
            }
        }

        function payerFacture(id) {
            window.location.href = "afficherFactures.php?idFacturePayee=" + id;
        }

        $(document).ready(function () {
            $('#myTable').DataTable();
        });
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
            <div class="col">
                <table id="myTable" class="table table-striped table-bordered pt-2">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Ids prestations</th>
                            <th>Payée</th>
                            <th>TVA</th>
                            <th>Supprimer</th>
                            <th>Payer</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once('facture.php');
                        require_once('actionsDBFacture.php');

                        $actionsDBFacture = new ActionsDBFacture();
                        $factures = $actionsDBFacture->getFacturesDetaillees();

                        // Code pour récupérer les clients depuis le tableau d'objets
                        foreach ($factures as $facture) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $facture["id"]; ?>
                                </td>
                                <td>
                                    <?php echo $facture["date"]; ?>
                                </td>
                                <td>
                                    <?php echo $facture["client"]; ?>
                                </td>
                                <td>
                                    <?php echo $facture["idsPrestations"]; ?>
                                </td>
                                <td>
                                    <?php echo ($facture["payee"] == 1) ? "Oui" : "Non"; ?>
                                </td>
                                <td>
                                    <?php echo $facture["tva"]; ?>
                                </td>
                                <td>
                                    <a href="#" onclick="confirmSuppression(<?php echo $facture['id']; ?>)"
                                        class="btn btn-sm">Supprimer</a>
                                </td>
                                <td>
                                    <?php if ($facture["payee"] != 1) { ?>
                                        <a href="#" onclick="payerFacture(<?php echo $facture['id']; ?>)"
                                            class="btn btn-sm">Payer</a>
                                    <?php } else { ?>
                                        <span class="btn btn-sm disabled">Déjà payée</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="factureToPDF.php?id=<?php echo $facture["id"]; ?>"
                                        class="btn btn-sm">PDF</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>


</html>