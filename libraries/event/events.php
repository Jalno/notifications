<?php
namespace packages\notifications;
use \packages\base\event;
class events extends event{
	public function add(string $event){
		api::addEvent($event);
	}
	public function get():array{
		return $this->getEvents();
	}
}