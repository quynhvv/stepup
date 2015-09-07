<?php
$host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
$ssh = getHostByName(getHostName());
$mongodb = '';
if (in_array($host, ['api.bibomart.com.vn', 'tuvan.bibomart.com.vn', 'bizo.bibomart.com.vn']) OR $ssh == '123.30.186.13') {
    $mongodb = 'mongodb://bibomart:bibomartcomvn@tuvan.bibomart.com.vn:27017/bibomart';
} elseif (in_array($host, ['stepup.goldsea.vn'])) {
    $mongodb = 'mongodb://letyii:letyii@let.vn:27017/letyii';
} else {
    $mongodb = 'mongodb://letyii:letyii@localhost:27017/letyii';
}

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=letyii', // MySQL, MariaDB
            //'dsn' => 'sqlite:/path/to/database/file', // SQLite
            //'dsn' => 'pgsql:host=localhost;port=5432;dbname=mydatabase', // PostgreSQL
            //'dsn' => 'cubrid:dbname=demodb;host=localhost;port=33000', // CUBRID
            //'dsn' => 'sqlsrv:Server=localhost;Database=mydatabase', // MS SQL Server, sqlsrv driver
            //'dsn' => 'dblib:host=localhost;dbname=mydatabase', // MS SQL Server, dblib driver
            //'dsn' => 'mssql:host=localhost;dbname=mydatabase', // MS SQL Server, mssql driver
            //'dsn' => 'oci:dbname=//localhost:1521/mydatabase', // Oracle
            'username' => 'root',
            'password' => 'handsom3000',
            'charset' => 'utf8',
            'tablePrefix' => 'letyii_',
            'enableSchemaCache' => TRUE,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => $mongodb,
        ],
        'bibomart' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.3.1;dbname=bibomart', // MySQL, MariaDB
            'username' => 'sql_bbm',
            'password' => 'M32N6Rawwka68B2josao',
            'charset' => 'utf8',
            'tablePrefix' => '',
            'enableSchemaCache' => TRUE,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],

//        'redis' => [
//            'class' => 'yii\redis\Connection',
//            'hostname' => 'localhost',
//            'port' => 6379,
//            'database' => 0,
//        ],
    ],
];
