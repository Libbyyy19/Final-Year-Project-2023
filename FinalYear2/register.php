<?php


$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confpassword = $_POST['confpass'];

$file = fopen('users.txt', 'a');

if ($file) {
    echo "File opened successfully\n";
} else {
    echo "File could not be opened\n";
}

fwrite($file,$name . ',' . $email . ',' . $password . ',' . $confpassword . "\n");

fclose($file);

