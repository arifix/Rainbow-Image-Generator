<?php
	
	if(isset($_POST['submit'])){
		$fname = $_FILES['upload']['name']; // Get File Name
		$ftype = $_FILES['upload']['type']; // Get File Type
		$ftmp = $_FILES['upload']['tmp_name']; // Get Temporary Name
		$fsize = $_FILES['upload']['size']; // Get File Size
		$fext = pathinfo($fname, PATHINFO_EXTENSION); // Get File Extension
		$mname = substr($fname, 1, 12); // Get 12 Characters from File Name 
		$finfo = getimagesize($_FILES["upload"]["tmp_name"]); // Get Uploaded Image Dimension
		$fwidth = $finfo[0];  // Get Uploaded Image Width
		$fheight = $finfo[1]; // Get Uploaded Image Height
		$upload = "upload"; // Upload Directory
		$max = 10; // Maximum Allowed File Size
		$allow = array("jpg", "png", "jpeg"); // Allowed File Type
		$max_height = 3000; // Maximum Allowed Image Height
		$max_width = 5000; // Maximum Allowed Image Width

		if(empty($fname)){
			echo "Please select a Image";
		}
		else{
			if(in_array($fext, $allow)){
				// If Image Size is more than Allowed Size
				if($fsize > ($max * 1024 * 1000)){
					echo "Maximum {$max} MB Allowed";
				}
				else{
					// If Image Dimention is more than Allowed Dimention
					if($fwidth > $max_width || $fheight > $max_height){
						echo "Maximum image resolution allowed {$max_width}px X {$max_height }px";
					}
					else{
						//Create Image by PHP GD Image Library
						$file = $ftmp;
						$ext = pathinfo($file, PATHINFO_EXTENSION);

						switch($fext){
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
						if(!is_dir($upload))
						mkdir($upload, 0777);

						// Move File on Upload Direcory
						imagepng($im, "{$upload}/Rainbow_{$mname}.png");
						imagedestroy($im);

						// Preview Image & Download Option
						$download = "<button class=\"btn btn-primary\" onclick=\"window.open('upload/Rainbow_{$mname}.png')\">Download Image</button>";
						$image = "<img src=\"upload/Rainbow_{$mname}.png\" alt=\"Rainbow\" class=\"img-responsive\" />";							
						echo $download . "<p>&nbsp;</p>" . $image;
					}								
				}
			}
			else{
				// If Extension isn't Allowed
				$ext = implode(", ", $allow);
				echo "Only {$ext} is allowed";
			}
		}	
	}

?>
