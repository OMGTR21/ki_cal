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
 * EventController
 */
class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * eventRepository
	 *
	 * @var \Ki\KiCal\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;

	/**
	* Persistence Manager
	*
	*@var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	*@inject
	*/
	protected $persistenceManager;

	/**
	 * action list
	 *
	 * @param \Ki\KiCal\Domain\Model\Event $event
	 * @return void
	 */
	public function listAction(\Ki\KiCal\Domain\Model\Event $event) {

	}

	/**
	 * action show
	 *
	 * @return void
	 */
	public function showAction() {

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
	 * @param \Ki\KiCal\Domain\Model\Event $newEvent
	 * @return void
	 */
	public function createAction(\Ki\KiCal\Domain\Model\Event $newEvent) {

		// Convert date format for db
		$newEvent->setEventDate(date("Y-m-d", strtotime($newEvent->getEventDate())));

		// Create new entry in db
		$this->eventRepository->add($newEvent);

		// Get back to the calendar
		$this->redirect('show');
	}

	/**
	 * action edit
	 *
	 * @param \Ki\KiCal\Domain\Model\Event $event
	 * @return void
	 */
	public function editAction(\Ki\KiCal\Domain\Model\Event $event) {
		$entryData = $this->eventRepository->findByUid($event->getUid());
		$this->view->assign('detailedEntry', $entryData);
	}

	/**
	 * action update
	 *
	 * @param \Ki\KiCal\Domain\Model\Event $event
	 * @return void
	 */
	public function updateAction(\Ki\KiCal\Domain\Model\Event $event) {
		// Convert date format for db
		$event->setEventDate(date("Y-m-d", strtotime($event->getEventDate())));
		$this->eventRepository->update($event);
		$this->redirect('list', 'Calendar');
	}

	/**
	 * action delete
	 *
	 * @param \Ki\KiCal\Domain\Model\Event $event
	 * @return void
	 */
	public function deleteAction(\Ki\KiCal\Domain\Model\Event $event) {
		$this->eventRepository->remove($event);
		$this->redirect('list', 'Calendar');
	}

	/**
	 * action search
	 *
	 * @param \Ki\KiCal\Domain\Model\Event $searchData
	 * @return void
	 */
	public function searchAction(\Ki\KiCal\Domain\Model\Event $searchData) {
		$result = $this->eventRepository->getEvent($searchData);
		$this->view->assign('queryResult', $result);
	}

}
