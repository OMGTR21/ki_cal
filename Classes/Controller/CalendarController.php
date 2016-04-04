<?php
namespace Ki\KiCal\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * CalendarController
 */
class CalendarController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * calendarRepository
	 *
	 * @var \Ki\KiCal\Domain\Repository\CalendarRepository
	 * @inject
	 */
	protected $calendarRepository = NULL;

	/**
	 * eventRepository
	 *
	 * @var \Ki\KiCal\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository;

	/**
	 * entryRepository
	 *
	 * @var \Ki\KiCal\Domain\Repository\EntryRepository
	 * @inject
	 */
	protected $entryRepository;

	/**
	 * cache hash
	 *
	 * @var \TYPO3\CMS\Frontend\Page\CacheHashCalculator
	 */
	protected $cacheHash;

	/**
	 * action show
	 *
	 * @return void
	 */
	public function showAction() {
		$this->redirect('list');
	}

	/**
	* action list
	*
	* @return void
	*/
	public function listAction() {

		$calEntries = $this->entryRepository->findAll();
		$calEvents = $this->eventRepository->findAll();
		$this->cacheHash = new \TYPO3\CMS\Frontend\Page\CacheHashCalculator();

		$jsonEntries = '[';

		foreach($calEntries as $entry) {

			var_dump($entry);
			$actionLinkEntry = $this->generateActionLink("Entry", "edit", $entry, "entry");

			$jsonEntries = $jsonEntries . "{'entryTitle':'" . $entry->getEntryTitle() . "',";
			$jsonEntries = $jsonEntries . "'actionLink':'" . $actionLinkEntry . "',";
			$jsonEntries = $jsonEntries . "'visitor':'" . $entry->getVisitor() . "',";
			$jsonEntries = $jsonEntries . "'entryDate':'" . $entry->getEntryDate() . "'},";
		}

		exit;

		$jsonEntries = substr($jsonEntries, 0, -1);
		$jsonEntries .= ']';

		$jsonEvents = '[';

		foreach($calEvents as $event) {
			$actionLinkEvent = $this->generateActionLink("Event", "edit", $event, "event");

			$jsonEvents = $jsonEvents . "{'eventTitle':'" . $event->getEventTitle() . "',";
			$jsonEvents = $jsonEvents .  "'actionLink':'" . $actionLinkEvent . "',";
			$jsonEvents = $jsonEvents .  "'eventDate':'" . $event->getEventDate() . "'},";
		}

		$jsonEvents = substr($jsonEvents, 0, -1);
		$jsonEvents .= ']';

		// In case of no entries where found
		if($jsonEvents == "]") {
			$jsonEvents = null;
		}
		if($jsonEntries == "]") {
			$jsonEntries = null;
		}

		$this->view->assign('Entries', $calEntries);
		$this->view->assign('Events', $calEvents);
		$this->view->assign('jsonEntries', $jsonEntries);
		$this->view->assign('jsonEvents', $jsonEvents);
	}

	/**
	 * action new
	 *
	 * @return void
	 */
	public function newAction() {

	}

	/**
	 * action create
	 *
	 * @param \Ki\KiCal\Domain\Model\Calendar $newCalendar
	 * @return void
	 */
	public function createAction(\Ki\KiCal\Domain\Model\Calendar $newCalendar) {
		$this->calendarRepository->add($newCalendar);
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Ki\KiCal\Domain\Model\Calendar $calendar
	 * @ignorevalidation $calendar
	 * @return void
	 */
	public function editAction(\Ki\KiCal\Domain\Model\Calendar $calendar) {
		$this->view->assign('calendar', $calendar);
	}

	/**
	 * action update
	 *
	 * @param \Ki\KiCal\Domain\Model\Calendar $calendar
	 * @return void
	 */
	public function updateAction(\Ki\KiCal\Domain\Model\Calendar $calendar) {
		$this->calendarRepository->update($calendar);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Ki\KiCal\Domain\Model\Calendar $calendar
	 * @return void
	 */
	public function deleteAction(\Ki\KiCal\Domain\Model\Calendar $calendar) {
		$this->calendarRepository->remove($calendar);
		$this->redirect('list');
	}

	public static function fileUpload() {

		$targetDir = $_SERVER["DOCUMENT_ROOT"] . "\\" . "fileadmin\user_upload\calendar\\";

		foreach($_FILES["tx_kical_fecal"]["name"] as $filetype=>$value) {

			$filename = $value;
			$fileDir = $targetDir . $filename;

			move_uploaded_file($_FILES["tx_kical_fecal"]["tmp_name"][$filetype], $fileDir);
		}
	}

	public function changeMonthAction() {

		$events = $this->eventRepository->findAll();
		$entries = $this->entryRepository->findAll();

		$this->view->assign('Events', $events);
		$this->view->assign('Entries', $entries);

		exit();
	}

	/**
	*
	* @param string $controller
	* @param string $action
	* @param object $object
	* @param string $type
	* @return string $actionLink
	*/
	public function generateActionLink($controller, $action, $object, $type) {

		$actionLink = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . 'index.php?';
		$query = array(
			'id' => intval($GLOBALS['TSFE']->id)
		);

		$query["tx_kical_fecal"] = array();
		$query["tx_kical_fecal"]["controller"] = $controller;

		$cacheHashArray = $this->cacheHash->getRelevantParameters(\TYPO3\CMS\Core\Utility\GeneralUtility::implodeArrayForUrl('', $query));
		$query['cHash'] = $this->cacheHash->calculateCacheHash($cacheHashArray);

		$query["tx_kical_fecal"][$type] = $object->getUid();
		$query["tx_kical_fecal"]["action"] = $action;

		$actionLink = $actionLink . http_build_query($query);
		return $actionLink;
	}

	/**
	* This function checks what permissions the current user has and returns it
	*
	* @param string $usergroups
	* @return string permission
	*/
	public static function checkPermissions($usergroups) {
		$adm = "505";
		$rw = "507";
		$r = "506";

		// Check if user has admin permissions
		if(strpos($usergroups, $adm) !== false) {
			return "adm";
		}

		// Check if user has read and write permissions
		if(strpos($usergroups, $rw) !== false) {
			return "rw";
		}

		// Check if user has read permission
		if(strpos($usergroups, $r) !== false) {
			return "r";
		}
	}

}
