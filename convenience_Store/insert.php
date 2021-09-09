<?php declare(strict_types=1);
function connect():PDO
{
    $pdo=new PDO('mysql:host=localhost;dbname=convenience;charset=utf8mb4','root','mariadb');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        return $pdo;
}
?>

<body>
    <?php
    try{
        $pdo=connect();
        $statement = $pdo->prepare('INSERT INTO products(created, name, price, quantity,expirydate)VALUES(CURRENT_TIMESTAMP, :name, :price, :quantity, :expirydate)');
        $statement->bindValue(':name','サンドイッチ',PDO::PARAM_STR);
        $statement->bindValue(':price',130,PDO::PARAM_INT);
        $statement->bindValue(':quantity',5,PDO::PARAM_INT);
        $statement->bindValue(':expirydate','2021-08-20',PDO::PARAM_STR);
        $statement->execute();
        $newId = $pdo->lastInsertId();
        echo '新しい商品を登録しました。新しいレコードIDは',$newId,'です。';
    }catch(PDOException $e){
        echo '新しい商品の登録に失敗しました。';
        echo $e;
    }
?>
</body>