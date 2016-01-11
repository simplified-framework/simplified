<?php

namespace App\Http\Controllers;

use Simplified\Http\Response;

class DummyImageController extends Controller {
	private $content = null;
	// http://dummyimage.com/320x240/101010/fff.png&text=Image
	public function showImage($size_str, $background, $foreground) {
		$size = explode("x", $size_str);
		$im = imagecreatetruecolor($size[0], $size[1]);
		
		list($r, $g, $b) = sscanf($background, "%02x%02x%02x");
		$color = imagecolorallocate($im, $r, $g, $b);
		imagefill($im, 0, 0, $color);
		
		list($r, $g, $b) = sscanf($foreground, "%02x%02x%02x");
		$color = imagecolorallocate($im, $r, $g, $b);
		
		$fontfile = public_path() . "/fonts/glyphicons-halflings-regular.ttf";
		$string1 = "&#xe060;";
		$box = imagettfbbox ( 72 , 0, $fontfile , $string1);
		$width1 = abs($box[4] - $box[0]);
		$height1 = abs($box[5] - $box[1]);
		
		imagettftext ($im, 72, 0, ($size[0]/2)-($width1/2), ($size[1]/2)+(72/2), $color, $fontfile, $string1);
		
		ob_start();
		imagepng($im);
		$imagedata = ob_get_contents(); // read from buffer
		ob_end_clean(); // delete buffer

		return new Response($imagedata, 200, array('Content-length' => strlen($imagedata),'Content-type' => "image/png"));
	}
}