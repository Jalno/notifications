<?php
namespace packages\notifications;
use packages\base\Event;
abstract class Channel {
	abstract public function notify(Event $e);
	abstract public function getName(): string;
}