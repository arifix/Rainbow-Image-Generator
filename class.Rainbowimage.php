<?php

class Rainbowimage {
	public $message; // Show all error messages

	public $filename;
	public $filetype;
	public $filetmpname;
	public $filesize;
	public $fileext;

	public $imagename;

	public $imagedimension;
	public $imagewidth;
	public $imageheight;
	public $uploaddir = "uploads"; // Upload Directory Name
	public $allowedext = ['jpg', 'png', 'jpeg']; // Allowed Extension
	public $allowedwidth = 5000; // Maximum Allowed Image Width - 5000(5000px)
	public $allowedheight = 3000; // Maximum Allowed Image Height - 3000(3000px)
	public $allowedsize = 10; // Maximum Allowed Image Size 10 = 10MB(10 Megabyte)

	public function __construct(){
		$this->filename = $_FILES['upload']['name'];
		$this->filetype = $_FILES['upload']['type'];
		$this->filetmpname = $_FILES['upload']['tmp_name'];
		$this->filesize = $_FILES['upload']['size'];
		$this->fileext = pathinfo($this->filename, PATHINFO_EXTENSION);
		$this->imagename = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
		$this->imagedimension = getimagesize($_FILES["upload"]["tmp_name"]);
		$this->imagewidth = $this->imagedimension[0];
		$this->imageheight = $this->imagedimension[1];

		$this->validateImage();
	}

	public function validateImage(){
		if(empty($this->filename)){
			$this->message = "Please select a Image";
		}
		elseif(!in_array($this->fileext, $this->allowedext)){
			$allow = implode(", ", $this->allowedext);
			$this->message = "Only {$allow} is allowed";
		}
		elseif($this->filesize > ($this->allowedsize * 1024 * 1000)){
			echo "Maximum {$this->allowedsize} MB Allowed";
		}
		else{
		}

		$this->generateImage();
	}

	public function generateImage(){
		$file = $this->filetmpname;
		$ext = pathinfo($file, PATHINFO_EXTENSION);

		switch($this->fileext){
			case "jpg":
				$im = imagecreatefromjpeg($file);
				break;
			case "png":
				$im = imagecreatefrompng($file);
				break;
			case "jpeg":
				$im = imagecreatefromjpeg($file);
				break;
		}

		// Add Rainbow Layer
		$x = ImageSX($im);
		$y = ImageSY($im);
		$rh = $y / 6;

		$stamp = imagecreatetruecolor($x, $y);
		imagefilledrectangle($stamp, 0, $rh, $x, 0, 0xFF0000);
		imagefilledrectangle($stamp, 0, $rh, $x, $rh * 2, 0xFF6300);
		imagefilledrectangle($stamp, 0, $rh * 2, $x, $rh * 3, 0xFFFF00);
		imagefilledrectangle($stamp, 0, $rh * 3, $x, $rh * 4, 0x008000);
		imagefilledrectangle($stamp, 0, $rh * 4, $x, $rh * 5, 0x0000FF);
		imagefilledrectangle($stamp, 0, $rh * 5, $x, $rh * 6, 0x4B0082);

		imagecopymerge($im, $stamp, imagesx($im) - $x - 0, imagesy($im) - $y - 0, 0, 0, imagesx($stamp), imagesy($stamp), 50);

		// Create Directory if not Exists
		if(!is_dir($this->uploaddir))
		mkdir($this->uploaddir, 0777);

		// Move File on Upload Direcory
		imagepng($im, "{$this->uploaddir}/Rainbow_{$this->imagename}.png");
		imagedestroy($im);

		$this->showResult();
	}

	public function showResult(){
		$download = "<button class=\"btn btn-primary\" onclick=\"window.open('{$this->uploaddir}/Rainbow_{$this->imagename}.png')\">Download Image</button>";
		$image = "<img src=\"{$this->uploaddir}/Rainbow_{$this->imagename}.png\" alt=\"$this->imagename\" class=\"img-responsive\" />";							
		echo "<p>{$download}</p><p>$image</p>";
	}
}
