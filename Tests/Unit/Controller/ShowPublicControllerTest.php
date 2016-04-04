<?php
namespace Ki\KiCal\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Ki\KiCal\Controller\ShowPublicController.
 *
 */
class ShowPublicControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Ki\KiCal\Controller\ShowPublicController
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = $this->getMock('Ki\\KiCal\\Controller\\ShowPublicController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllShowPublicsFromRepositoryAndAssignsThemToView() {

		$allShowPublics = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$showPublicRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\ShowPublicRepository', array('findAll'), array(), '', FALSE);
		$showPublicRepository->expects($this->once())->method('findAll')->will($this->returnValue($allShowPublics));
		$this->inject($this->subject, 'showPublicRepository', $showPublicRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('showPublics', $allShowPublics);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenShowPublicToView() {
		$showPublic = new \Ki\KiCal\Domain\Model\ShowPublic();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('showPublic', $showPublic);

		$this->subject->showAction($showPublic);
	}
}
