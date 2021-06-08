<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=task5', 'root');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>