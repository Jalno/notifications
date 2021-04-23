<?php
namespace packages\notifications\events;

use packages\base\Event;
use packages\notifications\{Api, IChannel};

class Channels extends Event {

	/**
	 * @param class-string<IChannel>|IChannel $channel
	 */
	public function add($channel): void {
		if (is_string($channel)) {
			Api::addChannel(new $channel());
		} elseif ($channel instanceof IChannel) {
			Api::addChannel($channel);
		} else {
			throw new \InvalidArgumentException("only string or " . IChannel::class . " type can pass to add()");
		}
	}

	/**
	 * @return IChannel[]
	 */
	public function get(): array {
		return Api::getChannels();
	}
}
