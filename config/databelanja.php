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
$table = 'belanja';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 
        'db' => '`b`.`ta`', 
        'dt' => 0,
        'field' => 'ta' 
    ),
    array( 
        'db' => '`b`.`triwulan`',     
        'dt' => 1 ,
        'field' => 'triwulan'
    ),
    array( 
        'db' => '`b`.`npsn`',  
        'dt' => 2 ,
        'field' => 'npsn'
    ),
    array( 
        'db' => '`s`.`nama_sekolah`',   
        'dt' => 3 ,
        'field' => 'nama_sekolah'
    ),
    array( 
        'db' => '`b`.`tanggal_belanja`',     
        'dt' => 4 ,
        'field' => 'tanggal_belanja',
        'formatter' => function($d, $row){
            return tgl_indo($d);
        },
    ),
    array( 
        'db' => '`b`.`belanja`',     
        'dt' => 5 ,
        'field' => 'belanja'
    ),
    array( 
        'db' => '`b`.`harga`',     
        'dt' => 6 ,
        'formatter' => function($d, $row){
            return rupiah($d);
        },
        'field' => 'harga'
    ),
    array( 
        'db' => '`pr`.`kode_program`',
        'dt' => 7,
        'field' => 'kode_program'
    ),
    array( 
        'db' => '`kp`.`kode_pembiayaan`',
        'dt' => 8,
        'field' => 'kode_pembiayaan'
    ),
    array( 
        'db' => '`kr`.`nama_rekening`',
        'dt' => 9,
        'field' => 'nama_rekening'
    ),
    array( 
        'db' => '`kr`.`jenis`',
        'dt' => 10,
        'field' => 'jenis'
    ),
    // array( 
    //     'db' => '`r`.`anggaran_belanja`',     
    //     'dt' => 7 ,
    //     'formatter' => function($d, $row){
    //         return rupiah($d);
    //     },
    //     'field' => 'anggaran_belanja'
    // ),
    // array( 
    //     'db' => '`r`.`realisasi_belanja`',
    //     'dt' => 8 ,
    //     'formatter' => function($d, $row){
    //         return rupiah($d);
    //     },
    //     'field' => 'realisasi_belanja'
    // ),
    // array( 
    //     'db' => '`r`.`persentasi_belanja`',
    //     'dt' => 9,
    //     'formatter' => function($d, $row){
    //         return number_format($d, 2, ',', '.').'%';
    //     },
    //     'field' => 'persentasi_belanja'
    // ),
    array( 
        'db' => '`b`.`id`',     
        'dt' => 11 ,
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

$joinQuery = "FROM `belanja` AS `b`
JOIN `sekolah` AS `s` ON (`b`.`npsn` = `s`.`npsn`)
JOIN `kodeprogram` AS `pr` ON (`b`.`kode_program`=`pr`.`id`)
JOIN `kodepembiayaan` AS `kp` ON (`b`.`kode_pembiayaan`=`kp`.`id`)
JOIN `koderekening` AS `kr` ON (`b`.`kode_rekening`=`kr`.`id`)
";

$extraWhere = ""; 

echo json_encode(
    // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, null, null)
);