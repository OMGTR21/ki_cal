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
 * Test case for class Ki\KiCal\Controller\EntryController.
 *
 */
class EntryControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Ki\KiCal\Controller\EntryController
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = $this->getMock('Ki\\KiCal\\Controller\\EntryController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenEntryToEntryRepository() {
		$entry = new \Ki\KiCal\Domain\Model\Entry();

		$entryRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EntryRepository', array('add'), array(), '', FALSE);
		$entryRepository->expects($this->once())->method('add')->with($entry);
		$this->inject($this->subject, 'entryRepository', $entryRepository);

		$entryRepository->add($entry);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenEntryToView() {
		$entry = new \Ki\KiCal\Domain\Model\Entry();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('entry', $entry);

		$view->assign('entry', $entry);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenEntryInEntryRepository() {
		$entry = new \Ki\KiCal\Domain\Model\Entry();

		$entryRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EntryRepository', array('update'), array(), '', FALSE);
		$entryRepository->expects($this->once())->method('update')->with($entry);
		$this->inject($this->subject, 'entryRepository', $entryRepository);

		$this->subject->updateAction($entry);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenEntryFromEntryRepository() {
		$entry = new \Ki\KiCal\Domain\Model\Entry();

		$entryRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EntryRepository', array('remove'), array(), '', FALSE);
		$entryRepository->expects($this->once())->method('remove')->with($entry);
		$this->inject($this->subject, 'entryRepository', $entryRepository);

		$this->subject->deleteAction($entry);
	}

	/**
	 * @test
	 */
	public function testSearchAction() {
		$entry = new \Ki\KiCal\Domain\Model\Entry();
		$entry->setVisitor("Test");

		$object = $this->getMock('Entry', array('getEntry'));
		$entryRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EntryRepository', array('add', 'getEntry'), array(), '', FALSE);
		$entryRepository->add($entry);
		$object->method('getEntry')
		  ->with($entry)
		  ->will($this->returnValue($result));

		$this->assertNotNull($object);
	}
}
