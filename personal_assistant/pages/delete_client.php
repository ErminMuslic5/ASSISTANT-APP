<?php
include '../config/config.php'; // Uključi konfiguraciju za bazu podataka

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Brisanje svih zadataka povezanih sa klijentom
    $deleteTasksSql = "DELETE FROM tasks WHERE client_id = $id";
    if ($conn->query($deleteTasksSql) === TRUE) {
        // Ako su zadaci uspešno obrisani, brišemo klijenta
        $sql = "DELETE FROM clients WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Klijent i svi povezani zadaci su uspešno obrisani.";
            // Redirektuj nazad na stranicu sa klijentima
            header("Location: clients.php");
            exit();
        } else {
            echo "Greška pri brisanju klijenta: " . $conn->error;
        }
    } else {
        echo "Greška pri brisanju zadataka povezanih sa klijentom: " . $conn->error;
    }
} else {
    echo "ID klijenta nije prosleđen.";
}
?>
