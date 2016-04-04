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
 * ShowPublicController
 */
class ShowPublicController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * showPublicRepository
	 *
	 * @var \Ki\KiCal\Domain\Repository\ShowPublicRepository
	 * @inject
	 */
	protected $showPublicRepository = NULL;

	/**
	 * entryRepository
	 *
	 * @var \Ki\KiCal\Domain\Repository\EntryRepository
	 * @inject
	 */
	protected $entryRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$showPublics = $this->showPublicRepository->findAll();
		$this->view->assign('showPublics', $showPublics);
	}

	/**
	 * action show
	 *
	 * @param \Ki\KiCal\Domain\Model\ShowPublic $showPublic
	 * @return void
	 */
	public function showAction(\Ki\KiCal\Domain\Model\ShowPublic $showPublic) {
		$this->view->assign('showPublic', $showPublic);
	}



}