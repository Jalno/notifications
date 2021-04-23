<?php
namespace packages\notifications;

use packages\base\Event;

class Events extends Event {

	/**
	 * @param class-string<Notifiable> $event
	 */
	public function add(string $event): void {
		Api::addEvent($event);
	}

	/**
	 * @return array<class-string<Notifiable>>
	 */
	public function get(): array {
		return api::getEvents();
	}
}
