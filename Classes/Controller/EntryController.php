<?php
namespace Ki\KiCal\Controller;
error_reporting(E_ALL ^  E_NOTICE);

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
 * EntryController
 */
class EntryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * entryRepository
	 *
	 * @var \Ki\KiCal\Domain\Repository\EntryRepository
	 * @inject
	 */
	protected $entryRepository = NULL;


	/**
	 * Create a new entry
	 *
	 * @param \Ki\KiCal\Domain\Model\Entry $new_entry_data
	 * @return void
	 */
	public function createAction(\Ki\KiCal\Domain\Model\Entry $new_entry_data) {

		// Create and set the full image path
			$full_path = ('/fileadmin/user_upload/calendar/' . $_FILES['tx_kical_fecal']['name']['image']);
		$new_entry_data->setImage($full_path);

		// Process the file upload
		CalendarController::fileUpload();

		// Convert the date to the db matching format
		$new_entry_data->setEntryDate(date("Y-m-d", strtotime($new_entry_data->getEntryDate())));

		// Create a new entry
		$this->entryRepository->add($new_entry_data);

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
	 * @param \Ki\KiCal\Domain\Model\Entry $entry
	 * @ignorevalidation $entry
	 * @return void
	 */
	public function editAction(\Ki\KiCal\Domain\Model\Entry $entry) {

		// Get the entry with the given UID
		$entry_data = $this->entryRepository->findByUid($entry->getUid());

		// Get image path
		$image = $this->entryRepository->getImageByUid($entry);
		$image_arr = $image->toArray();

		// Set image path
		$entry_data->setImage($image_arr[0]->getImage());

		// Assign the entry data to the view
		$this->view->assign('detailedEntry', $entry_data);
	}

	/**
	 * action update
	 *
	 * @param \Ki\KiCal\Domain\Model\Entry $entry
	 * @return void
	 */
	public function updateAction(\Ki\KiCal\Domain\Model\Entry $entry) {

		// Create and set the full image path
		$full_path = ('/fileadmin/user_upload/calendar/' . $_FILES['tx_kical_fecal']['name']['image']);
		$entry->setImage($full_path);

		var_dump($entry);
		// exit;

		// Process the file upload
		CalendarController::fileUpload();

		// Adjust date format for the database
		$entry->setEntryDate(date("Y-m-d", strtotime($entry->getEntryDate())));

		// Update the entry
		$this->entryRepository->update($entry);

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
		exit;
	}

	/**
	 * action delete
	 *
	 * @param \Ki\KiCal\Domain\Model\Entry $entry
	 * @return void
	 */
	public function deleteAction(\Ki\KiCal\Domain\Model\Entry $entry) {

		// Remove the entry
		$this->entryRepository->remove($entry);

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
		exit;
	}

	/**
	 * action search
	 *
	 * @param \Ki\KiCal\Domain\Model\Entry $searchData
	 * @return void
	 */
	public function searchAction(\Ki\KiCal\Domain\Model\Entry $searchData) {
		// Search with the overgiven criterias
		$result = $this->entryRepository->getEntry($searchData);

		// Give results to view
		$this->view->assign('queryResult', $result);
	}

}
