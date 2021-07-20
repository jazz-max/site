<?php


namespace app\models;


class UserIdFormModel extends \yii\base\Model
{
	public int $userId=0;

	public function rules(): array
	{
		return [
			['userId', 'required'],
			['userId', 'integer'],
		];
	}
}