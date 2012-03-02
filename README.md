# Minecraft User Image #
A PHP class to create avatars and model images of Minecraft players.

## Creating an avatar ##
Creating and displaying the avatar is simple. Say we have the $_GET variable username providing the username and the $__GET variable size providing the size, we would create a file like this.

```php
require_once '../MinecraftUserImage.php';

try {
    if(isset($_GET['username'])) {
        $size = empty($_GET['size']) ? 64 : $_GET['size'];
        $mui = new MinecraftUserImage($_GET['username']);
        $mui->create_avatar($size);
        $mui->display_avatar();
    }
} catch(MinecraftUserImage_Exception $e) {
    echo '<strong>Error:</strong> '.$e->getMessage();
}
```
> The above code is available in examples/avatar.php

## Creating a model ##
Creating and displaying a model is simple. Say we have the $_GET variable username providing the username and the $__GET variable size providing the size, we would create a file like this.

```php
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
```
> The above code is available in examples/model.php