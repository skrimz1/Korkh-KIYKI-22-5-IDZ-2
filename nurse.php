<?php
header("Content-Type: text/html; charset=UTF-8");

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

$nurse_id = $_GET['nurse_id'] ?? null;

if ($nurse_id) {
    $stmt = $pdo->prepare("SELECT w.name FROM ward w
                           JOIN nurse_ward nw ON w.id_ward = nw.fid_ward
                           WHERE nw.fid_nurse = :nurse_id");
    $stmt->execute(['nurse_id' => $nurse_id]);
    $wards = $stmt->fetchAll();

    echo "<h2>Палати, у яких чергує медсестра з ID $nurse_id:</h2>";
    if (!empty($wards)) {
        foreach ($wards as $ward) {
            echo $ward['name'] . "<br>";
        }
    } else {
        echo "Медсестра з ID $nurse_id не знайдена або не має призначених палат.<br>";
    }
}
?>