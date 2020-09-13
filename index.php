<?php
/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=TestDataBase;host=mysql-server;';
$user = 'root';
$password = 'secret';

try {
    $dbh = new PDO($dsn, $user, $password);
    echo 'SUCCESSFULLY CONNECTED TO MYSQL </br>';
    
    $sql = 'SELECT * FROM test';
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $arr = $sth->fetchAll();
    
    // TestDataBase -> test -> idx:1,name:Alice,age:22
    echo $arr[0][1] . ' is ' . $arr[0][2] . ' years old.';
    echo '</br>';

    // TestDataBase -> test -> idx:2,name:Bob,age:23
    echo $arr[1][1] . ' is ' . $arr[1][2] . ' years old.';
    echo '</br>';

    phpinfo();
    
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>