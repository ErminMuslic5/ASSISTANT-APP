<?php
include '../config/config.php'; // Uključi konfiguraciju za bazu podataka
include '../includes/header.php'; // Uključi header

// Provera da li je prosleđen ID klijenta putem URL-a
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Dohvatanje podataka klijenta iz baze podataka
    $sql = "SELECT * FROM clients WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        echo "Klijent nije pronađen.";
        exit();
    }
} else {
    echo "ID klijenta nije prosleđen.";
    exit();
}

// Ažuriranje podataka klijenta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $budget = $_POST['budget'];

    // SQL upit za ažuriranje klijenta
    $sql = "UPDATE clients SET name = '$name', email = '$email', phone = '$phone', budget = '$budget' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Informacije o klijentu su uspešno ažurirane.";
        // Redirektuj na stranicu sa klijentima nakon ažuriranja
        header("Location: clients.php");
        exit();
    } else {
        echo "Greška: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container">
    <h2 class="mb-4">Uredi Klijenta</h2>
    <form action="/personal_assistant/pages/edit_client.php?id=<?php echo $client['id']; ?>" method="POST" class="card p-4">


        <input type="text" id="name" name="name" class="form-control" value="<?php echo $client['name']; ?>" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo $client['email']; ?>" required>
        <label for="phone">Telefon:</label>
        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $client['phone']; ?>">
        <label for="budget">Budžet:</label>
        <input type="number" step="0.01" id="budget" name="budget" class="form-control" value="<?php echo $client['budget']; ?>" required>
        <input type="submit" value="Ažuriraj Klijenta" class="btn btn-primary mt-3">
    </form>
</div>

<?php include '../includes/footer.php'; ?>
