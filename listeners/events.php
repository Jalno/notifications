<?php
namespace packages\notifications\listeners;

use packages\base\EventInterface;
use packages\notifications\Api;

class Events{
	public function handle(EventInterface $e): void {
		Api::notify($e);
	}
}