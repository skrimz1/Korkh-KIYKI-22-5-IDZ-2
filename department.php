<?php
header("Content-Type: application/xml; charset=UTF-8");

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

$department_id = $_GET['department_id'] ?? null;

$xml = new SimpleXMLElement('<nurses/>');

if ($department_id) {
    $stmt = $pdo->prepare("SELECT name FROM nurse WHERE department = ?");
    $stmt->execute([$department_id]);
    $nurses = $stmt->fetchAll();

    foreach ($nurses as $nurse) {
        $nurseElement = $xml->addChild('nurse');
        $nurseElement->addChild('name', $nurse['name']);
    }
}

echo $xml->asXML();
?>
