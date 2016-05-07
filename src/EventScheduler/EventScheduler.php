<?php
namespace EventScheduler;

use Closure;
use DateTime;
use RuntimeException;

class EventScheduler
{
	private $schedule = array();
	private $currentDateTime;
	private $beforeEvent;
	private $afterEvent;

	public function __construct()
	{
		$this->beforeEvent = array(
			"run" => function() {
		});
		
		$this->afterEvent = array(
			"run" => function() {
		});
	}

	public function schedule(Array $schedule = array(), $dateTimeFormat = null)
	{
		if ($dateTimeFormat === null) {
			$this->currentDateTime = new DateTime(
				date('d-m-Y H:i')
			);
		}

		$this->schedule = $schedule;
		$this->start = new DateTime($this->schedule['start']);
		$this->finish = new DateTime($this->schedule['finish']);
		$this->currentDateTime = new DateTime($dateTimeFormat);	
	}

	public function before(Closure $beforeEvent)
	{
		$this->beforeEvent = array("run" => $beforeEvent);
	}

	public function after(Closure $afterEvent)
	{
		$this->afterEvent = array("run" => $afterEvent);
	}	

	public function run()
	{
		return $this->processExpectedBehaviors();		
	}

	private function processExpectedBehaviors()
	{
		if ($this->isFinishScheduledDate()) {
			return true;
		}
		
		if ($this->isStartScheduledDate()) {
			return $this->afterEvent["run"]();
		}
		return $this->beforeEvent["run"]();			
	}

	private function isStartScheduledDate()
	{
		return $this->currentDateTime >= $this->start;	
	}

	private function isFinishScheduledDate()
	{
		if ($this->finish < $this->start) {
			throw new RuntimeException("The finish date should not be below than start scheduled date!");
		}
		return $this->currentDateTime >= $this->finish;	
	}
}
