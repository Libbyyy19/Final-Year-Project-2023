<?php

$email = $_POST['email'];
$password = $_POST['password'];

$file = fopen('users.txt.', 'r');

while (($line = fgets($file)) !== false) {
    $fields = explode(',', $line);
    if($fields[2] == $email && $fields[3] == $password) {
        break;
    }
}

fclose($file);


sleep(3);

header("Location: homepage1.html");
exit;