	<div class="row">
<?php 
foreach($this->playOff as $r) {
	$t1=null;
	$t2=null;
	foreach($this->teams as $t) 
	{
		$t1=$t->id==$r->team1?$t:$t1;
		$t2=$t->id==$r->team2?$t:$t2;
	}
?>
		<div class="col-md-3">
			<table class="table table-striped table-hover">
				<tr>
					<th>ID</th>
					<th>Team1</th>
					<th>Team2</th>
					<th>Score</th>
				</tr>
				<tr>
					<td><?=$r->id?></td>
					<td nowrap><?=$t1->name?></td>
					<td nowrap><?=$t2->name?></td>
					<td nowrap><?=$r->score1?>:<?=$r->score2?></td>
				</tr>
			</table>
		</div>
<?php }?>
	</div>

	<h2>Play Off results</h2>
	<div class="row">
<?php 
foreach($this->playOffResult as $r) {
?>
		<div class="col-md-6">
			<table class="table table-striped table-hover">
				<tr>
					<th>ID</th>
					<th>Group</th>
					<th>Team</th>
					<th>Score</th>
				</tr>
				<tr>
					<td><?=$r->id?></td>
					<td nowrap><?=$r->group?></td>
					<td nowrap><?=$r->name?></td>
					<td nowrap><?=$r->score?></td>
				</tr>
			</table>
		</div>
<?php }?>
	</div>