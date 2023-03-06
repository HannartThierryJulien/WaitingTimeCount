<?php
require_once 'TCPDF-main/tcpdf.php';
require_once '../database/database.php';
require_once '../prestation/actionsDBPrestation.php';
require_once '../facture/actionsDBFacture.php';
require_once '../client/actionsDBClient.php';

$database = new Database();
$pdo = $database->getConnection();

if (isset($_GET['id'])) {

    /*********************************************************************/
    /* Récupération des données nécessaires à la création du pdf */
    /*********************************************************************/

    // Récupérer les informations sur la facture
    $actionsDBFacture = new ActionsDBFacture();
    $facture = $actionsDBFacture->getFactureById($_GET['id']);

    // Récupérer les informations sur les prestations
    $idsPrestations = explode(',', $facture->getIdsPrestations());
    $actionsDBPrestation = new ActionsDBPrestation();
    $prestations = $actionsDBPrestation->getPrestationsForFacture($idsPrestations);

    // Récupérer les informations sur le client
    $actionsDBClient = new ActionsDBClient();
    $client = $actionsDBClient->getClientById($prestations[0]['idClient']);

    // Récupérer les données de l'entreprise depuis le fichier JSON
    $entrepriseJSON = file_get_contents('../config/donneesEntreprise.json');
    $donneesEntreprise = json_decode($entrepriseJSON, true);

    // Calculer le total
    $totalHT = 0;
    foreach ($prestations as $prestation) {
        $nbrHeures = intval($prestation['duree']) / 3600;
        $totalHT += $prestation['prixTarif'] * $nbrHeures;
    }
    $totalHT = round($totalHT, 2);


    /*********************************************************************/
    /* Création du pdf */
    /*********************************************************************/

    // Créer le PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Author');
    $pdf->SetTitle('Facture');
    $pdf->SetSubject('Facture');
    $pdf->SetKeywords('Facture, PDF');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage();


    /*********************************************************************/
    /* Préparation de l'entête */
    /*********************************************************************/

    //Affichage info entreprise
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 5, $donneesEntreprise['nom'], 0, 1, 'L');
    $pdf->Cell(0, 5, $donneesEntreprise['telephone'], 0, 1, 'L');
    $pdf->Cell(0, 5, $donneesEntreprise['adresse'], 0, 1, 'L');
    $pdf->Ln();

    //Affichage info client
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 5, $client->getNom() . ' ' . $client->getPrenom(), 0, 1, 'R');
    $pdf->Cell(0, 5, $client->getMail(), 0, 1, 'R');
    $pdf->Cell(0, 5, $client->getTelephone(), 0, 1, 'R');
    $pdf->Cell(0, 5, $client->getAdresse(), 0, 1, 'R');
    $pdf->Ln();
    $pdf->Ln();

    //Affichage bande grise "facture"
    $pdf->SetFillColor(128, 128, 128);
    $pdf->SetDrawColor(97, 95, 95);
    $pdf->SetTextColor(255);
    $pdf->SetFont('');
    $pdf->Cell(0, 7, 'FACTURE', 1, 0, 'R', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    //Affichage info facture
    $pdf->SetTextColor(0);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 5, "Numéro de facture : " . $facture->getId(), 0, 1, 'L');
    $pdf->Cell(0, 5, "Date de facture : " . $facture->getDate(), 0, 1, 'L');
    $pdf->Cell(0, 5, "Numéro client : " . $client->getId(), 0, 1, 'L');
    $pdf->Ln();
    $pdf->Ln();


    /*********************************************************************/
    /* Préparation du tableau hors tva */
    /*********************************************************************/

    // En-tête du tableau HT (hors tva)
    $pdf->SetTextColor(255);
    $header = array('Id', 'Date', 'Durée', 'Tarif appliqué', 'Montat tarif', 'Total prestation');
    $w = array(31.6, 31.6, 31.6, 31.6, 31.6, 31.6);
    for ($i = 0; $i < count($header); $i++)
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
    $pdf->Ln();

    // Données du tableau HT
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    foreach ($prestations as $prestation) {
        $dureeFormattee = gmdate("H\h i\m", intval($prestation['duree']));
        $totalPrestation = round($prestation['prixTarif'] * (intval($prestation['duree']) / 3600), 2);
        $pdf->Cell($w[0], 6, $prestation['id'], 'LR', 0, 'C', true);
        $pdf->Cell($w[1], 6, $prestation['date'], 'LR', 0, 'C', true);
        $pdf->Cell($w[2], 6, $dureeFormattee, 'LR', 0, 'C', true);
        $pdf->Cell($w[3], 6, $prestation['nomTarif'], 'LR', 0, 'C', true);
        $pdf->Cell($w[4], 6, $prestation['prixTarif'] . '€/h', 'LR', 0, 'C', true);
        $pdf->Cell($w[5], 6, $totalPrestation . ' €', 'LR', 0, 'C', true);
        $pdf->Ln();
    }

    // Dernière ligne tableau HT
    $pdf->Cell($w[0], 6, '', 'LR', 0, 'L', true);
    $pdf->Cell($w[1], 6, '', 'LR', 0, 'L', true);
    $pdf->Cell($w[2], 6, '', 'LR', 0, 'L', true);
    $pdf->Cell($w[3], 6, '', 'LR', 0, 'L', true);
    $pdf->SetFillColor(128, 128, 128);
    $pdf->SetTextColor(255);
    $pdf->Cell($w[4], 6, 'Total HT :', 'LR', 0, 'C', true);
    $pdf->Cell($w[5], 6, $totalHT . ' €', 'LR', 0, 'C', true);
    $pdf->Ln();
    $pdf->Cell(array_sum($w), 0, '', 'T');
    $pdf->Ln();
    $pdf->Ln();


    /*********************************************************************/
    /* Préparation du tableau tva comprise */
    /*********************************************************************/

    // En-tête du tableau TTC (tva comprise)
    $pdf->SetTextColor(255);
    $header = array('Id', 'Date', 'Total HT', 'Total TTC');
    $w = array(47.5, 47.5, 47.5, 47.5);
    for ($i = 0; $i < count($header); $i++)
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
    $pdf->Ln();

    // Données du tableau TTC
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    foreach ($prestations as $prestation) {
        $totalPrestation = round($prestation['prixTarif'] * (intval($prestation['duree']) / 3600), 2);
        $pdf->Cell($w[0], 6, $prestation['id'], 'LR', 0, 'C', true);
        $pdf->Cell($w[1], 6, $prestation['date'], 'LR', 0, 'C', true);
        $pdf->Cell($w[2], 6, $totalPrestation . ' €', 'LR', 0, 'C', true);
        $pdf->Cell($w[3], 6, $totalPrestation * $facture->getTva() . ' €', 'LR', 0, 'C', true);
        $pdf->Ln();
    }

    // Dernière ligne tableau TTC
    $pdf->Cell($w[0], 6, '', 'LR', 0, 'L', true);
    $pdf->Cell($w[1], 6, '', 'LR', 0, 'L', true);
    $pdf->SetFillColor(128, 128, 128);
    $pdf->SetTextColor(255);
    $pdf->Cell($w[2], 6, 'Total TTC :', 'LR', 0, 'C', true);
    $pdf->Cell($w[3], 6, $totalHT * $facture->getTva() . ' €', 'LR', 0, 'C', true);
    $pdf->Ln();
    $pdf->Cell(array_sum($w), 0, '', 'T');
    $pdf->Ln();
    $pdf->Ln();


    /*********************************************************************/
    /* Préparation du bas de page */
    /*********************************************************************/

    //Affichage info paiement
    $donneesBanque = $donneesEntreprise['banque'];
    $pdf->SetTextColor(0);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 5, "Mode de paiement : " . $donneesEntreprise['modeDePaiement'], 0, 1, 'L');
    $pdf->Cell(0, 5, "Bic : " . $donneesBanque['bic'], 0, 1, 'L');
    $pdf->Cell(0, 5, "Compte bancaire : " . $donneesBanque['compteBancaire'], 0, 1, 'L');
    $pdf->Ln();

    $pdf->Output('Facture.pdf', 'D');
}