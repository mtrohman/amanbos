<?php
    $dir_root= $_SERVER['DOCUMENT_ROOT']."";
    $dir_autoload=  $dir_root."/vendor/autoload.php";
    include_once $dir_autoload;
    include_once "db.php";
    //If you want the errors to be shown
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    use Illuminate\Database\Capsule\Manager as Capsule;

    $capsule = new Capsule;

    $capsule->addConnection([
        "driver" => "mysql",
        "host" => $server,
        "database" => $db,
        "username" => $user,
        "password" => $pass
    ]);
    //Make this Capsule instance available globally.
    $capsule->setAsGlobal();
    // Setup the Eloquent ORM.
    $capsule->bootEloquent();
?>