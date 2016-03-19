<?php
namespace EventScheduler;
use Closure;
use DateTime;

class EventScheduler
{
	private $schedule = array();
	private $currentDateTime;
	private $beforeClosure;
	private $afterClosure;

	public function __construct()
	{
		$this->beforeClosure = array(
			"run" => function() {
		});
		
		$this->afterClosure = array(
			"run" => function() {
		});
	}

	public function schedule(Array $schedule = array(), $handlerDateTime = null)
	{
		if ($handlerDateTime === null) {
			$this->currentDateTime = new DateTime(
				date('d-m-Y H:i')
			);
		}

		$this->schedule = $schedule;
		$this->start = new DateTime($this->schedule['start']);
		$this->currentDateTime = new DateTime($handlerDateTime);	
	}

	public function before(Closure $beforeClosure)
	{
		$this->beforeClosure = array("run" => $beforeClosure);
	}

	public function after(Closure $afterClosure)
	{
		$this->afterClosure = array("run" => $afterClosure);
	}	

	public function run()
	{
		return $this->processExpectedBehaviors();		
	}

	private function processExpectedBehaviors()
	{
		if ($this->isStartExpectedDate()) {
			return $this->afterClosure["run"]();
		}
		return $this->beforeClosure["run"]();			
	}

	private function isStartExpectedDate()
	{
		return $this->currentDateTime >= $this->start;	
	}


}