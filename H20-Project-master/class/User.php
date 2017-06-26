<?php
include_once 'class//db.php';
include_once 'class//Survey.php';
include 'class//Draw.php';

class User
{
	
	public $ID;
	public $Role;
	public $Name;
	public $selfSurvey;
	public $adminSurvey;
	
	public function __construct($dbname) 
	{
		$this->selfSurvey= -5;
		$this->adminSurvey= 170;//todo fic
	}
	public static function load($id)
	{
		$u=new User();
		$db=new Database("cs440_h2o ");
		$r=$db->getData("h2o_users",$id);
		
		$u->selfSurvey=Survey::load($r["userSurvey"]);
		$u->adminSurvey=Survey::load($r["adminSurvey"]);
		$u->ID=Survey::load($r["ID"]);
		$db->close();
		return $u;
	}
	public static function loadF($userN)
	{
		$u=new User();
		
		$db=new Database('cs440_h2o');
		$r=$db->getDataFromF("h2o_users",$userN,"username");
		$u->selfSurvey=$r["userSurvey"];
		$u->adminSurvey=$r["adminSurvey"];
		$u->ID=$r["id"];
		$u->Name=$r["username"];
		$db->close();
		return $u;
		//actualy get data
	}
	public function save()
	{
		$db=new Database("cs440_h2o");
		
		//todo update for the two survey
		$db->updateData("h2o_users",$this->ID, "userSurvey", $this->selfSurvey,'i');
		$db->updateData("h2o_users",$this->ID, "adminSurvey", $this->adminSurvey,'i');
		$db->close();
	}
	public function draw($fileName)
	{ 
		$cats = array("COMMUNICATIONS","COOPERATION","COST CONSCIOUSNESS","DEPENDABILITY","INITIATIVE","JOB KNOWLEDGE","JUDGMENT","PLANNING & ORGANIZATION"
		,"PROBLEM SOLVING","QUALITY","QUANTITY","USE OF TECHNOLOGY");
		
		if($this->selfSurvey>0)
		{
			$ss=Survey::load($this->selfSurvey);
			$sR=$ss->getCatergoryRanks();
			foreach ($sR as $s)
			{
			}
		}
		
		if($this->adminSurvey>0)
		{
			$sa=Survey::load($this->adminSurvey);
			$aR=$sa->getCatergoryRanks();
		}
		if($this->selfSurvey<0)
		{
			$sR=$aR;
		}
		
		if($this->adminSurvey<0)
		{
			$aR=$sR;
		}
		Draw::createImage($fileName,$sR,$aR,$cats);
		return $fileName.".png";
		
	}
}
?>