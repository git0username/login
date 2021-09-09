<?php

declare(strict_types=1);


function connect(): PDO
{
    $pdo = new PDO('mysql:host=localhost;dbname=ID_PASS;charset=utf8mb4', 'root', 'mariadb');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
}



try {
    $pdo = connect();

    $statement = $pdo->prepare('SELECT * FROM ID_PASS WHERE UserID=:UserID ORDER BY id DESC');
    $statement->bindValue(':UserID', $_POST['UserID'], PDO::PARAM_STR);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row['UserID'] == $_POST['UserID']) {
        header('HTTP/1.1 307 Temporary Redirect');
        header('refresh:3;url= http://localhost/~itsys/login/new_register.html');
        echo '入力されたID：', $_POST['UserID'];
        echo '<br>';
        echo '異なるIDで登録してください。';
        echo '<br>';
        echo '3秒後に新規登録ページに移動します。';
        exit();
    } else {
        //正規表現でPassを確認
        if (preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['Pass'])) {

            $statement = $pdo->prepare('INSERT INTO ID_PASS(created,UserID,Pass)VALUES(CURRENT_TIMESTAMP, :UserID, :Pass)');
            $statement->bindValue(':UserID', $_POST['UserID'], PDO::PARAM_STR);
            $statement->bindValue(':Pass', $_POST['Pass'], PDO::PARAM_STR);
            $statement->execute();
            echo '新しいIDを登録しました。';
        } else {
            header('HTTP/1.1 307 Temporary Redirect');
            header('refresh:5;url= http://localhost/~itsys/login/new_register.html');
            echo 'Passには、';
            echo '<br>';
            echo 'アルファベットの大文字・小文字、数字をそれぞれ一つずつ含め、全文字数を8字以上16字以下にして下さい。';
            echo '<br>';
            echo '5秒後に新規登録ページに移動します。'; 
        }
    }
} catch (PDOException $e) {
    echo 'system error 新しいIDの登録に失敗しました。';
    echo $e;
}


?>