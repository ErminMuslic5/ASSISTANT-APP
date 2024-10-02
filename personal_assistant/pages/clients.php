<?php
include '../config/config.php'; // Uključi konfiguraciju za bazu podataka
include '../includes/header.php'; // Uključi header

// Dohvatanje svih klijenata iz baze podataka
$sql = "SELECT * FROM clients";
$result = $conn->query($sql);
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Lista Klijenata</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>Budžet</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['budget']; ?></td>
                                <td>
                                <a href="/personal_assistant/pages/edit_client.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Uredi</a>

                                <a href="/personal_assistant/pages/delete_client.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete();">Obriši</a>





                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Nema klijenata</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="mt-5">Dodaj Novog Klijenta</h3>
    <form action="pages/add_client.php" method="POST"> <!-- Apsolutna putanja -->

        <label for="name">Ime:</label>
        <input type="text" id="name" name="name" class="form-control" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" required>
        <label for="phone">Telefon:</label>
        <input type="text" id="phone" name="phone" class="form-control">
        <label for="budget">Budžet:</label>
        <input type="number" step="0.01" id="budget" name="budget" class="form-control" required>
        <input type="submit" value="Dodaj Klijenta" class="btn btn-primary mt-3">
    </form>
</div>

<?php include '../includes/footer.php'; ?>
