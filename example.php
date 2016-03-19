<?php

require_once 'vendor/autoload.php';

use EventScheduler\EventScheduler;

$event = new EventScheduler();

$schedule = array(
	"start" => "18-03-2016 23:43",
	"finish" => "20-03-2020 23:43"
);

$event->schedule($schedule);

$event->before(function() {
	echo "BEFORE EVENT IS EXECUTED!!!";
});

$event->after(function() {
	echo "AFTER EVENT IS EXECUTED!!!";
});

$event->run();