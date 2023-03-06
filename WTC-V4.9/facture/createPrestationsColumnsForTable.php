<?php
require_once('../prestation/prestation.php');
require_once('../prestation/actionsDBPrestation.php');

if (array_key_exists('clientId', $_POST)) {
    $clientId = $_POST['clientId'];

    $actionsDBPrestation = new ActionsDBPrestation();
    $prestations = $actionsDBPrestation->getPrestationsDetailleesByClient($clientId);

    foreach ($prestations as $prestation) {
        echo "<tr>";
        echo "<td scope='row'>" . $prestation["id"] . "</td>";
        echo "<td>" . $prestation["date"] . "</td>";
        echo "<td>" . $prestation["nomClient"] . $prestation["prenomClient"] . "</td>";
        echo "<td>" . $prestation["nomTarif"] . "</td>";
        echo "<td>" . $prestation["prixTarif"] . "</td>";
        echo "<td>" . gmdate("H\h i\m s\s", intval($prestation['duree'])) . "</td>";
        echo "<td>" . (($prestation["facturee"] == 1) ? "Oui" : "Non") . "</td>";
        echo "</tr>";
    }
}
?>
