<!DOCTYPE html>
<html>
<head>
    <title>Facture PDF</title>
</head>
<body>
    <h1>Facture</h1>
    <p>Numéro de facture : {{ $facture->idFacture }}</p>
    <p>Total HT : {{ $facture->totalHT }}</p>
    <p>Total TTC : {{ $facture->totalTTC }}</p>
    <p>Date de facture : {{ $facture->dateFacture }}</p>
    <p>Merci de votre confiance.</p>
</body>
</html>
