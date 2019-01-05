<?php
namespace Application\Model;

class PlayOff
{
	public $id;
	public $team1;
	public $team2;
	public $score1;
	public $score2;
	public $created;

	public function __construct(array $cfg=[]){
		foreach($cfg as $k=>$v) $this->{$k}=!empty($v)?$v:null;
	}

	public function exchangeArray(array $data)
	{
		$this->id = !empty($data['tb0104_id']) ? $data['tb0104_id'] : null;
		$this->team1 = !empty($data['tb0104_tb0101_id1']) ? $data['tb0104_tb0101_id1'] : null;
		$this->team2 = !empty($data['tb0104_tb0101_id2']) ? $data['tb0104_tb0101_id2'] : null;
		$this->score1 = !empty($data['tb0104_score1']) ? $data['tb0104_score1'] : null;
		$this->score2 = !empty($data['tb0104_score2']) ? $data['tb0104_score2'] : null;
		$this->created = !empty($data['tb0104_created']) ? $data['tb0104_created'] : null;
	}
}