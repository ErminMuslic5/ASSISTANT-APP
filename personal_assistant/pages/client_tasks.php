<?php
include '../config/config.php'; // Uključi konfiguraciju za bazu podataka
include '../includes/header.php'; // Uključi header

// Proveri da li je klijent izabran
$selectedClient = isset($_GET['client_id']) ? $_GET['client_id'] : null;

// Dohvati sve klijente za dropdown listu
$clientsSql = "SELECT * FROM clients";
$clientsResult = $conn->query($clientsSql);

// Paginacija
$tasksPerPage = 10; // Broj zadataka po stranici
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $tasksPerPage;

// Ako je klijent izabran, dohvati njegove zadatke
$tasksResult = null;
$totalTasks = 0;
$totalPages = 0;
$clientName = '';

if ($selectedClient) {
    // Dohvati ime klijenta
    $clientSql = "SELECT name FROM clients WHERE id = $selectedClient";
    $clientResult = $conn->query($clientSql);
    if ($clientResult && $clientResult->num_rows > 0) {
        $clientRow = $clientResult->fetch_assoc();
        $clientName = $clientRow['name'];
    }

    // Upit za zadatke sa ispravnim nazivom kolone
    $tasksSql = "SELECT * FROM tasks 
                 WHERE client_id = $selectedClient 
                 ORDER BY due_date DESC 
                 LIMIT $tasksPerPage OFFSET $offset"; // Promeni 'due_date' u stvarnu kolonu koja beleži vreme unosa
    $tasksResult = $conn->query($tasksSql);

    if ($tasksResult) {
        // Dohvati ukupan broj zadataka za datog klijenta radi paginacije
        $totalTasksSql = "SELECT COUNT(*) AS total FROM tasks WHERE client_id = $selectedClient";
        $totalTasksResult = $conn->query($totalTasksSql);
        if ($totalTasksResult) {
            $totalTasks = $totalTasksResult->fetch_assoc()['total'];
            $totalPages = ceil($totalTasks / $tasksPerPage);
        }
    } else {
        echo "Greška pri izvršavanju upita za zadatke: " . $conn->error;
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Pregled Zadataka po Klijentima</h2>
    <form method="GET" action="pages/client_tasks.php">

        <div class="form-group">
            <label for="client_id">Izaberi Klijenta:</label>
            <select id="client_id" name="client_id" class="form-control">
                <option value="">-- Odaberi Klijenta --</option>
                <?php while ($client = $clientsResult->fetch_assoc()): ?>
                    <option value="<?php echo $client['id']; ?>" <?php echo ($selectedClient == $client['id']) ? 'selected' : ''; ?>>
                        <?php echo $client['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Prikaži zadatke</button> <!-- Dodaj dugme za slanje -->
    </form>

    <?php if ($selectedClient && $tasksResult && $tasksResult->num_rows > 0): ?>
        <h3 class="mt-5">Zadaci za Klijenta: <?php echo $clientName; ?></h3>
        <table class="table table-striped table-hover mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Naziv Zadataka</th>
                    <th>Opis</th>
                    <th>Rok</th>
                    <th>Vreme Unosa</th>
                    <th>Status</th>
                    <th>Trošak (KM)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($task = $tasksResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $task['title']; ?></td>
                        <td><?php echo $task['description']; ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($task['due_date'])); ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($task['created_at'])); ?></td>
                        <td><?php echo ucfirst($task['status']); ?></td>
                        <td><?php echo number_format($task['cost'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Paginacija -->
        <?php if ($totalPages > 1): ?>
            <nav>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="pages/client_tasks.php?client_id=<?php echo $selectedClient; ?>&page=<?php echo $page - 1; ?>">Prethodna</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="pages/client_tasks.php?client_id=<?php echo $selectedClient; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item"><a class="page-link" href="pages/client_tasks.php?client_id=<?php echo $selectedClient; ?>&page=<?php echo $page + 1; ?>">Sledeća</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

        <?php endif; ?>

    <?php elseif ($selectedClient && $tasksResult && $tasksResult->num_rows == 0): ?>
        <p class="mt-5">Nema zadataka za izabranog klijenta.</p>
    <?php elseif ($selectedClient && !$tasksResult): ?>
        <p class="mt-5">Greška pri dohvatanju zadataka. Pokušajte ponovo kasnije.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>