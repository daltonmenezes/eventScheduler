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
	public function beforeEventMustBeExecutedWhenCurrentDateIsBelowThanStartScheduledDate()
	{
		$this->schedule = array(
			"start" => "16-03-2017 23:45",
			"finish" => "20-03-2018 14:13"
		);

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
	public function afterEventMustBeExecutedWhenCurrentDateIsGreaterThanOrEqualToStartScheduledDate()
	{
		$this->schedule = array(
			"start" => "16-03-2016 19:24",
			"finish" => "20-03-2017 14:13"
		);

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
	public function afterEventShouldNotBeExecutedWhenCurrentDateIsGreaterThanOrEqualToFinishScheduledDate()
	{
		$this->schedule = array(
			"start" => "16-03-2016 19:24",
			"finish" => "10-03-2017 14:13"
		);

		$this->currentDate = "10-03-2017 14:13";

		$this->event->schedule($this->schedule, $this->currentDate);					
		
		$this->event->after(function() {
			return "AFTER EVENT IS EXECUTED!!!";
		});		

		$this->app = $this->event->run();
		
		$this->assertNotEquals("AFTER EVENT IS EXECUTED!!!", $this->app);			
	}	

	/**
	* @test
	**/
	public function beforeEventShouldNotBeExecutedWhenAfterEventIsExecuted()
	{
		$this->schedule = array(
			"start" => "16-03-2016 19:24",
			"finish" => "20-03-2017 14:13"
		);

		$this->currentDate = "16-03-2017 19:20";

		$this->event->schedule($this->schedule, $this->currentDate);		

		$this->event->before(function() {
			return "BEFORE EVENT IS EXECUTED!!!";
		});					

		$this->app = $this->event->run();
		
		$this->assertNotEquals("BEFORE EVENT IS EXECUTED!!!", $this->app, "BEFORE EVENT WAS EXECUTED WHEN SHOULD NOT!");
	}

	/**
	* @test
	**/
	public function afterEventShouldNotBeExecutedWhenBeforeEventIsExecuted()
	{
		$this->schedule = array(
			"start" => "16-03-2017 23:45",
			"finish" => "20-03-2017 14:13"
		);

		$this->currentDate = "16-03-2016 19:20";

		$this->event->schedule($this->schedule, $this->currentDate);		
		
		$this->event->after(function() {
			return "AFTER EVENT IS EXECUTED!!!";
		});		

		$this->app = $this->event->run();
		
		$this->assertNotEquals("AFTER EVENT IS EXECUTED!!!", $this->app, "AFTER EVENT WAS EXECUTED WHEN SHOULD NOT!");
	}

	/**
	* @test
	* @expectedException RuntimeException
	* @expectedExceptionMessage The finish date should not be below than start scheduled date!
	**/
	public function throwExceptionWhenFinishDateIsBelowThanStartScheduledDate()
	{
		$this->schedule = array(
			"start" => "16-03-2016 19:24",
			"finish" => "10-03-2016 14:13"
		);

		$this->event->schedule($this->schedule);
		$this->event->run();
	}
}
