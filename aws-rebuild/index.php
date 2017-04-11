<?php

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    echo 'Request method must be POST!';
    throw new Exception('Request method must be POST!');
}

//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    echo 'Content type must be: application/json';
    throw new Exception('Content type must be: application/json');
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

//Attempt to decode the incoming RAW post data from JSON.
$data = json_decode($content, true);

//Validate json
if(!is_array($data)){
    echo 'Received content contained invalid JSON!';
    throw new Exception('Received content contained invalid JSON!');
}

$time = date('Y-M-d H:i:s', time());

$columns = [];
$table = "<table width='100%'  border='1'><tr>";

$table .= "</tbody><thead><tr><th>name</th><th>values</th>";

foreach ($data as $name => $values) {
    $table .= "<tr><td>$name</td>";
    if (is_array($values))
        $values = implode(" ", $values);
    $table .= "<td>$values</td>";

    $table .= "</tr>";
}
$table .= "<td>Received at</td><td>$time</td></tr>";
$table .= "</thead></table>";

echo $table;

