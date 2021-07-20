<?php

namespace app\models;

use yii\helpers\Json;

class JsonrpcRequest
{
	protected static $lastId = 0;
	var string $jsonrpc = "2.0";
	var int $id = 0;
	var string $method = "";
	var array $params = [];

	/**
	 * JsonrpcRequest constructor.
	 *
	 * @param string $method
	 * @param array  $params
	 */
	public function __construct (string $method, array $params)
	{
		$this->id     = self::$lastId++;
		$this->method = $method;
		$this->params = $params;
	}

	public function toJSON (): string
	{
		return Json::encode ( $this );
	}

}