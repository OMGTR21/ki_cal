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
 * Test case for class Ki\KiCal\Controller\CalendarController.
 *
 */
class CalendarControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Ki\KiCal\Controller\CalendarController
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = $this->getMock('Ki\\KiCal\\Controller\\CalendarController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionRedirectsToShowAction() {

		$eventRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EventRepository', array('findAll'), array(), '', FALSE);
		$entryRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EntryRepository', array('findAll'), array(), '', FALSE);
		$calEntries = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);
		$calEvents = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$eventRepository->expects($this->once())->method('findAll')->will($this->returnValue($calEvents));
		$entryRepository->expects($this->once())->method('findAll')->will($this->returnValue($calEntries));
		$this->inject($this->subject, 'eventRepository', $eventRepository);
		$this->inject($this->subject, 'entryRepository', $entryRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenCalendarToView() {
		$calendar = new \Ki\KiCal\Domain\Model\Calendar();
		$this->subject->showAction($calendar);
	}

	/**
	* @test
	*/
	public function generateActionLinkTest() {
		$entry = new \Ki\KiCal\Domain\Model\Entry();
		$cacheHash = new \TYPO3\CMS\Frontend\Page\CacheHashCalculator();

		$this->inject($this->subject, 'cacheHash', $cacheHash);

		$this->assertInternalType('string', \Ki\KiCal\Controller\CalendarController::generateActionLink("Entry", "edit", $entry, "entry"));
	}

	/**
	* @test
	*/
	public function checkPermissionsTest() {
		$calendar = new \Ki\KiCal\Controller\CalendarController();

		$this->assertEquals('adm', $calendar->checkPermissions("505"));
		$this->assertEquals('r', $calendar->checkPermissions("506"));
		$this->assertEquals('rw', $calendar->checkPermissions("507"));
	}
}
