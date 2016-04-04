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
	public function listActionFetchesAllCalendarsFromRepositoryAndAssignsThemToView() {

		$allCalendars = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$calendarRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\CalendarRepository', array('findAll'), array(), '', FALSE);
		$calendarRepository->expects($this->once())->method('findAll')->will($this->returnValue($allCalendars));
		$this->inject($this->subject, 'calendarRepository', $calendarRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('calendars', $allCalendars);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenCalendarToView() {
		$calendar = new \Ki\KiCal\Domain\Model\Calendar();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('calendar', $calendar);

		$this->subject->showAction($calendar);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenCalendarToView() {
		$calendar = new \Ki\KiCal\Domain\Model\Calendar();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newCalendar', $calendar);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($calendar);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenCalendarToCalendarRepository() {
		$calendar = new \Ki\KiCal\Domain\Model\Calendar();

		$calendarRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\CalendarRepository', array('add'), array(), '', FALSE);
		$calendarRepository->expects($this->once())->method('add')->with($calendar);
		$this->inject($this->subject, 'calendarRepository', $calendarRepository);

		$this->subject->createAction($calendar);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenCalendarToView() {
		$calendar = new \Ki\KiCal\Domain\Model\Calendar();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('calendar', $calendar);

		$this->subject->editAction($calendar);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenCalendarInCalendarRepository() {
		$calendar = new \Ki\KiCal\Domain\Model\Calendar();

		$calendarRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\CalendarRepository', array('update'), array(), '', FALSE);
		$calendarRepository->expects($this->once())->method('update')->with($calendar);
		$this->inject($this->subject, 'calendarRepository', $calendarRepository);

		$this->subject->updateAction($calendar);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenCalendarFromCalendarRepository() {
		$calendar = new \Ki\KiCal\Domain\Model\Calendar();

		$calendarRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\CalendarRepository', array('remove'), array(), '', FALSE);
		$calendarRepository->expects($this->once())->method('remove')->with($calendar);
		$this->inject($this->subject, 'calendarRepository', $calendarRepository);

		$this->subject->deleteAction($calendar);
	}
}
