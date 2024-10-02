<?php
include '../config/config.php'; // Uključi konfiguraciju za bazu podataka

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $cost = $_POST['cost'];

    // Dodavanje zadatka u bazu
    $sql = "INSERT INTO tasks (client_id, title, description, due_date, cost) 
            VALUES ('$client_id', '$title', '$description', '$due_date', '$cost')";

    if ($conn->query($sql) === TRUE) {
        // Ažuriranje budžeta klijenta
        $updateBudgetSql = "UPDATE clients SET budget = budget - $cost WHERE id = $client_id";
        $conn->query($updateBudgetSql);

        echo "Novi zadatak je uspešno dodat.";
    } else {
        echo "Greška: " . $sql . "<br>" . $conn->error;
    }

    // Redirektuj na stranicu sa zadacima nakon dodavanja
    header("Location: tasks.php");
    exit();
}
?>
