<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Proveri korisničko ime, standardno je 'root'
define('DB_PASS', ''); // Proveri lozinku, obično je prazna ako nisi postavio lozinku
define('DB_NAME', 'personal_assistant_db');

// Povezivanje sa bazom
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Provera konekcije
if ($conn->connect_error) {
    die("Konekcija nije uspjela: " . $conn->connect_error);
}
?>
