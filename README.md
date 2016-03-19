# eventScheduler 
[![Build Status](https://travis-ci.org/daltonmenezes/eventScheduler.svg?branch=master)](https://travis-ci.org/daltonmenezes/eventScheduler) [![Code Climate](https://codeclimate.com/github/daltonmenezes/eventScheduler/badges/gpa.svg)](https://codeclimate.com/github/daltonmenezes/eventScheduler)

A simple event scheduler application for PHP projects. 

# Installation

The Package is available on [Packagist](https://packagist.org/packages/daltonmenezes/eventscheduler),
you can install it using [Composer](http://getcomposer.org).

```bash
composer require daltonmenezes/eventscheduler dev-master
```
### Dependencies

- [PHP](https://php.net) 5.3+

## How it works?

Setting a start and finish date, you can trigger different events for each.

The behavior you set to be triggered on the start date is defined by after() event;

The behavior you set to be triggered while the start date is not reached is the before() event;

When the finish date is reached, after() event is suspended, as well before() event too.

The finish date is optional, if you want the after() event continues in your project execution without date limitations, simply do not set the key "finish" in your array.

## Usage
Instantiate EventScheduler\EventScheduler.
```php
use EventScheduler\EventScheduler;

$event = new EventScheduler();
```
Define a start date in your schedule, its must be an array.
```php
$schedule = array("start" => "18-03-2016 23:43");
```
The start key is for when your event must be triggered. If you want define a finish date for shutdown it, you must define a finish key in your array.

```php
$schedule = array(
	"start" => "18-03-2016 23:43",
	"finish" => "20-03-2020 19:13"
);
```

Now, call the schedule method for set your array.

```php
$event->schedule($schedule);
```

Call the before() method for set this behavior. The parameter must be a Closure.
If you do not want call and define this method, it's ok. It's optional.

```php
$event->before(function() {
	// define here whatever you want execute as an expected behavior
});
```
Call the after() method for set this behavior. The parameter must be a Closure.
If you do not want call and define this method, it's ok. It's optional.

```php
$event->after(function() {
	// define here whatever you want execute as an expected behavior
});
```

Call the run() method for when all is done!

```php
$event->run();
```
Nothing more! It's simple! ;)
You can read or test the [example.php](https://github.com/daltonmenezes/eventScheduler/blob/master/example.php) file at the root directory of this project.

## Problems or suggestions?

Open a [Issue](https://github.com/daltonmenezes/eventScheduler/issues). :)
