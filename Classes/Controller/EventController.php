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

		// User info
		$this->addFlashMessage('<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Mitteilung:</strong> Der Eintrag wurde erfolgreich erstellt.
		</div>',
		 \TYPO3\CMS\Core\Messaging\FlashMessage::OK,
		 TRUE
		);

		// Get back to the calendar
		$this->redirect('list', 'Calendar');
	}

	/**
	 * action edit
	 *
	 * @param \Ki\KiCal\Domain\Model\Event $event
	 * @ignorevalidation $event
	 * @return void
	 */
	public function editAction(\Ki\KiCal\Domain\Model\Event $event) {
		// Get id of the entry
		$event = $this->eventRepository->findByUid($event->getUid());

		// Give entry to the view
		$this->view->assign('detailedEntry', $event);
	}

	/**
	 * action update
	 *
	 * @param \Ki\KiCal\Domain\Model\Event $event
	 * @return void
	 */
	public function updateAction(\Ki\KiCal\Domain\Model\Event $event) {

		// Adjust date format for the database
		$event->setEventDate(date("Y-m-d", strtotime($event->getEventDate())));

		// Update the entry
		$this->eventRepository->update($event);

		// User info
		$this->addFlashMessage('<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Mitteilung:</strong> Der Eintrag wurde erfolgreich aktualisiert.
		</div>',
		 \TYPO3\CMS\Core\Messaging\FlashMessage::OK,
		 TRUE
		);

		// Go back to the calendar
		$this->redirect('list', 'Calendar');
	}

	/**
	 * action delete
	 *
	 * @param \Ki\KiCal\Domain\Model\Event $event
	 * @return void
	 */
	public function deleteAction(\Ki\KiCal\Domain\Model\Event $event) {

		// Delete the entry from the database
		$this->eventRepository->remove($event);

		// User info
		$this->addFlashMessage('<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Mitteilung:</strong> Der Eintrag wurde erfolgreich gelöscht.
		</div>',
		 \TYPO3\CMS\Core\Messaging\FlashMessage::OK,
		 TRUE
		);

		// Go back to the calendar
		$this->redirect('list', 'Calendar');
	}

	/**
	 * action search
	 *
	 * @param \Ki\KiCal\Domain\Model\Event $searchData
	 * @return void
	 */
	public function searchAction(\Ki\KiCal\Domain\Model\Event $searchData) {

		// Search the entry with the given criteria
		$result = $this->eventRepository->getEvent($searchData);

		// Assign the results to the view
		$this->view->assign('queryResult', $result);
	}

}
