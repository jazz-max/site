<?php


namespace app\models;

use Exception;
use linslin\yii2\curl;
use app\models\JsonrpcRequest;


class BalanceHelper
{
	const BALANCE_SITE = 'http://balance.local';
	const BALANCE_URI = '/index.php?r=jrpc';

	/**
	 * @param int $userId
	 *
	 * @return array
	 * @throws Exception
	 */
	public static function getBalance (int $userId): array
	{
		$request = new JsonrpcRequest( "balance.userBalance", ["user_id" => $userId] );
		$curl    = new curl\Curl();
		$json    = $curl->setOption (
			CURLOPT_POSTFIELDS,
			$request->toJSON () )->post ( self::BALANCE_SITE . self::BALANCE_URI, true );

		$res = new JsonrpcResponse ( $json );

		return $res->result;
	}
	public static function getHistory (int $userId=0, int $limit=50): array
	{
		$request = new JsonrpcRequest( "balance.history", ["user_id"=> $userId, "limit"=>$limit] );
		$curl    = new curl\Curl();
		$json    = $curl->setOption (
			CURLOPT_POSTFIELDS,
			$request->toJSON () )->post ( self::BALANCE_SITE . self::BALANCE_URI, true );


		$res = new JsonrpcResponse ( $json );

		return $res->result;
	}
}
