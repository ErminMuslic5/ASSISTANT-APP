<?php
include '../config/config.php'; // Uključi konfiguraciju za bazu podataka
include '../includes/header.php'; // Uključi header

// Provera da li je prosleđen ID zadatka putem URL-a
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Dohvatanje trenutnih podataka o zadatku iz baze podataka
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "Zadatak nije pronađen.";
        exit();
    }
} else {
    echo "ID zadatka nije prosleđen.";
    exit();
}

// Ažuriranje podataka zadatka
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $new_cost = $_POST['cost'];

    // Dohvatanje prethodnog troška zadatka
    $previous_cost = $task['cost'];

    // Ažuriranje zadatka u bazi podataka
    $sql = "UPDATE tasks SET 
            client_id = '$client_id', 
            title = '$title', 
            description = '$description', 
            due_date = '$due_date', 
            cost = '$new_cost' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Ažuriranje budžeta klijenta ako se trošak promenio
        if ($new_cost != $previous_cost) {
            $cost_difference = $previous_cost - $new_cost;
            $updateBudgetSql = "UPDATE clients SET budget = budget + $cost_difference WHERE id = $client_id";
            $conn->query($updateBudgetSql);
        }

        echo "Informacije o zadatku su uspešno ažurirane.";
        // Redirektuj na stranicu sa zadacima nakon ažuriranja
        header("Location: tasks.php");
        exit();
    } else {
        echo "Greška: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container">
    <h2 class="mb-4">Uredi Zadatak</h2>
    <form action="/personal_assistant/pages/edittask.php?id=<?php echo $task['id']; ?>" method="POST" class="card p-4">


        <div class="form-group">
            <label for="client_id">Klijent:</label>
            <select id="client_id" name="client_id" class="form-control" required>
                <option value="">Izaberi klijenta</option>
                <?php
                $clientSql = "SELECT * FROM clients";
                $clientResult = $conn->query($clientSql);
                while ($client = $clientResult->fetch_assoc()) {
                    $selected = ($client['id'] == $task['client_id']) ? 'selected' : '';
                    echo "<option value='" . $client['id'] . "' $selected>" . $client['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Naziv Zadataka:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?php echo $task['title']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Opis:</label>
            <textarea id="description" name="description" class="form-control" rows="3"><?php echo $task['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="due_date">Rok:</label>
            <input type="datetime-local" id="due_date" name="due_date" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($task['due_date'])); ?>">
        </div>
        <div class="form-group">
            <label for="cost">Trošak (KM):</label>
            <input type="number" step="0.01" id="cost" name="cost" class="form-control" value="<?php echo $task['cost']; ?>" required>
        </div>
        <input type="submit" value="Ažuriraj Zadatak" class="btn btn-primary mt-3">
    </form>
</div>

<?php include '../includes/footer.php'; ?>
