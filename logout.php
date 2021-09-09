<?php declare(strict_types=1);

function connect():PDO
{
    $pdo=new PDO('mysql:host=localhost;dbname=ID_PASS;charset=utf8mb4','root','mariadb');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        return $pdo;
}

// echo 'logout';
// session_start();
// deleteSession();
// session_destroy();

header('HTTP/1.1 307 Temporary Redirect');
header('Location: http://localhost/~itsys/login/login.html');

?>