<?php
namespace packages\notifications\listeners;
use \packages\base\event;
use \packages\notifications\api;
class events{
	public function handle(event $e){
		api::notify($e);
	}
}