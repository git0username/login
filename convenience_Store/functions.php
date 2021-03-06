<?php
declare(strict_types=1);
/**
 * PDOインスタンスを取得する関数
 */
function connect():PDO
{
    $pdo=new PDO('mysql:host=localhost;dbname=convenience;charset=utf8mb4','root','mariadb');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    return $pdo;
}
/**
 * HTMLエスケープする関数
 */
function escape($value){
    return htmlspecialchars(strval($value),ENT_QUOTES | ENT_HTML5,'UTF-8');
}