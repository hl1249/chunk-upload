<?php
	$data = $_POST;
	$file = $_FILES['file'];
	header('Access-Control-Allow-Origin:*');
	$public_dir ='./public';
	$dir = '/uploads/attach/' . date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d');
	$all_dir = $public_dir . $dir;
	if (!is_dir($all_dir)) mkdir($all_dir, 0777, true);
	$filename = $all_dir . '/' . $data['filename'] . '__' . $data['chunkNumber'];
	move_uploaded_file($file['tmp_name'], $filename);
	$res['code'] = 0;
	$res['msg'] = 'error';
	$res['file_path'] = '';
	if ($data['chunkNumber'] == $data['totalChunks']) {
		$blob = '';
		for ($i = 1; $i <= $data['totalChunks']; $i++) {
			$blob .= file_get_contents($all_dir . '/' . $data['filename'] . '__' . $i);
		}
		file_put_contents($all_dir . '/' . $data['filename'], $blob);
	// 	for ($i = 1; $i <= $data['totalChunks']; $i++) {
	// 		@unlink($all_dir . '/' . $data['filename'] . '__' . $i);
	// 	}
	// 	if (file_exists($all_dir . '/' . $data['filename'])) {
	// 		$res['code'] = 2;
	// 		$res['msg'] = 'success';
	// 		$res['file_path'] = $dir . '/' . $data['filename'];
	// 	}
	// } else {
	// 	if (file_exists($all_dir . '/' . $data['filename'] . '__' . $data['chunkNumber'])) {
	// 		$res['code'] = 1;
	// 		$res['msg'] = 'waiting';
	// 		$res['file_path'] = '';
	// 	}
	}else{
		$array = array(
			'code'=> 200,
			'count'=>$data['chunkNumber']
		);
		echo json_encode($array);
	}