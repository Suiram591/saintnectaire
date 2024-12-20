<?php

define('PASSWORD', 'Dieudufromage');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted_password = htmlspecialchars(trim($_POST['password']));

    if ($submitted_password !== PASSWORD) {
        echo "Mot de passe incorrect.";
        exit;
    }
} else {
    
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accès sécurisé</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }
            .login-form {
                background-color: #fff;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            input[type="password"] {
                padding: 10px;
                margin: 10px 0;
                width: 100%;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            button {
                padding: 10px 20px;
                background-color: #4CAF50;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            button:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <form class="login-form" method="post" action="">
            <h1>Connexion sécurisée</h1>
            <p>Veuillez entrer le mot de passe pour accéder aux commandes.</p>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </body>
    </html>
    <?php
    exit;
}

$fichier = 'commandes.json';

if (!file_exists($fichier)) {
    echo "Aucune commande trouvée.";
    exit;
}

$commandes = json_decode(file_get_contents($fichier), true);

if (!$commandes) {
    echo "Aucune commande disponible.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .logout {
            margin: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .logout:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Liste des Commandes</h1>
    <table>
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Quantité</th>
                <th>Prix Unitaire (€)</th>
                <th>Prix Total (€)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
            <tr>
                <td><?php echo htmlspecialchars($commande['prenom']); ?></td>
                <td><?php echo htmlspecialchars($commande['nom']); ?></td>
                <td><?php echo htmlspecialchars($commande['email']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($commande['adresse'])); ?></td>
                <td><?php echo $commande['quantite']; ?></td>
                <td><?php echo number_format($commande['prix_unitaire'], 2); ?></td>
                <td><?php echo number_format($commande['prix_total'], 2); ?></td>
                <td><?php echo htmlspecialchars($commande['date']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.html" class="logout">Retour à l'accueil</a>
</body>
</html>
