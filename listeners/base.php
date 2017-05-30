<?php
namespace packages\notifications\listeners;
use \packages\base\log;
use \packages\notifications\events;
use \packages\notifications\api;
class base{
	public function packagesLoaded(){
		$log = log::getInstance();
		$log->debug("fire 'events' event");
		$events = new events();
		$events->trigger();
	}
}