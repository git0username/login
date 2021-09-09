<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/functions.php';

//メインルーチン
try{
    if(!isset($_GET['search-name']) || trim($_GET['search-name']) === ''){
        return;
    }
    $pdo=connect();
    $statement=$pdo->prepare('SELECT * FROM products WHERE name LIKE :name ORDER BY expirydate DESC');
    $statement->bindValue(':name','%'.$_GET['search-name'].'%',PDO::PARAM_STR);
    $statement->execute();
}catch(PDOException $e){
    echo '商品の検索に失敗しました。';
    return;
}
?>
<body>
    <h3>商品名に「[<?=escape($_GET['search-name'])?>」を含む商品の検索結果</h3>
    <table border="1">
        <tr>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>消費期限</th>
        </tr>
        <?php while ($row=$statement->fetch(PDO::FETCH_ASSOC)):?>
        <tr>
        <td><?=escape($row['name'])?></td>
        <td><?=escape(number_format($row['price']))?>円</td>
        <td><?=escape($row['quantity'])?></td>
        <td><?=escape($row['expirydate'])?></td>
        </tr>
        <?php endwhile; ?>
        </table>
</body>