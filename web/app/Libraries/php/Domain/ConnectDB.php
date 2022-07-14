<?php

namespace App\Libraries\php\Domain;

use PDO;

/**
 * データベースに接続するクラス
 */

class ConnectDB
{
    public static function connect_db()
    {
        $dsn = 'mysql:dbname=attendance_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
