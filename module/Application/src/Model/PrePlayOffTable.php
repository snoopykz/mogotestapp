<?php
namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class PrePlayOffTable
{
	public $tableGateway;

	public function __construct(TableGatewayInterface $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function getAll()
	{
		return iterator_to_array($this->tableGateway->select());
	}

	public function get($id)
	{
		$id = (int) $id;
		$rowset = $this->tableGateway->select(['id' => $id]);
		$row = $rowset->current();
		if (! $row) {
			throw new RuntimeException(sprintf(
				'Could not find row with identifier %d',
				$id
			));
		}

		return $row;
	}

	public function save(PlayOff $m)
	{
		$data = [
			'tb0103_id' => $m->id
			,'tb0103_tb0101_id'  => $m->team
			,'tb0103_score'  => $m->score
			//,'tb0101_created'  => $m->created
		];

		$id = (int) $m->id;

		if ($id === 0) {
			$this->tableGateway->insert($data);
			return;
		}

		try {
			$this->get($id);
		} catch (RuntimeException $e) {
			throw new RuntimeException(sprintf(
				'Cannot update PlayOff with identifier %d; does not exist',
				$id
			));
		}

		$this->tableGateway->update($data, ['id' => $id]);
	}

	public function delete($where)
	{
		$this->tableGateway->delete($where);
	}
}