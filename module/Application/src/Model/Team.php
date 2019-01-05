<?php
namespace Application\Model;

class Team
{
	public $id;
	public $name;
	public $group;
	public $created;

	public function __construct(array $cfg=[]){
		foreach($cfg as $k=>$v) $this->{$k}=!empty($v)?$v:null;
	}

	public function exchangeArray(array $data)
	{
		$this->id = !empty($data['tb0101_id']) ? $data['tb0101_id'] : null;
		$this->name = !empty($data['tb0101_name']) ? $data['tb0101_name'] : null;
		$this->group  = !empty($data['tb0101_group']) ? $data['tb0101_group'] : null;
		$this->created  = !empty($data['tb0101_created']) ? $data['tb0101_created'] : null;
	}
}