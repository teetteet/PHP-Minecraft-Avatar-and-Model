<?php
require_once '../MinecraftUserImage.php';

try {
    if(isset($_GET['username'])) {
		$helm = isset($_GET['helm']) && $_GET['helm'] == 'false' ? false : true;
        $size = empty($_GET['size']) ? 64 : $_GET['size'];
        $mui = new MinecraftUserImage($_GET['username'], $helm);
		$type = isset($_GET['type']) && $_GET['type'] == 'model' ? 'model' : 'type';
		
		if($type == 'avatar') {
			$mui->create_avatar($size)->display_avatar();
		} else {
			$mui->create_model($size)->display_model();
		}
    }
} catch(MinecraftUserImage_Exception $e) {
    echo '<strong>Error:</strong> '.$e->getMessage();
}
?>