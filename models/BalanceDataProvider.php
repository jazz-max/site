<?php


namespace app\models;


use yii\base\InvalidArgumentException;
use yii\data\BaseDataProvider;

class BalanceDataProvider extends BaseDataProvider
{
	public int $limit = 1;
	public string $key;
	public string $query;
	public int $userId;

	function history (): array
	{
		$history =  array();
		$rows    = BalanceHelper::getHistory ( $this->userId, $this->limit );
		foreach ($rows as $row)
		{
			$history[] = (new BalanceHistory())->fill ( $row );
		}

		return $history;
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public function userBalance (): array
	{
		$row = BalanceHelper::getBalance ( $this->userId );

		$balanceHistory = new BalanceHistory();
		$balanceHistory->user_id = $this->userId;
		$balanceHistory->created_at = "Не найдено";
		if (count($row)>0)
		{
			$balanceHistory->fill ( $row );
		}
		return [$balanceHistory];
	}

	/**
	 * @inheritDoc
	 */
	protected function prepareModels (): array
	{
		if ($this->query and is_callable ( [self::class, $this->query] ))
		{
			return $this->{$this->query}();
		}
		else
		{
			throw new InvalidArgumentException( "Параметр query должен быть методом класса " . self::class );
		}
	}

	/**
	 * @inheritDoc
	 */
	protected function prepareKeys ($models): array
	{
		if ($this->key !== null)
		{
			$keys = [];

			foreach ($models as $model)
			{
				if (is_string ( $this->key ) and isset( $model->{$this->key} ))
				{
					$keys[] = $model->{$this->key};
				}
			}

			return $keys;
		}
		else
		{
			return array_keys ( $models );
		}
	}

	/**
	 * @inheritDoc
	 */
	protected function prepareTotalCount (): int
	{
		return ($this->query == "userBalance") ? 1 : $this->limit;
	}
}