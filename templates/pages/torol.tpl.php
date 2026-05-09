<?php
include __DIR__ . "/../../db.php";

$id = $_GET['id'] ?? null;
if (!$id) die("Hiányzó ID");

$stmt = $pdo->prepare("DELETE FROM tavasz WHERE sorszam=?");
$stmt->execute([$id]);

header("Location: index.php?oldal=crud");
exit;