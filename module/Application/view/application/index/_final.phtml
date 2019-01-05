<?php 
$this->final=$this->final[0];
$t1=null;
$t2=null;
foreach($this->teams as $t) 
{
	$t1=$t->id==$this->final->team1?$t:$t1;
	$t2=$t->id==$this->final->team2?$t:$t2;
}
?>
	<table class="table table-striped table-hover">
		<tr>
			<th>ID</th>
			<th>Team1</th>
			<th>Team2</th>
			<th>Score</th>
			<th>Created</th>
		</tr>
		<tr>
			<td><?=$this->final->id?></td>
			<td nowrap><?=$t1->name?></td>
			<td nowrap><?=$t2->name?></td>
			<td nowrap><?=$this->final->score1?>:<?=$this->final->score2?></td>
			<td nowrap><?=$this->final->created?></td>
		</tr>
	</table>
<?php 


$winner=["team"=>0,"score"=>0,"data"=>null];
if($this->final->score1>$this->final->score2)
{
	$winner["team"]=$this->final->team1;
	$winner["score"]=$this->final->score1;
}
elseif($this->final->score1<$this->final->score2)
{
	$winner["team"]=$this->final->team2;
	$winner["score"]=$this->final->score2;
}
else $winner=null;

if($winner) foreach($this->teams as $t) $winner["data"]=$t->id==$winner["team"]?$t:$winner["data"];
?>
	<h2>Winner</h2>
	<table class="table table-striped table-hover">
		<tr>
			<th>ID</th>
			<th>Group</th>
			<th>Team</th>
			<th>Score</th>
		</tr>
		<tr>
			<td><?=$winner?$winner["data"]->id:""?></td>
			<td nowrap><?=$winner?$winner["data"]->group:""?></td>
			<td nowrap><?=$winner?$winner["data"]->name:""?></td>
			<td nowrap><?=$winner?$winner["score"]:""?></td>
		</tr>
	</table>