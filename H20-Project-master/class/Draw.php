<?php
class Draw
{
	public static $squareSize=300;
	public static function rotate($x,$y,$rot,$centerX,$centerY)
	{
		echo "hi";
		$x = $x-$centerX;
		$y = $y-$centerY;
		echo $x;
		$newX=($x*cos($rot))-($y*sin($rot));
		echo $newX;
		$newY=($x*sin($rot))-($y*cos($rot));
		$newX=$newX+$centerX;
		$newY=$newY+$centerY;
		echo $newX;
		echo $newY;
		return array($newX,$newY);
	}
	public static function getYLoc($rank)
	{
		$rate=(self::$squareSize/2)/5;
		return (5-$rank)*$rate;
	}
	public static function createImage($fileName,$selEval,$adminEval,$cats)
	{
		//first draw the underlyng pie 
		//create a list of points
		//points[]=num catergories
		//get the amount of rotatiobn between each point
		//$rotEach=360/numCats
		//for number of catergories
			//add subarray rotate($centerX,0,$rotEach*i,$centerX,$centerY) to list
		//draw polygon 
		//for each point in list
			//draw line between point i and point (centerX,CenterY)
		
		//draw actual rating 
		
		//determine selfSurvey and admn survy
		
		//first draw self survey
		//create new array of points
		//for each point 
			//add subarray rotate($centerX,selfSruvey.cat[i],$rotEach*i,$centerX,$centerY) to list 
		//add first back to end
		//fill poly
		
		//repeat for admin 
		
		//draw poly for self again.
		
		//save
		
		//return name
		
	
		if(function_exists("imagecreatetruecolor"))
		{
			$im = @imagecreatetruecolor(self::$squareSize,self::$squareSize)
				or die('Cannot Initialize new GD image stream');
		}
		else
		{
			$im = @imagecreate(self::$squareSize,self::$squareSize)
				or die('Cannot Initialize new GD image stream');
		}
		
		$back=imagecolorallocatealpha ($im,255,255,255,0);
		$black=imagecolorallocatealpha ($im,0,0,0,0);
		$blue=imagecolorallocatealpha ($im,0,255,38,0);
		$green=imagecolorallocatealpha ($im,0,38,255,0);
		
		echo "<br>";
		
		$centerX=self::$squareSize/2;
		$centerY=self::$squareSize/2;
		
		$numPoints=count($cats);
		foreach($cats as $c)
		{
			echo "<br>";
			echo $c; 
		}
		
		$points=array();
		$rotEach=360/14;
		$i=0;
		$index=0;
		for ($i = 1; $i <= 14; $i++) 
		{
		
			$temp=self::rotate($centerX,0,$index*$rotEach,$centerX,$centerY);
			echo "hi";
			array_push($points, $temp[0],$temp[1]);
			imageline($im,$centerX,$centerY,$temp[0],$temp[1],$back);
			$index=$index+1;
		}
		imagepolygon ($im,$points,14,$back);
		
		//draw the lines to conect the center
		
		
		
		imagealphablending($im, false);
		imagesavealpha($im, true);
		imagestring($im, 1, 5, 5,  "A Simple Text String", $green);
			
		ob_start();	
		imagepng($im);
		$image = ob_get_contents();
		ob_end_clean();
		echo '<img src="data:image/png;base64,'.base64_encode($image).'" />';	
		imagedestroy($im);
	}
}
?>