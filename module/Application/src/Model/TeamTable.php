<?php
namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class TeamTable
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

	public function save(Team $Team)
	{
		$data = [
			'tb0101_id' => $Team->id
			,'tb0101_name'  => $Team->name
			,'tb0101_group'  => $Team->group
			//,'tb0101_created'  => $Team->created
		];

		$id = (int) $Team->id;

		if ($id === 0) {
			$this->tableGateway->insert($data);
			return;
		}

		try {
			$this->get($id);
		} catch (RuntimeException $e) {
			throw new RuntimeException(sprintf(
				'Cannot update Team with identifier %d; does not exist',
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