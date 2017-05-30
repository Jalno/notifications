<?php
namespace packages\notifications;
use \packages\base\event;
abstract class channel{
	abstract public function notify(event $e);
}