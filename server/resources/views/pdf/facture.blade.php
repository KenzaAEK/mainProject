<!DOCTYPE html>
<html>
<head>
    <title>Facture PDF</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            color: #4A90E2;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Facture</h1>
    <p>Numéro de facture : {{ $facture->idFacture }}</p>
    <p>Total HT : {{ $facture->totalHT }} DH</p>
    <p>Total TTC : {{ $facture->totalTTC }} DH</p>
    <p>Date de facture : {{ $facture->dateFacture }}</p>
    <p class="footer">Merci de votre confiance.</p>
</body>
</html>
