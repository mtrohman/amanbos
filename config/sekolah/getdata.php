<?php
    use App\Models\Sekolah;

    include_once '../db.php';
    require_once '../dbmanager.php';

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $offset = ($page-1)*$rows;

    if (!empty($_POST)) {
        $request = (object)$_POST;
    }

	$pagu= Sekolah::with(['kecamatannya'])->skip($offset)->take($rows)->get();
    $pagucount= Sekolah::count();
	$result = array();
	$result["total"] = $pagucount;
	$result["rows"] = $pagu;
	
	echo json_encode($result);
?>