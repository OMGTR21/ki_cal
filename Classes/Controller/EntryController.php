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
	 * action create entry
	 *
	 * @param \Ki\KiCal\Domain\Model\Entry $newEntry
	 * @return void
	 */
	public function createAction(\Ki\KiCal\Domain\Model\Entry $newEntry) {

		// Check Permissions
		if(\Ki\KiCal\Controller\CalendarController::checkPermissions($GLOBALS["TSFE"]->fe_user->user["usergroup"]) == "adm" ||
			\Ki\KiCal\Controller\CalendarController::checkPermissions($GLOBALS["TSFE"]->fe_user->user["usergroup"]) == "rw") {

			$image = $newEntry->getImage();
			$newEntry->setImage($_SERVER["DOCUMENT_ROOT"] . "\\" . "fileadmin\user_upload\calendar\\" . $image["name"]);

			CalendarController::fileUpload();

			// Convert date format for db
			$newEntry->setEntryDate(date("Y-m-d", strtotime($newEntry->getEntryDate())));

			// Create new entry in db
			$this->entryRepository->add($newEntry);

			// Get back to the calendar
			$this->redirect('list', 'Calendar');
			exit;
		}else {
			$this->flashMessageContainer->add('<div class="alert alert-warning alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Warnung!</strong> Sie besitzen keine Rechte zum Ausführen dieser Aktion.
			</div>', "", \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING);
			$this->redirect('list', 'Calendar');
			exit;
		}
	}

	/**
	 * action edit
	 *
	 * @param \Ki\KiCal\Domain\Model\Entry $entry
	 * @ignorevalidation $entry
	 * @return void
	 */
	public function editAction(\Ki\KiCal\Domain\Model\Entry $entry) {
		$entryData = $this->entryRepository->findByUid($entry->getUid());
		$this->view->assign('detailedEntry', $entryData);
	}

	/**
	 * action update
	 *
	 * @param \Ki\KiCal\Domain\Model\Entry $entry
	 * @return void
	 */
	public function updateAction(\Ki\KiCal\Domain\Model\Entry $entry) {
		$this->entryRepository->update($entry);
		$this->redirect('list', 'Calendar');
	}

	/**
	 * action delete
	 *
	 * @param \Ki\KiCal\Domain\Model\Entry $entry
	 * @return void
	 */
	public function deleteAction(\Ki\KiCal\Domain\Model\Entry $entry) {
		$this->entryRepository->remove($entry);
		$this->redirect('list', 'Calendar');
	}

	/**
	 * action search
	 *
	 * @param \Ki\KiCal\Domain\Model\Entry $searchData
	 * @return void
	 */
	public function searchAction(\Ki\KiCal\Domain\Model\Entry $searchData) {
		$result = $this->entryRepository->getEntry($searchData);
		$this->view->assign('queryResult', $result);
		exit;
	}

}
