<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data["guestName"]) && isset($data["selectedChairInfo"])) {
        $guestName = $data["guestName"];
        $selectedChairInfo = $data["selectedChairInfo"];

        // Načtěte existující rezervace (pokud existují)
        $reservations = [];
        $file = 'reservations.json';

        if (file_exists($file)) {
            $reservations = json_decode(file_get_contents($file), true);
        }

        // Přidejte novou rezervaci
        $reservations[$guestName] = $selectedChairInfo;

        // Uložte aktualizované rezervace zpět do souboru
        if (file_put_contents($file, json_encode($reservations, JSON_PRETTY_PRINT)) !== false) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    echo json_encode(["success" => false]);
}
?>
