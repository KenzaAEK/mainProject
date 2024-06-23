<!-- resources/views/emails/forgot-password.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Réinitialisation du mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            color: #666666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .button:hover { 
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Réinitialisation du mot de passe</h1>
        <p>Bonjour,</p>
        <p>Vous avez demandé la réinitialisation de votre mot de passe. Veuillez cliquer sur le lien ci-dessous pour créer un nouveau mot de passe :</p>
        <p><a href="https://www.enfants.innova.ma/reset/{{$token}}" class="button">Réinitialiser le mot de passe</a></p>
        <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet e-mail en toute sécurité.</p>
        <p>Cordialement,<br>L'équipe de votre application</p>
    </div>
</body>
</html>