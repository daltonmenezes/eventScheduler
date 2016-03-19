<?php

use EventScheduler\EventScheduler;

class EventSchedulerTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->event = new EventScheduler();
	}

	/**
	* @test
	**/
	public function beforeMustBeExecutedWhenCurrentDateIsBelowThanStartScheduledDate()
	{
		$this->schedule = array("start" => "16-03-2017 23:45");

		$this->currentDate = "16-03-2016 19:20";

		$this->event->schedule($this->schedule, $this->currentDate);
		
		$this->event->before(function() {
			return "BEFORE EVENT IS EXECUTED!!!";
		});

		$this->event->after(function() {
			return "AFTER EVENT IS EXECUTED!!!";
		});		

		$this->app = $this->event->run();

		$this->assertEquals("BEFORE EVENT IS EXECUTED!!!", $this->app);
	}

	/**
	* @test
	**/
	public function afterMustBeExecutedWhenCurrentDateIsGreaterThanOrEqualToStartScheduledDate()
	{
		$this->schedule = array("start" => "16-03-2016 19:24");

		$this->currentDate = "16-03-2017 19:20";

		$this->event->schedule($this->schedule, $this->currentDate);		

		$this->event->before(function() {
			return "BEFORE EVENT IS EXECUTED!!!";
		});				
		
		$this->event->after(function() {
			return "AFTER EVENT IS EXECUTED!!!";
		});		

		$this->app = $this->event->run();
		
		$this->assertEquals("AFTER EVENT IS EXECUTED!!!", $this->app);			
	}

	/**
	* @test
	**/
	public function beforeShouldNotBeExecutedWhenAfterIsExecuted()
	{
		$this->schedule = array("start" => "16-03-2016 19:24");

		$this->currentDate = "16-03-2017 19:20";

		$this->event->schedule($this->schedule, $this->currentDate);		

		$this->event->before(function() {
			return "BEFORE EVENT IS EXECUTED!!!";
		});					

		$this->app = $this->event->run();
		
		$this->assertNotEquals("BEFORE EVENT IS EXECUTED!!!", $this->app, "BEFORE WAS EXECUTED WHEN SHOULD NOT!");
	}

	/**
	* @test
	**/
	public function afterShouldNotBeExecutedWhenBeforeIsExecuted()
	{
		$this->schedule = array("start" => "16-03-2017 23:45");

		$this->currentDate = "16-03-2016 19:20";

		$this->event->schedule($this->schedule, $this->currentDate);		
		
		$this->event->after(function() {
			return "AFTER EVENT IS EXECUTED!!!";
		});		

		$this->app = $this->event->run();
		
		$this->assertNotEquals("AFTER EVENT IS EXECUTED!!!", $this->app, "AFTER WAS EXECUTED WHEN SHOULD NOT!");
	}	

}
