<?php


namespace app\models;


use yii\db\Connection;
use yii\db\QueryInterface;

class BalanceHistory
{
	var float $balance = 0.;
	var float $value = 0.;
	var int $user_id = 0;
	var string $created_at = "";
	var int $id = 0;


	public function fill ($row): self
	{

		$this->balance    = $row["balance"];
		$this->value      = $row["value"];
		$this->user_id    = $row["user_id"];
		$this->created_at = $row["created_at"];
		$this->id         = $row["id"];

		return $this;
	}

}

