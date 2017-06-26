<?php
include_once  'class//db.php';
class Survey
{
	public $answers;

	public function __construct($dbname) 
	{
		
	}
	public static function load($id)
	{	
		$s=new Survey();
		$db=new Database("cs440_h2o");
		$r=$db->getDataFromI("h2o_answers",$id,"id");
		echo "<br>".$r["answers"];
		$s->parseAnswers($r["answers"]);
		
		$db->close();
		return $s;
	}
	public function save()
	{
		$db=new Database("cs440_h2o");
		//mysqli_query($db->con,
	}
	public function create()
	{
		$db=new Database("cs440_h2o");
		mysqli_query($db->con,"INSERT INTO h2o_answers (answers) VALUES ('".$this->concatenateAnswers()."')");

		return mysqli_insert_id($db->con);
	}
	public function parseAnswers($rawData)
	{
		$this->answers=explode(',',$rawData);
	}
	public function concatenateAnswers()
	{
		return implode(',',$this->answers);
	}
	public function getCatergoryRanks()
	{
		$ranks=array(1,2);
		$i=0;
		foreach($this->answers as $a)
		{
			$cat=0;
			if($i<4)//5
			{
				$cat=1;
			}
			else if($i<10)//6
			{
				$cat=1;
			}
			else if($i<14)//4
			{
				$cat=2;
			}
			else if($i<20)//6
			{
				$cat=3;
			}
			else if($i<26)//6
			{
				$cat=4;
			}
			else if($i<32)//6
			{
				$cat=5;
			}
			else if($i<37)//5
			{
				$cat=6;
			}
			else if($i<43)//6
			{
				$cat=7;
			}
			else if($i<49)//6
			{
				$cat=8;
			}
			else if($i<54)//5
			{
				$cat=9;
			}
			else if($i<59)//5
			{
				$cat=10;
			}
			else if($i<64)//5
			{
				$cat=11;
			}
			else if($i<69)//5
			{
				$cat=12;
			}
			echo $a."!!!!";
			if(is_numeric($a))
			{
				ECHO "yes";
				$i=$i+1;
				$ranks[$cat]=$ranks[$cat]+intval($a);
			}
		}
		return $ranks;
	}
}
?>


