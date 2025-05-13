<?php
header("Content-Type: application/json; charset=UTF-8");

$host = '127.0.0.1';
$db = 'iteh2lb1var4';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$shift = $_GET['shift'] ?? null;

$response = [];

if ($shift) {
    $stmt = $pdo->prepare("SELECT n.name, w.name as ward_name FROM nurse n
                           JOIN nurse_ward nw ON n.id_nurse = nw.fid_nurse
                           JOIN ward w ON nw.fid_ward = w.id_ward
                           WHERE n.shift = ?");
    $stmt->execute([$shift]);
    $response = $stmt->fetchAll();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
