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
 * Test case for class Ki\KiCal\Controller\EventController.
 *
 */
class EventControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Ki\KiCal\Controller\EventController
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = $this->getMock('Ki\\KiCal\\Controller\\EventController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenEventToEventRepository() {
		$event = new \Ki\KiCal\Domain\Model\Event();

		$eventRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EventRepository', array('add'), array(), '', FALSE);
		$eventRepository->expects($this->once())->method('add')->with($event);
		$this->inject($this->subject, 'eventRepository', $eventRepository);

		$this->subject->createAction($event);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenEventToView() {
		$event = new \Ki\KiCal\Domain\Model\Event();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$eventRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EventRepository', array(), array(), '', FALSE);
		$this->inject($this->subject, 'view', $view);
		$this->inject($this->subject, 'eventRepository', $eventRepository);
		$view->expects($this->once())->method('assign')->with('detailedEntry', $eventRepository->findByUid($event->getUid()));

		$this->subject->editAction($event);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenEventInEventRepository() {
		$event = new \Ki\KiCal\Domain\Model\Event();

		$eventRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EventRepository', array('update'), array(), '', FALSE);
		$eventRepository->expects($this->once())->method('update')->with($event);
		$this->inject($this->subject, 'eventRepository', $eventRepository);

		$this->subject->updateAction($event);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenEventFromEventRepository() {
		$event = new \Ki\KiCal\Domain\Model\Event();

		$eventRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EventRepository', array('remove'), array(), '', FALSE);
		$eventRepository->expects($this->once())->method('remove')->with($event);
		$this->inject($this->subject, 'eventRepository', $eventRepository);

		$this->subject->deleteAction($event);
	}

	/**
	 * @test
	 */
	public function testSearchAction() {
		$event = new \Ki\KiCal\Domain\Model\Event();
		$event->setEventTitle("Test");

		$object = $this->getMock('Event', array('getEvent'));
		$eventRepository = $this->getMock('Ki\\KiCal\\Domain\\Repository\\EventRepository', array('add', 'getEvent'), array(), '', FALSE);
		$eventRepository->add($entry);
		$object->method('getEvent')
			->with($event)
			->will($this->returnValue($result));

		$this->assertNotNull($object);
	}
}
