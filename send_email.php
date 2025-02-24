<?php
header("Content-Type: application/json");

// Activer l'affichage des erreurs PHP (à désactiver en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérifier si la requête est bien en POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée."]);
    exit;
}

// Vérifier si toutes les valeurs requises sont bien reçues
if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["message"])) {
    echo json_encode(["success" => false, "message" => "Tous les champs obligatoires doivent être remplis."]);
    exit;
}

// Récupérer et sécuriser les données
$name = htmlspecialchars(trim($_POST["name"]));
$email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
$phone = htmlspecialchars(trim($_POST["phone"] ?? ""));
$website = htmlspecialchars(trim($_POST["website"] ?? ""));
$message = htmlspecialchars(trim($_POST["message"]));

if (!$email) {
    echo json_encode(["success" => false, "message" => "Adresse e-mail invalide."]);
    exit;
}

// Adresse de réception
$to = "foret_most@yahoo.fr";
$subject = "Nouveau message de contact";
$body = "Nom: $name\nEmail: $email\nTéléphone: $phone\nSite Web: $website\nMessage:\n$message";
$headers = "From: noreply@votre-domaine.com\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

// Envoyer l'email et afficher un message JSON
if (mail($to, $subject, $body, $headers)) {
    echo json_encode(["success" => true, "message" => "Votre message a bien été envoyé !"]);
} else {
    error_log("Erreur lors de l'envoi de l'email : problème avec la fonction mail().");
    echo json_encode(["success" => false, "message" => "Erreur lors de l'envoi du message."]);
}
?>
