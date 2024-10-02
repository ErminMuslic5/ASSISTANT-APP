<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Dodaj base tag kako bi se sve relativne putanje odnosile na root projekta -->
    <base href="/personal_assistant/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <base href="/personal_assistant/">

    <title>Personal Assistant App</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Assistant App</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Početna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/clients.php">Klijenti</a> <!-- Relativna putanja ka clients.php -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/tasks.php">Zadaci</a> <!-- Relativna putanja ka tasks.php -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/client_tasks.php">Pregled Zadataka</a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <main class="container mt-5">