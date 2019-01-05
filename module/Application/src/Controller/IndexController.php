<?php
/**
 * @link	  http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	private $tableTeam;
	private $tableMatch;
	private $tablePrePlayOff;
    private $tablePlayOff;
	private $tableTournamentFinal;

	private $tableGateway;

	public function __construct
	(
		\Application\Model\TeamTable $tableTeam
		,\Application\Model\MatchTable $tableMatch
		,\Application\Model\PrePlayOffTable $tablePrePlayOff
        ,\Application\Model\PlayOffTable $tablePlayOff
		,\Application\Model\TournamentFinalTable $tableTournamentFinal
	)
	{
		$this->tableTeam = $tableTeam;
		$this->tableMatch = $tableMatch;
		$this->tablePrePlayOff = $tablePrePlayOff;
        $this->tablePlayOff = $tablePlayOff;
		$this->tableTournamentFinal = $tableTournamentFinal;
		$this->tableGateway=$this->tableTeam->tableGateway;
	}

	protected function stepDone($args)
	{
		$args['controller']=$this->getEvent()->getRouteMatch()->getParam('controller');
		$args['action']=$this->getEvent()->getRouteMatch()->getParam('action');

		$view = new ViewModel($args);
        $view->setTemplate('application/index/stepDone');
        return $view;
	}

	public function truncateAction()
	{
		$a=[
			"tb0101_teams"
			,"tb0102_matches"
			,"tb0103_playoff"
			,"tb0104_playoff"
			,"tb0105_final"
		];
		foreach($a as $b) $this->tableGateway->getAdapter()->driver->getConnection()->execute("TRUNCATE TABLE $b");
		
		return $this->stepDone(["type"=>"success","message"=>"Truncating is done."]);
	}

	public function teamsAction()
	{
		$this->tableTeam->delete(["1"=>1]);
		$this->createTeams();
		return $this->stepDone(["type"=>"success","message"=>"Teams was created."]);
	}

	public function matchesAction()
	{
		$teams=$this->tableTeam->getAll();
		if(!$teams) return $this->stepDone(["type"=>"danger","message"=>"You must generate teams before."]);

		$this->tableMatch->delete(["1"=>1]);
		$this->createMatches();
		return $this->stepDone(["type"=>"success","message"=>"Matches was created."]);
	}

	public function playoffAction()
	{
		$teams=$this->tableTeam->getAll();
        $matches=$this->tableMatch->getAll();
		if(!$teams||!$matches) return $this->stepDone(["type"=>"danger","message"=>"You must generate teams and matches before."]);

		$this->tablePlayOff->delete(["1"=>1]);
		$this->createPlayOff();
		return $this->stepDone(["type"=>"success","message"=>"Play Off was created."]);
	}

	public function finalAction()
	{
		$teams=$this->tableTeam->getAll();
        $matches=$this->tableMatch->getAll();
       	$playOff=$this->tablePlayOff->getAll();
 		if(!$teams||!$matches||!$playOff) return $this->stepDone(["type"=>"danger","message"=>"You must generate teams, matches and play off before."]);

		$this->tableTournamentFinal->delete(["1"=>1]);
		$this->createTournamentFinal();
		return $this->stepDone(["type"=>"success","message"=>"Final was created."]);
	}

	public function indexAction()
	{
        $teams=$this->tableTeam->getAll();
        $matches=$this->tableMatch->getAll();
        $playOff=$this->tablePlayOff->getAll();
        $final=$this->tableTournamentFinal->getAll();

        $playOffResult=[];
        foreach($teams as $t)
        {
            $playOffResult[]=$t;
            $playOffResult[count($playOffResult)-1]->score=0;
            foreach($playOff as $r) $playOffResult[count($playOffResult)-1]->score+=$r->team1==$t->id?$r->score1:($r->team2==$t->id?$r->score2:0);
        }
        usort($playOffResult, function ($a, $b) {
            if($a->score<$b->score) return 1;
            if($a->score>$b->score) return -1;
            return 0;
        });
        $playOffResult=array_slice($playOffResult, 0, 2);

		return new ViewModel([
			'controller'=>$this->getEvent()->getRouteMatch()->getParam('controller')
			,'action'=>$this->getEvent()->getRouteMatch()->getParam('action')
			,'teams' => $teams
			,'matches' => $matches
            ,'playOff' => $playOff
            ,'playOffResult' => $playOffResult
			,'final' => $final
		]);
    }

    protected function createTournamentFinal()
    {
        $teams=$this->tableTeam->getAll();
        $playOff=$this->tablePlayOff->getAll();

        $playOffResult=[];
        foreach($teams as $t)
        {
            $playOffResult[]=$t;
            $playOffResult[count($playOffResult)-1]->score=0;
            foreach($playOff as $r) $playOffResult[count($playOffResult)-1]->score+=$r->team1==$t->id?$r->score1:($r->team2==$t->id?$r->score2:0);
        }
        usort($playOffResult, function ($a, $b) {
            if($a->score<$b->score) return 1;
            if($a->score>$b->score) return -1;
            return 0;
        });
        $playOffResult=array_slice($playOffResult, 0, 2);

        $q=new \Application\Model\TournamentFinal(["team1"=>$playOffResult[0]->id,"team2"=>$playOffResult[1]->id,"score1"=>rand(1,10),"score2"=>rand(1,10)]);
        while($q->score1==$q->score2) $q=new \Application\Model\TournamentFinal(["team1"=>$playOffResult[0]->id,"team2"=>$playOffResult[1]->id,"score1"=>rand(1,10),"score2"=>rand(1,10)]);
        $this->tableTournamentFinal->save($q);
    }

    protected function createPlayOff()
    {
		$teams=$this->tablePrePlayOff->getAll();

        // custom sotring by score 
		usort($teams, function ($a, $b) {
			if($a->score<$b->score) return -1;
			if($a->score>$b->score) return 1;
			return 0;
		});

		// play-off initial schedule principle - best team plays against worst team
        $a=[];
		$slice = floor(count($teams)/2);
		for($i=0;$i<$slice;$i++) $a[]=[$teams[$i]->team,$teams[count($teams)-1-$i]->team];

		// create models and save it to db
        foreach($a as $r)
		{
			$q=new \Application\Model\PlayOff(["team1"=>$r[0],"team2"=>$r[1],"score1"=>rand(1,10),"score2"=>rand(1,10)]);
			$this->tablePlayOff->save($q);
		}
	}

	protected function createTeams()
	{
		$teams=[];
		for($i=0;$i<16;$i++) $teams[]="team ".($i+1);
		
		shuffle($teams);
		
		for($i=0;$i<count($teams);$i++)
		{
			$team=new \Application\Model\Team(["name"=>$teams[$i],"group"=>$i<8?"A":"B"]);
			$this->tableTeam->save($team);
		}
	}

	protected function createMatches()
	{
		$teamsA=[];
		$teamsB=[];
		$teams=$this->tableTeam->getAll();
		foreach($teams as $r)
		{
			if($r->group=="A")$teamsA[]=$r->id;
			else $teamsB[]=$r->id;
		}

		shuffle($teamsA);
		shuffle($teamsB);

		$slice = floor(count($teamsA)/2);
		$teamsA1=array_slice($teamsA, 0, $slice);
		$teamsA2=array_slice($teamsA, $slice);
		$teamsB1=array_slice($teamsB, 0, $slice);
		$teamsB2=array_slice($teamsB, $slice);
		
		$teamsA=$this->combinations([$teamsA1,$teamsA2]);
		$teamsB=$this->combinations([$teamsB1,$teamsB2]);

		$this->saveMatch($teamsA);
		$this->saveMatch($teamsB);

		$groups=["A","B"];

		$this->tablePrePlayOff->delete(["1"=>1]);

	   foreach($groups as $g){
		   $sql="INSERT INTO tb0103_playoff (tb0103_tb0101_id,tb0103_score)
SELECT tb0101_id,score
FROM (
	SELECT 
		tb0101_id
		,(
			SELECT SUM(IF(tb0101_id=tb0102_tb0101_id1,tb0102_score1,tb0102_score2)) 
			FROM tb0102_matches 
			WHERE tb0101_id IN (tb0102_tb0101_id1,tb0102_tb0101_id2)
		) score 
	FROM tb0101_teams
	WHERE tb0101_group='$g'
) T
ORDER BY score DESC
LIMIT 0,4
";
			$this->tableGateway->getAdapter()->driver->getConnection()->execute($sql);
		}
	}

	protected function saveMatch($a)
	{
		foreach($a as $r)
		{
			$q=new \Application\Model\Match(["team1"=>$r[0],"team2"=>$r[1],"score1"=>rand(1,10),"score2"=>rand(1,10)]);
			//die(print_r($q,1));
			$this->tableMatch->save($q);
		}
	}


	/**
	 * Generate all the possible combinations among a set of nested arrays.
	 *
	 * @param array $data  The entrypoint array container.
	 * @param array $all   The TournamentFinal container (used internally).
	 * @param array $group The sub container (used internally).
	 * @param mixed $val   The value to append (used internally).
	 * @param int   $i   The key index (used internally).
	 */
	function combinations(array $data, array &$all = array(), array $group = array(), $value = null, $i = 0)
	{
		$keys = array_keys($data);
		if (isset($value) === true) {
			array_push($group, $value);
		}

		if ($i >= count($data)) {
			array_push($all, $group);
		} else {
			$currentKey  = $keys[$i];
			$currentElement = $data[$currentKey];
			foreach ($currentElement as $val) {
				$this->combinations($data, $all, $group, $val, $i + 1);
			}
		}

		return $all;
	}
}
