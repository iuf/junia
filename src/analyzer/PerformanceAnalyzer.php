<?php
namespace iuf\junia\analyzer;

use iuf\junia\model\Event;
use iuf\junia\model\Startgroup;
use iuf\junia\model\Routine;
use iuf\junia\model\PerformanceStatistic;
use phootwork\collection\ArrayList;
use phootwork\collection\Map;

class PerformanceAnalyzer {
	
	private $targets = [
		'total' => 'Total',
		'execution' => 'Execution',
		'choreography' => 'Choreography',
		'music' => 'MusicAndTiming'
	];
	
	private $all;

	public function __construct() {
		$this->all = new Map();
		$this->prepareMap($this->all);
	}
	
	private function prepareMap(Map $map) {
		foreach (array_keys($this->targets) as $target) {
			$map->set($target, new ArrayList());
		}
	}
	
	public function analyze(Event $event) {
		foreach ($event->getStartgroups() as $group) {
			$this->analyzeGroup($group);
		}
		
		$this->processSummary($event, $this->all);
		$event->save();
	}
	
	private function analyzeGroup(Startgroup $group) {
		$groups = new Map();
		$this->prepareMap($groups);
		
		foreach ($group->getRoutines() as $routine) {
			foreach ($this->targets as $key => $target) {
				$getter = sprintf('getPerformance%sStatistic', $target);
				$statistic = $routine->$getter();
				if ($statistic === null) {
					$setter = sprintf('setPerformance%sStatistic', $target);
					$statistic = new PerformanceStatistic();
					$routine->$setter($statistic);
				}
				$statistic = $this->analyzeRoutine($routine, $statistic, $target);
				$this->all->get($key)->add($statistic);
				$groups->get($key)->add($statistic);
			}
			$routine->save();
		}
		
		$this->processSummary($group, $groups);
		$group->save();
	}
	
	private function analyzeRoutine(Routine $routine, PerformanceStatistic $statistic, $target) {
		$sum = 0;
		$min = 30;
		$max = 0;
		$scores = $routine->getPerformanceScores()->count();
		$values = [];
		
		foreach ($routine->getPerformanceScores() as $score) {
			$method = 'get' . $target;
			$val = $score->$method();
			$min = min($min, $val);
			$max = max($max, $val);
			$sum += $val;
			$values[] = $val;
		}
		
		$avg = $sum / $scores;
		
		$statistic->setAverage($avg);
		$statistic->setMin($min);
		$statistic->setMax($max);
		$statistic->setRange(abs($max - $min));
		
		// median
		sort($values);
		if ($scores % 2 == 0) {
			$lower = floor($scores / 2);
			$upper = ceil($scores / 2);
			$md = ($values[$lower] + $values[$upper]) / 2;
		} else {
			$md = $values[ceil($scores / 2)];
		}
		$statistic->setMedian($md);
		
		// sd + variance
		$sum = 0;
		foreach ($routine->getPerformanceScores() as $score) {
			$method = 'get' . $target;
			$sum += pow($val - $avg, 2);
		}
		
		$v = 1 / ($scores - 1) * $sum;
		$sd = sqrt($v);
		
		$statistic->setVariance($v);
		$statistic->setStandardDeviation($sd);
		$statistic->setVariabilityCoefficient($sd / $avg * 100);
		$statistic->save();
		
		return $statistic;
	}
	
	private function processSummary($model, $map) {
		$size = $map->get('total')->size();
		foreach ($this->targets as $key => $target) {
			$getter = sprintf('getPerformance%sStatistic', $target);
			if (method_exists($model, $getter)) {
				$statistic = $model->$getter();
				if ($statistic === null) {
					$setter = sprintf('setPerformance%sStatistic', $target);
					$statistic = new PerformanceStatistic();
					$model->$setter($statistic);
				}
				
				$statistic->setMin($map->get($key)->reduce(function ($a, $stat) {
					return $a + $stat->getMin();
				}) / $size);
				
				$statistic->setMax($map->get($key)->reduce(function ($a, $stat) {
					return $a + $stat->getMax();
				}) / $size);
				
				$statistic->setRange($map->get($key)->reduce(function ($a, $stat) {
					return $a + $stat->getRange();
				}) / $size);
				
				$statistic->setMedian($map->get($key)->reduce(function ($a, $stat) {
					return $a + $stat->getMedian();
				}) / $size);
				
				$statistic->setAverage($map->get($key)->reduce(function ($a, $stat) {
					return $a + $stat->getAverage();
				}) / $size);
				
				$statistic->setStandardDeviation($map->get($key)->reduce(function ($a, $stat) {
					return $a + $stat->getStandardDeviation();
				}) / $size);
				
				$statistic->setVariance($map->get($key)->reduce(function ($a, $stat) {
					return $a + $stat->getVariance();
				}) / $size);
				
				$statistic->setVariabilityCoefficient($map->get($key)->reduce(function ($a, $stat) {
					return $a + $stat->getVariabilityCoefficient();
				}) / $size);
				
				$statistic->save();
			}
		}
	}
	
}