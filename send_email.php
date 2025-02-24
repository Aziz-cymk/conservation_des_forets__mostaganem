<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $website = htmlspecialchars($_POST["website"]);
    $message = htmlspecialchars($_POST["message"]);

    $to = "foret_most@yahoo.fr";
    $subject = "Nouveau message de contact";
    $body = "Nom: $name\nEmail: $email\nTéléphone: $phone\nSite Web: $website\nMessage:\n$message";
    $headers = "From: $email\r\nReply-To: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "Message envoyé avec succès !";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}
?>
