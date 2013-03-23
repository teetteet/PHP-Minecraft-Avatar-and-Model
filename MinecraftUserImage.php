<?php
/**
 * Minecraft User Image
 * 
 * Generate an avatar or body model of a minecraft user.
 * 
 * @author Ollie Read <me@ollieread.com>
 * @package minecraftUserImage
 */
class MinecraftUserImage {
    /**
     * Username of user
     * @var string 
     */
    private $_username;
    /**
     * Avatar width
     * @var int 
     */
    private $_avatarX;
    /**
     * Avatar height
     * @var int 
     */
    private $_avatarY;
    /**
     * Image resource for avatar
     * @var resource 
     */
    private $_avatar;
    /**
     * Model width
     * @var iny 
     */
    private $_modelX;
    /**
     * Model height
     * @var iny 
     */
    private $_modelY;
    /**
     * Image resource for model
     * @var resource 
     */
    private $_model;
    /**
     * Image resource from skin
     * @var string 
     */
    private $_skin;
	/**
	 * Whether or not to use the helm
	 * @var boolean
	 */
	private $_helm;
    
    public function __construct($username, $helm = true) {
        $this->_username = $username;
        $this->_avatarX = 32;
        $this->_avatarY = 32;
        $this->_modelX = 64;
        $this->_modelY = 128;
		$this->_helm = $helm;
        
        $this->load_skin();
    }
    
    private function load_skin() {
        $skinUrl = 'http://s3.amazonaws.com/MinecraftSkins/'.$this->_username.'.png';
        $skin = file_get_contents($skinUrl);
        if(strpos($skin, '<?xml version="1.0" encoding="UTF-8"?>') === false) {
            $skinImage = imagecreatefrompng($skinUrl);
            $this->_skin = $skinImage;
        } else {
            throw new MinecraftUserImage_Exception('Invalid Username');
        }
    }
    
    public function create_avatar($size = 32) {
        if($size % 2) {
            throw new MinecraftUserImage_Exception('Size must be an even number');
        }
        if(empty($this->_skin)) {
            throw new MinecraftUserImage_Exception('Skin not loaded');
        }
        $this->_avatarX = $this->_avatarY = $size;
        $avatar = imagecreatetruecolor($size, $size);
        imagecopyresampled($avatar, $this->_skin, 0, 0, 8, 8, $size, $size, 8, 8);
		if($this->_helm === true) {
			imagecopyresampled($avatar, $this->_skin, 0, 0, 40, 8, $size, $size, 8, 8);
		}
        $this->_avatar = $avatar;
    }
    
    public function display_avatar() {
        if(empty($this->_avatar)) {
            throw new MinecraftUserImage_Exception('Avatar not created');
        }
        header('Content-Type: image/png');
        imagepng($this->_avatar);
    }

    public function create_model($size = 64) {
        if($size % 2) {
            throw new MinecraftUserImage_Exception('Size must be an even number');
        }
        if(empty($this->_skin)) {
            throw new MinecraftUserImage_Exception('Skin not loaded');
        }
        $width = $this->_modelX = $size;
        $height = $this->_modelY = ($size * 2);
        $model = imagecreatetruecolor($width, $height);
        $red = imagecolorallocate($model, 255, 0, 0);
        imagecolortransparent($model, $red);
        imagefilledrectangle($model, 0, 0, $size, ($size * 2), $red);
        $quart = $size / 4;
        $modSize = $size / 16;
        $posSize = $size / 16;
        // head
        imagecopyresampled(
                $model, 
                $this->_skin, 
                $quart, 0, 8, 8, 
                (8 * $modSize), (8 * $posSize), 8, 8);
		if($this->_helm === true) {
			imagecopyresampled(
                $model, 
                $this->_skin, 
                $quart, 0, 40, 8, 
                (8 * $modSize), (8 * $posSize), 8, 8);
		}
        // left arm
        imagecopyresampled(
                $model, 
                $this->_skin, 
                0, ($quart * 2), 44, 20, 
                (4 * $modSize), (12 * $posSize), 4, 12);
        // body
        imagecopyresampled(
                $model, 
                $this->_skin, 
                $quart, ($quart * 2), 20, 20, 
                (8 * $modSize), (12 * $posSize), 8, 12);
        // right arm
        $rightArm = imagecreatetruecolor((4 * $modSize), (12 * $posSize));
        imagecopyresampled(
                $rightArm, 
                $this->_skin, 
                0, 0, 48-1, 20, 
                (4 * $modSize), (12 * $posSize), -4, 12);
        imagecopy(
                $model, 
                $rightArm, 
                ($quart * 3), ($quart * 2), 0, 0,
                (4 * $modSize), (12 * $posSize));
        // left leg
        imagecopyresampled(
                $model, 
                $this->_skin, 
                $quart, ($quart * 5), 4, 20, 
                (4 * $modSize), (20 * $posSize), 4, 20);
        // right leg
        $rightLeg = imagecreatetruecolor((4 * $modSize), (20 * $posSize));
        imagecopyresampled(
                $rightLeg, 
                $this->_skin, 
                0, 0, 8-1, 20, 
                (4 * $modSize), (20 * $posSize), -4, 20);
        imagecopy(
                $model, 
                $rightLeg, 
                ($quart * 2), ($quart * 5), 0, 0,
                (4 * $modSize), (20 * $posSize));
        $this->model = $model;
    }
    
    public function display_model() {
        if(empty($this->model)) {
            throw new MinecraftUserImage_Exception('Model not created');
        }
        header('Content-Type: image/png');
        imagepng($this->model);
    }
            
}

class MinecraftUserImage_Exception extends Exception { }