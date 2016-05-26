<?php
namespace iuf\junia\importer;

use League\Csv\Reader;
use iuf\junia\model\Event;
use iuf\junia\model\Startgroup;
use iuf\junia\model\CompetitionQuery;
use phootwork\collection\Map;
use phootwork\lang\Text;
use iuf\junia\model\PerformanceScore;
use iuf\junia\model\Routine;
use iuf\junia\model\Competition;
use keeko\framework\utils\NameUtils;
use phootwork\collection\Set;

class SchubertImporter implements ImporterInterface {
	
	const ID = 'schubert';
	
	private $competitions;
	private $routines;
	
	private $translations = [
		'weiblich' => '(female)',
		'maennlich' => '(male)',
		'Einzelkuer' => 'Individual Freestyle',
		'Einzel' => 'Individual Freestyle',
		'Paarkuer' => 'Pairs Freestyle',
		'Paar' => 'Pairs Freestyle',
		'Kleingruppen' => 'Small Group Freestyle',
		'Kleingruppe' => 'Small Group Freestyle',
		'Klein-Gruppe' => 'Small Group Freestyle',
		'Grossgruppen' => 'Large Group Freestyle',
		'Grossgruppe' => 'Large Group Freestyle',
		'Gross-Gruppen' => 'Large Group Freestyle'
	];
	
	public function __construct() {
		$this->competitions = new Map();
		$this->routines = new Map();
		foreach (CompetitionQuery::create()->find() as $comp) {
			$this->competitions->set($comp->getLabel(), $comp);
		}
	}
	
	/**
	 * 
	 */
	public function import($data, Event $event) {
		$csv = Reader::createFromString(trim($data));
		$csv->setDelimiter(';');

		// get startgroups at first
		$groups = new Map();
		foreach ($csv->fetchColumn(0) as $name) {
			if (!$groups->has($name)) {
				$startgroup = $this->getStartgroup($name);
				$startgroup->setEvent($event);
				$groups->set($name, $startgroup);
			}
		}
		
		$id = 0;
		foreach ($csv as $row) {
			$id++;
			$routine = $this->getRoutine($id);
			$group = $groups->get($row[0]);
			$judges = (count($row) - 1) / 3;

			for ($j = 1; $j <= $judges; $j++) {
				$score = new PerformanceScore();
				$score->setRoutine($routine);
				$score->setJudge($group->getPerformanceJudge($j));
				$score->setExecution($row[(($j - 1) * 3) + 1]);
				$score->setChoreography($row[(($j - 1) * 3) + 2]);
				$score->setMusicAndTiming($row[(($j - 1) * 3) + 3]);
				$score->setTotal($row[(($j - 1) * 3) + 1] + $row[(($j - 1) * 3) + 2] + $row[(($j - 1) * 3) + 3]);
				$routine->addPerformanceScore($score);
			}
				
			$group->addRoutine($routine);
			$group->save();
		}
		
		$event->save();
	}
	
	private function translate($string) {
		return str_replace(array_keys($this->translations), $this->translations, $string);
	}
	
	/**
	 * @param string $name
	 * @return Startgroup
	 */
	private function getStartgroup($name) {
		$name = $this->translate($name);
		
		// some special cases
		$competition = null;
		if ($name == 'Junior Expert (male)' || $name == 'Expert (male)') {
			$competition = $this->competitions->get('Individual Freestyle (male)');
			$startgroupName = str_replace(' (male)', '', $name);
		} else if ($name == 'Junior Expert (female)' || $name == 'Expert (female)') {
			$competition = $this->competitions->get('Individual Freestyle (female)');
			$startgroupName = str_replace(' (female)', '', $name);
		}
		
		if ($competition === null) {
			$words = new Set();
			foreach (array_values($this->translations) as $names) {
				$words->addAll(Text::create($names)->split(' '));
			}
			
			$startgroupName = trim(str_replace($words->toArray(), '', $name));
			$words = Text::create($startgroupName)->split(' ');
			$competitionName = preg_replace('/\s\s+/', ' ', trim(str_replace($words->toArray(), '', $name)));
			if (!$this->competitions->has($competitionName)) {
				throw new \Exception('Cannot find competition for ' . $competitionName);
			}
			
			$competition = $this->competitions->get($competitionName);
		}

		$startgroup = new Startgroup();
		$startgroup->setName($startgroupName);
		$startgroup->setSlug(NameUtils::dasherize(strtolower($startgroupName)));
		$startgroup->setCompetition($competition);
		return $startgroup;
	}
	
	/**
	 * 
	 * @param string $id
	 * @return Routine
	 */
	private function getRoutine($id) {
		if (!$this->routines->has($id)) {
			$routine = new Routine();
			$routine->setName('Routine #' . $id);
			$this->routines->set($id, $routine);
		}
	
		return $this->routines->get($id);
	}
}