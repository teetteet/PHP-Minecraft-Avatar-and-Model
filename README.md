# Minecraft User Image #
A PHP class to create avatars and model images of Minecraft players.

## Restrictions ##
- The user must be valid and have a skin
- The specified size must be an equal number as to not compromise the symmetrical nature of the minecraft skins.

## Creating an avatar ##
Creating and displaying the avatar is simple. Say we have the $_GET variable username providing the username and the $__GET variable size providing the size, we would create a file like this.

```php
<?php
require_once '../MinecraftUserImage.php';

try {
    if(isset($_GET['username'])) {
        $helm = isset($_GET['helm']) && $_GET['helm'] == 'false' ? false : true;
        $size = empty($_GET['size']) ? 64 : $_GET['size'];
        $mui = new MinecraftUserImage($_GET['username'], $helm);
        $mui->create_avatar($size);
        $mui->display_avatar();
    }
} catch(MinecraftUserImage_Exception $e) {
    echo '<strong>Error:</strong> '.$e->getMessage();
}
?>
```
> The above code is available in examples/avatar.php

## Creating a model ##
Creating and displaying a model is simple. Say we have the $_GET variable username providing the username and the $__GET variable size providing the size, we would create a file like this.

```php
<?php
require_once '../MinecraftUserImage.php';

try {
    if(isset($_GET['username'])) {
        $helm = isset($_GET['helm']) && $_GET['helm'] == 'false' ? false : true;
        $size = empty($_GET['size']) ? 64 : $_GET['size'];
        $mui = new MinecraftUserImage($_GET['username'], $helm);
        $mui->create_model($size);
        $mui->display_model();
    }
} catch(MinecraftUserImage_Exception $e) {
    echo '<strong>Error:</strong> '.$e->getMessage();
}
?>
```
> The above code is available in examples/model.php

Or if you want a page that allows both.

```php
<?php
require_once 'MinecraftUserImage.php';

try {
    if(isset($_GET['username'])) {
		$helm = isset($_GET['helm']) && $_GET['helm'] == 'false' ? false : true;
        $size = empty($_GET['size']) ? 64 : $_GET['size'];
        $mui = new MinecraftUserImage($_GET['username'], $helm);
		$type = isset($_GET['type']) && $_GET['type'] == 'model' ? 'model' : 'type';
		
		if($type == 'avatar') {
			$mui->create_avatar($size);
			$mui->display_avatar();
		} else {
			$mui->create_model($size);
			$mui->display_model();
		}
    }
} catch(MinecraftUserImage_Exception $e) {
    echo '<strong>Error:</strong> '.$e->getMessage();
}
?>
```
