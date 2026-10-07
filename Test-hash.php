<?php
$plain = '123456';
$hash = password_hash($plain, PASSWORD_DEFAULT);

echo "Hash: " . $hash . "<br>";

if (password_verify('123456', $hash)) {
    echo "OK: password_verify passed<br>";
} else {
    echo "ERROR: password_verify failed<br>";
}

 ?>