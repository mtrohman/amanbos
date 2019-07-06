<?php
    include_once 'db.php';
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'saldotriwulan';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 
        'db' => '`s`.`ta`', 
        'dt' => 2,
        'field' => 'tahun' 
    ),
    array( 
        'db' => '`s`.`npsn`',  
        'dt' => 3 ,
        'field' => 'npsn'
    ),
    array( 
        'db' => '`sk`.`nama_sekolah`',   
        'dt' => 0 ,
        'field' => 'nama_sekolah'
    ),
    array( 
        'db' => '`s`.`triwulan`',     
        'dt' => 1 ,
        'field' => 'triwulan'
    ),
    array( 
        'db' => '`r`.`anggaran_pendapatan`',     
        'dt' => 4 ,
        'formatter' => function($d, $row){
            return rupiah($d);
        },
        'field' => 'anggaran_pendapatan'
    ),
    array( 
        'db' => '`r`.`realisasi_pendapatan`',     
        'dt' => 5 ,
        'formatter' => function($d, $row){
            return rupiah($d);
        },
        'field' => 'realisasi_pendapatan'
    ),
    array( 
        'db' => '`r`.`persentasi_pendapatan`',
        'dt' => 6,
        'formatter' => function($d, $row){
            return number_format($d, 2, ',', '.').'%';
        },
        'field' => 'persentasi_pendapatan'
    ),
    array( 
        'db' => '`r`.`anggaran_belanja`',     
        'dt' => 7 ,
        'formatter' => function($d, $row){
            return rupiah($d);
        },
        'field' => 'anggaran_belanja'
    ),
    array( 
        'db' => '`r`.`realisasi_belanja`',
        'dt' => 8 ,
        'formatter' => function($d, $row){
            return rupiah($d);
        },
        'field' => 'realisasi_belanja'
    ),
    array( 
        'db' => '`r`.`persentasi_belanja`',
        'dt' => 9,
        'formatter' => function($d, $row){
            return number_format($d, 2, ',', '.').'%';
        },
        'field' => 'persentasi_belanja'
    ),
    array( 
        'db' => '`r`.`id`',     
        'dt' => 10 ,
        'field' => 'id'
    )

    // array(
    //     'db'        => 'start_date',
    //     'dt'        => 4,
    //     'formatter' => function( $d, $row ) {
    //         return date( 'jS M y', strtotime($d));
    //     }
    // ),
    // array(
    //     'db'        => 'salary',
    //     'dt'        => 5,
    //     'formatter' => function( $d, $row ) {
    //         return '$'.number_format($d);
    //     }
    // )
);
 
// SQL server connection information
$sql_details = array(
    'user' => $user,
    'pass' => $pass,
    'db'   => $db,
    'host' => $server
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
// require( 'ssp.class.php' );
require( 'ssp.customized.class.php' );

$joinQuery = "FROM `saldotriwulan` AS `s`
JOIN `sekolah` AS `sk` ON (`s`.`npsn` = `sk`.`npsn`)";

$extraWhere = ""; 

echo json_encode(
    // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, null, null)
);