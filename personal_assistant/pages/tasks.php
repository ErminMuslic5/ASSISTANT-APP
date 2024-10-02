<?php
include '../config/config.php'; // Uključi konfiguraciju za bazu podataka
include '../includes/header.php'; // Uključi header

// Dohvatanje svih taskova i pridruženih klijenata iz baze podataka
$sql = "SELECT tasks.*, clients.name AS client_name FROM tasks
        JOIN clients ON tasks.client_id = clients.id";
$result = $conn->query($sql);

// Funkcija za formatiranje datuma
function formatDate($date)
{
    return date('d-m-Y H:i', strtotime($date));
}
?>

<div class="container">
    <h2 class="mb-4">Lista Zadataka</h2>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Klijent</th>
                <th>Naziv Zadataka</th>
                <th>Opis</th>
                <th>Rok</th>
                <th>Status</th>
                <th>Trošak (KM)</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['client_name']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo formatDate($row['due_date']); ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td><?php echo number_format($row['cost'], 2); ?></td>
                        <td>
                            <a href="pages/edittask.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Uredi</a>

                            <a href="pages/deletetask.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete();">Obriši</a>

                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Nema zadataka</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3 class="mt-5">Dodaj Novi Zadatak</h3>
    <form action="pages/add_task.php" method="POST" class="card p-4">
        <div class="form-group">
            <label for="client_id">Klijent:</label>
            <select id="client_id" name="client_id" class="form-control" required>
                <option value="">Izaberi klijenta</option>
                <?php
                $clientSql = "SELECT * FROM clients";
                $clientResult = $conn->query($clientSql);
                while ($client = $clientResult->fetch_assoc()) {
                    echo "<option value='" . $client['id'] . "'>" . $client['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Naziv Zadataka:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Opis:</label>
            <textarea id="description" name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="due_date">Rok:</label>
            <input type="datetime-local" id="due_date" name="due_date" class="form-control">
        </div>
        <div class="form-group">
            <label for="cost">Trošak (KM):</label>
            <input type="number" step="0.01" id="cost" name="cost" class="form-control" required>
        </div>
        <input type="submit" value="Dodaj Zadatak" class="btn btn-primary mt-3">
    </form>
</div>

<script>
    // Potvrda pre brisanja zadatka
    function confirmDelete() {
        return confirm("Da li ste sigurni da želite obrisati ovaj zadatak?");
    }
</script>

<?php include '../includes/footer.php'; ?>