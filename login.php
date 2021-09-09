<?php declare(strict_types=1);

function connect():PDO
{
    $pdo=new PDO('mysql:host=localhost;dbname=ID_PASS;charset=utf8mb4','root','mariadb');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        return $pdo;
}

session_start();
//メインルーチン
try{
    if(!isset($_GET['UserID']) || trim($_GET['UserID']) === ''){
        //UserIDが未入力だとloginページに戻る
        header('HTTP/1.1 307 Temporary Redirect');        
        header('refresh:5;url= http://localhost/~itsys/login/login.html');
        echo 'UserIDが未入力です。3秒後にloginページに移動します。';
        return;
    }


    $pdo=connect();
    $statement=$pdo->prepare('SELECT * FROM ID_PASS WHERE UserID=:UserID ORDER BY id DESC');
    $statement->bindValue(':UserID',$_GET['UserID'],PDO::PARAM_STR);
    $statement->execute();
}catch(PDOException $e){
    echo 'システムエラー';
    echo  $e;
    return;
}

$row=$statement->fetch(PDO::FETCH_ASSOC);


if($row['Pass']===$_GET['Pass']){    
    // $_SESSION['login'] = true;
    //商品登録画面へ遷移
    header('HTTP/1.1 307 Temporary Redirect');
    // header('refresh:3;url= http://localhost/~itsys/convenience_Store/items.html');
    header('refresh:3;url='.$row['link']);
    echo 'ログイン成功';
    echo '<br>';
    echo '3秒後に商品入力ページに移動します。';
    return;

}elseif($row['UserID']===$_GET['UserID']){
    header('HTTP/1.1 307 Temporary Redirect');
    header('refresh:3;url= http://localhost/~itsys/login/login.html');
    echo 'ログイン失敗';
    echo '<br>';
    echo 'PASSが間違っています。';
    echo '<br>';
    echo '3秒後にログインページに移動します。';
}else{
    header('HTTP/1.1 307 Temporary Redirect');
    header('refresh:3;url= http://localhost/~itsys/login/login.html');
    echo 'ログイン失敗';
    echo '<br>';
    echo 'UserIDがありません。';
    echo '<br>';
    echo '3秒後にログインページに移動します。';
}
?>


