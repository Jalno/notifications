<?php
namespace packages\notifications;

use InvalidArgumentException;
use packages\base\{Log, EventInterface, Packages};

class Api {

	/**
	 * @var array<class-string<Notifiable>>
	 */
	private static $events = [];

	/**
	 * @var IChannel[]
	 */
	private static $channels = [];

	/**
	 * @var bool
	 */
	private static $channelsTriggered = false;

	/**
	 * @var class-string<Notifiable> $event
	 */
	public static function addEvent(string $event): void {
		$log = Log::getInstance();
		if (!class_exists($event)) {
			throw new InvalidArgumentException($event." does not exists");
		}
		if (!is_subclass_of($event, Notifiable::class, true)) {
			throw new InvalidArgumentException($event . " didn't implements " . Notifiable::class);
		}

		/**
		 * @var class-string<Notifiable>
		 */
		$event = strtolower($event);

		$log->debug("search for duplicate");
		if (in_array(self::$events, self::$events)) {
			$log->reply()->error("found");
			return;
		}
		$log->reply("notfound");
		$log->debug("add listener to notifications package");
		$package = Packages::package('notifications');
		if ($package) {
			$package->addEvent($event, listeners\Events::class . '@handle');
		}
		self::$events[] = $event;
	}


	/**
	 * @return array<class-string<Notifiable>>
	 */
	public static function getEvents(): array {
		return self::$events;
	}

	public static function addChannel(IChannel $channel): void {
		self::$channels[] = $channel;
	}

	/**
	 * @return IChannel[]
	 */
	public static function getChannels(): array {
		if (!self::$channels and !self::$channelsTriggered) {
			self::$channelsTriggered = true;
			$event = new events\Channels();
			$event->trigger();
		}
		return self::$channels;
	}

	/**
	 * @param IChannel[]|null $channels
	 */
	public static function notify(EventInterface $event, ?array $channels = null): void {
		if (in_array(strtolower(get_class($event)), self::getEvents())) {
			if ($channels === null) {
				$channels = self::getChannels();
			}
			foreach ($channels as $channel) {
				if ($channel->canNotify($event)) {
					$channel->notify($event);
				}
			}
		}
	}
}