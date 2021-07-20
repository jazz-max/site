<?php
namespace app\models;
use yii\helpers\Json;

class JsonrpcResponse
{
	var string $jsonrpc = "2.0";
	var int $id = 0;
	var $error = null;
	var array $result = [] ;

	public function __construct ($json)
	{
		$obj = Json::decode ($json, true);
		if (!$obj){
			return;
		}
		// �� ���������� ����� ������� � 7� ��� ��� ��������� ������ ��� ��������
		foreach (get_object_vars ($this) as $key => $value){
			$this->$key = @$obj[$key] ?: $this->$key;
		}
	}


}