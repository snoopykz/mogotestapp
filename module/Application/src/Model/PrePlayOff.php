<?php
namespace Application\Model;

class PrePlayOff
{
	public $id;
	public $team;
	public $score;
	public $created;

	public function __construct(array $cfg=[]){
		foreach($cfg as $k=>$v) $this->{$k}=!empty($v)?$v:null;
	}

	public function exchangeArray(array $data)
	{
		$this->id = !empty($data['tb0103_id']) ? $data['tb0103_id'] : null;
		$this->team = !empty($data['tb0103_tb0101_id']) ? $data['tb0103_tb0101_id'] : null;
		$this->score = !empty($data['tb0103_score']) ? $data['tb0103_score'] : null;
		$this->created = !empty($data['tb0103_created']) ? $data['tb0103_created'] : null;
	}
}