<?php
include '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $budget = $_POST['budget'];

    // SQL upit za umetanje novog klijenta
    $sql = "INSERT INTO clients (name, email, phone, budget) VALUES ('$name', '$email', '$phone', '$budget')";

    if ($conn->query($sql) === TRUE) {
        echo "Novi klijent je uspešno dodat.";
    } else {
        echo "Greška: " . $sql . "<br>" . $conn->error;
    }

    // Redirektuj na stranicu sa klijentima
    header("Location: clients.php");
    exit();
}
?>
