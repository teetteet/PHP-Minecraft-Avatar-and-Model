<?php
require_once '../MinecraftUserImage.php';

try {
    if(isset($_GET['username'])) {
        $helm = isset($_GET['helm']) && $_GET['helm'] == 'false' ? false : true;
        $size = empty($_GET['size']) ? 64 : $_GET['size'];
        $mui = new MinecraftUserImage($_GET['username'], $helm);
        $mui->create_avatar($size)->display_avatar();
    }
} catch(MinecraftUserImage_Exception $e) {
    echo '<strong>Error:</strong> '.$e->getMessage();
}