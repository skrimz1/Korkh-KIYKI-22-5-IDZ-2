<?php
header("Content-Type: application/json; charset=UTF-8");

$host = '127.0.0.1';
$db = 'iteh2lb1var4';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $stmt = $pdo->prepare("INSERT INTO request_log (request_time, browser_info, latitude, longitude, endpoint) 
                           VALUES (:request_time, :browser_info, :latitude, :longitude, :endpoint)");

    $stmt->execute([
        'request_time' => $data['time'],
        'browser_info' => $data['browser'],
        'latitude' => $data['lat'],
        'longitude' => $data['lon'],
        'endpoint' => $data['endpoint']
    ]);
}

echo json_encode(["status" => "ok"]);
?>
