<?php



//get

$url = "https://jsonplaceholder.typicode.com/users";

$resource = curl_init($url);
curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($resource);
$info = curl_getinfo($resource, CURLINFO_HTTP_CODE);
curl_close($resource);
echo '<pre>';
var_dump($info);
echo '</pre>';

echo '<pre>';
var_dump($result);
echo '</pre>';


//post

$user = [
    'name' => 'MMM',
    'username' => 'mmm',
    'email' => 'mm@mmm.com'
];

$resource = curl_init();
curl_setopt_array($resource, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['content-type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($user),
]);

$result = curl_exec($resource);

echo $result;

curl_close($resource);

