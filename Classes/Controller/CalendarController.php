<?php
namespace Ki\KiCal\Controller;
error_reporting(E_ALL ^ E_NOTICE);

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
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		$this->redirect('list');
	}

	/**
	* action list
	*
	* @return void
	*/
	public function listAction() {

		$all_calendar_entries = null;
		$all_calendar_events = null;
		$json_entries = '[';

		// Get all calendar entries
		$all_calendar_entries = $this->entryRepository->findAll();

		// Get all calendar events
		$all_calendar_events = $this->eventRepository->findAll();

		// Check if the calendar entries and events are objects
		try {
			if(is_object($all_calendar_events) === False || $all_calendar_events === False) {
				throw new \Exception('Error while creating entry objects.');
			}
		} catch (\Exception $ex) {
			echo $ex->getMessage() . ' in ' . $ex->getFile() . ' (Line ' . $ex->getLine() . ') ';
		}

		// Go through all calendar entries
		foreach($all_calendar_entries as $entry) {

			$action_link_entry = $this->generateActionLink("Entry", "edit", $entry, "entry");

			// If the current entry has no entry title, take the visitor
			if(strcmp($entry->getEntryTitle, '') === 0) {
				$json_entries = $json_entries . "{'entryTitle':'" . $entry->getEntryTitle() . "',";
				$json_entries = $json_entries . "'actionLink':'" . $action_link_entry . "',";
				$json_entries = $json_entries . "'visitor':'" . $entry->getVisitor() . "',";
				$json_entries = $json_entries . "'entryDate':'" . $entry->getEntryDate() . "'},";
			}else {
				$json_entries = $json_entries . "{'entryTitle':'" . $entry->getEntryTitle() . "',";
				$json_entries = $json_entries . "'actionLink':'" . $action_link_entry . "',";
				$json_entries = $json_entries . "'visitor':'" . $entry->getVisitor() . "',";
				$json_entries = $json_entries . "'entryDate':'" . $entry->getEntryDate() . "'},";
			}
		}

		$json_entries = substr($json_entries, 0, -1);
		$json_entries .= ']';

		// Create JSON string for the events
		$json_events = '[';

		// Go through all calendar events
		foreach($all_calendar_events as $event) {
			$action_link_event = $this->generateActionLink("Event", "edit", $event, "event");
			// echo $action_link_event . ' // ' . $event->getEventDate() . '<br />';

			$json_events = $json_events . "{'eventTitle':'" . $event->getEventTitle() . "',";
			$json_events = $json_events .  "'actionLink':'" . $action_link_event . "',";
			$json_events = $json_events .  "'eventDate':'" . $event->getEventDate() . "'},";
		}

		$json_events = substr($json_events, 0, -1);
		$json_events .= ']';

		// If no entries were found, set the var to null
		if($json_events == "]") {
			$json_events = null;
		}
		if($json_entries == "]") {
			$json_entries = null;
		}

		// Asign the entries to the view
		$this->view->assign('Entries', $all_calendar_entries);
		$this->view->assign('Events', $all_calendar_events);
		$this->view->assign('jsonEntries', $json_entries);
		$this->view->assign('jsonEvents', $json_events);
	}

	/**
	* Function for file upload
	*/
	public static function fileUpload() {

		// Set the target directory for the file
		$target_dir = $_SERVER['DOCUMENT_ROOT'] . '/fileadmin/user_upload/calendar/';

		// Get the file name
		$filename = $_FILES['tx_kical_fecal']['name']['new_entry_data']['image'];

		// Create full path
		$full_path = $target_dir . $filename;

		// Get the temp file name
		$temp_filename = $_FILES['tx_kical_fecal']['tmp_name']['new_entry_data']['image'];

		// Move the file
		move_uploaded_file($temp_filename, $full_path);
	}

	/**
	*
	* @param string $controller
	* @param string $action
	* @param object $object
	* @param string $type
	* @return string $actionLink
	*/
	public function generateActionLink($controller, $controller_action, $entry_object, $entry_type) {

		// Get current URL
		$action_link = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . 'index.php?';

		// Get Typo3 site ID
		$typo_site_id = intval($GLOBALS['TSFE']->id);

		// Get UID of the current entry
		$entry_uid = $entry_object->getUid();

		// Create array with url parts
		$http_url_arr = array(
			'id' => $typo_site_id,
			'tx_kical_fecal' => array(
				'action' => $controller_action,
				'controller' => $controller,
				$entry_type => $entry_uid
			)
		);

		// Create action url
		return $action_link . http_build_query($http_url_arr);
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
