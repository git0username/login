<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/functions.php';


// function connect():PDO
// {
//     $pdo=new PDO('mysql:host=localhost;dbname=convenience;charset=utf8mb4','root','mariadb');
//         $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//         $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
//         return $pdo;
// }

?>

<?php
echo $_POST['item-name'];
echo '<br>';
echo $_POST['item-price'];
echo '<br>';
echo $_POST['item-quantity'];
echo '<br>';
echo $_POST['item-expiry'];
echo '<br>';

try{
    $pdo=connect();
    $statement = $pdo->prepare('INSERT INTO products(created, name, price, quantity,expirydate)VALUES(CURRENT_TIMESTAMP, :name, :price, :quantity, :expirydate)');
    $statement->bindValue(':name',$_POST['item-name'],PDO::PARAM_STR);
    $statement->bindValue(':price',$_POST['item-price'],PDO::PARAM_INT);
    $statement->bindValue(':quantity',$_POST['item-quantity'],PDO::PARAM_INT);
    $statement->bindValue(':expirydate',$_POST['item-expiry'],PDO::PARAM_STR);
    $statement->execute();
    $newId = $pdo->lastInsertId();
    echo '新しい商品を登録しました。新しいレコードIDは',$newId,'です。';
}catch(PDOException $e){
    echo '新しい商品の登録に失敗しました。';
    echo $e;
}

?>
