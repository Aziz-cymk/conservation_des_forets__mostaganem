<?php
$file = "data.json";

// Charger les données depuis le fichier JSON
function loadData() {
    global $file;
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

// Sauvegarder les données dans le fichier JSON
function saveData($data) {
    global $file;
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

// Vérifier quelle action est demandée
$action = isset($_GET["action"]) ? $_GET["action"] : "";

if ($action == "save") {
    $data = loadData();
    $newEntry = [
        "id" => count($data) + 1,
        "location" => $_POST["location"],
        "species" => $_POST["species"],
        "diameter" => $_POST["diameter"],
        "height" => $_POST["height"]
    ];
    $data[] = $newEntry;
    saveData($data);
    echo json_encode(["message" => "Données sauvegardées avec succès !"]);
}

elseif ($action == "load") {
    echo json_encode(loadData());
}

elseif ($action == "delete") {
    $id = $_GET["id"];
    $data = loadData();
    $data = array_filter($data, function($tree) use ($id) {
        return $tree["id"] != $id;
    });
    saveData(array_values($data));
    echo json_encode(["message" => "Donnée supprimée avec succès !"]);
}

else {
    echo json_encode(["message" => "Action non reconnue."]);
}
?>
