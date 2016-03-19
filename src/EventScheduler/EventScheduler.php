<?php
namespace EventScheduler;
use Closure;
use DateTime;
use RuntimeException;

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
		$this->finish = new DateTime($this->schedule['finish']);
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
		if ($this->isFinishScheduledDate()) {
			return true;
		}
		
		if ($this->isStartScheduledDate()) {
			return $this->afterClosure["run"]();
		}
		return $this->beforeClosure["run"]();			
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