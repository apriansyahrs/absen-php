<?php

require "../config.php";

$result = mysqli_query($conn, "SELECT * FROM setelan LIMIT 1");
$setelan = mysqli_fetch_assoc($result);

unset($setelan["id_setelan"], $setelan["api_maps"], $setelan["chat_id_group"], $setelan["token_bot"], $setelan["url_telegram_group"]);

$response = [
    'message' => 'Success',
    'data' => $setelan
];

header('Content-Type: application/json');
echo json_encode($response);
