<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller{
		
	public function __construct() {        
	    parent::__construct();
	}

	function generateCaptcha() {
		$string = '';
		for ($i = 0; $i < 5; $i++) {
			$string .= chr(rand(97, 122));
		}
		$this->session->set_userdata('captkodex', $string);
		// $dir = 'fonts/';
		$image = imagecreatetruecolor(180, 50);
		$urlFont = $_SERVER['DOCUMENT_ROOT']."/marketing_tools/assets/fonts/VeraSansBold.ttf";
		$locationFont = $urlFont;
		$num2 = rand(1,2);
		if($num2==1){
			$color = imagecolorallocate($image, 113, 193, 217);// color
		}
		else{
			$color = imagecolorallocate($image, 163, 197, 82);// color
		}
		// background transparant
		imagesavealpha($image, true);
		$trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
		imagefill($image, 0, 0, $trans_colour);
		$red = imagecolorallocate($image, 255, 0, 0);
		imagefilledellipse($image, 400, 300, 400, 300, $red);

		// background color white
		/*$white = imagecolorallocate($image, 231, 235, 238); 
		imagefilledrectangle($image,0,0,399,99,$white);*/
		// echo $string;
		imagettftext ($image, 30, 0, 10, 40, $color, $locationFont, $string);
		header("Content-type: image/png");
		imagepng($image);
	}
}
?>