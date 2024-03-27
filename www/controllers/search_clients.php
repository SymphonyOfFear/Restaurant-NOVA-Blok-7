<?php
require '../database.php';

$searchTerm = $_GET['q'] ?? '';

$query = "SELECT gebruiker_id, voornaam, achternaam FROM Gebruiker WHERE voornaam LIKE :searchTerm OR achternaam LIKE :searchTerm LIMIT 10";
$stmt = $conn->prepare($query);
$stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<div onclick=\"selectClient('{$row['gebruiker_id']}', '{$row['voornaam']} {$row['achternaam']}')\">";
    echo htmlspecialchars($row['voornaam'] . " " . $row['achternaam']);
    echo "</div>";
}
