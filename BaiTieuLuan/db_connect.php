<?php
const HOST ='localhost';
const U = 'root';
const P='';
const DB='ql_ddsv';
try {
    $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DB, U, P);
    $conn->query('set names utf8');
} catch (PDOException $e) {
    echo 'Err';
    exit;
}
?>
