<?php
namespace packages\notifications;
use \packages\base\packages;
use \packages\base\log;
use \packages\base\event;
class api{
	private static $events = [];
	private static $channels = [];
	private static $channelsTriggered = false;
	public static function addEvent(string $event){
		$log = log::getInstance();
		$event = strtolower($event);
		if(!class_exists($event) ){
			throw new \Exception($event." does not exists");
		}
		if(!in_array(notifiable::class, class_implements($event))){
			throw new \Exception($event." didn't implements ".notifiable::class);
		}
		$log->debug("search for duplicate");
		if(!in_array(self::$events, self::$events)){
			$log->reply("notfound");
			$log->debug("get notifications package");
			$package = packages::package('notifications');
			$package->addEvent("\\".$event, 'listeners\\events@handle');
			self::$events[] = $event;
		}else{
			$log->reply()->error("found");
		}
	}
	public static function getEvents():array{
		return self::$events;
	}
	public static function addChannel(channel $channel){
		self::$channels[] = $channel;
	}
	public static function getChannels():array{
		if(!self::$channels and !self::$channelsTriggered){
			self::$channelsTriggered = true;
			$event = new events\channels();
			$event->trigger();
		}
		return self::$channels;
	}
	public static function notify(event $event){
		if(in_array(strtolower(get_class($event)), self::getEvents())){
			$channels = self::getChannels();
			foreach($channels as $channel){
				$channel->notify($event);
			}
		}
	}
}