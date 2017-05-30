<?php
namespace packages\notifications\events;
use \packages\base\event;
use \packages\notifications\channel;
use \packages\notifications\api;
class channels extends event{
	public function add($channel){
		if(is_string($channel)){
			api::addChannel(new $channel());
		}elseif($channel instanceof channel){
			api::addChannel($channel);
		}else{
			throw new \TypeError("only string or ".channel::class." type can pass to add()");
		}
	}
	public function get():array{
		return api::getChannels();
	}
}