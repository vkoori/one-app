<?php 

namespace App\One\Events;

use One\Event as OneEvent;

class Event
{
	public static function run()
	{
		OneEvent::setListeners(
			event: \App\One\Events\V1\Events\Test::class,
			listeners: [
				\App\One\Events\V1\Listeners\Test::class,
			]
		);
	}	
}