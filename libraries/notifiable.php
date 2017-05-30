<?php
namespace packages\notifications;
interface notifiable{
	public static function getName():string;
	public static function getParameters():array;
	public function getArguments():array;
	public function getTargetUsers():array;
}