<?php
require_once '../MinecraftUserImage.php';

try {
    if(isset($_GET['username'])) {
        $size = empty($_GET['size']) ? 64 : $_GET['size'];
        $mui = new MinecraftUserImage($_GET['username']);
        $mui->create_model($size);
        $mui->display_model();
    }
} catch(MinecraftUserImage_Exception $e) {
    echo '<strong>Error:</strong> '.$e->getMessage();
}