<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture des données
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $quantite = (int)$_POST['quantite'];
    $prix_unitaire = (float)$_POST['prix_unitaire'];

    // Validation basique des champs
    if (empty($prenom) || empty($nom) || empty($email) || empty($adresse) || $quantite < 1) {
        echo "Tous les champs doivent être remplis correctement.";
        exit;
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse email invalide.";
        exit;
    }

    // Calcul du prix total
    $prix_total = $prix_unitaire * $quantite;

    // Enregistrement dans un fichier JSON
    $commande = [
        "prenom" => $prenom,
        "nom" => $nom,
        "email" => $email,
        "adresse" => $adresse,
        "quantite" => $quantite,
        "prix_unitaire" => $prix_unitaire,
        "prix_total" => $prix_total,
        "date" => date("Y-m-d H:i:s") // Ajout d'une date
    ];

    // Chemin du fichier JSON
    $fichier = 'commandes.json';

    // Lire les commandes existantes (si le fichier existe)
    $commandesExistantes = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];

    // Ajouter la nouvelle commande
    $commandesExistantes[] = $commande;

    // Enregistrer toutes les commandes dans le fichier JSON
    file_put_contents($fichier, json_encode($commandesExistantes, JSON_PRETTY_PRINT));
} else {
    // Si aucune donnée n'est envoyée, rediriger vers la page d'accueil
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Commande</title>
    <style>
        /* Styles de base */
        body {
            font-family: Arial, sans-serif;
            background-image: 'fond_saint_nectaire.jpg';
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            width: 100%;
            text-align: center;
        }

        .confirmation {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .confirmation p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .confirmation strong {
            color: #4CAF50;
            font-weight: bold;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #45a049;
        }

        footer {
            margin-top: auto;
            padding: 10px;
            background-color: #333;
            color: #fff;
            text-align: center;
            width: 100%;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <header>
        <h1>Confirmation de votre commande</h1>
    </header>

    <section class="confirmation">
        <p>Merci <strong><?php echo $prenom . ' ' . $nom; ?></strong>, votre commande a été reçue ! Nous vous recontacterons pour vous remettre votre commande ainsi que le payement.</p>
        <p><strong>Email :</strong> <?php echo $email; ?></p>
        <p><strong>Adresse de livraison :</strong> <?php echo nl2br($adresse); ?></p>
        <p><strong>Quantité commandée :</strong> <?php echo $quantite; ?></p>
        <p><strong>Total :</strong> <?php echo number_format($prix_total, 2); ?> €</p>
        <a href="index.html" class="back-btn">Retour à la page d'accueil</a>
    </section>

    <footer>
        <p>© 2024 Fromagerie Artisanale - Tous droits réservés.</p>
    </footer>
</body>
</html>


