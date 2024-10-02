<?php
include '../config/config.php'; // Uključi konfiguraciju za bazu podataka

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Dohvatanje troška zadatka pre brisanja
    $taskSql = "SELECT client_id, cost FROM tasks WHERE id = $id";
    $taskResult = $conn->query($taskSql);
    if ($taskResult->num_rows > 0) {
        $task = $taskResult->fetch_assoc();

        // Vraćanje troška nazad na budžet klijenta pre brisanja zadatka
        $updateBudgetSql = "UPDATE clients SET budget = budget + " . $task['cost'] . " WHERE id = " . $task['client_id'];
        if ($conn->query($updateBudgetSql) === TRUE) {
            // Brisanje zadatka iz baze nakon ažuriranja budžeta
            $sql = "DELETE FROM tasks WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo "Zadatak je uspešno obrisan i trošak je vraćen na budžet klijenta.";
            } else {
                echo "Greška pri brisanju zadatka: " . $conn->error;
            }
        } else {
            echo "Greška pri ažuriranju budžeta: " . $conn->error;
        }
    } else {
        echo "Zadatak nije pronađen.";
    }

    // Redirektuj na stranicu sa zadacima nakon brisanja
    header("Location: tasks.php");
    exit();
}
?>
