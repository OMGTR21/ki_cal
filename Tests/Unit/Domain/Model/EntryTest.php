<?php

namespace Ki\KiCal\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016
 *
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
 * Test case for class \Ki\KiCal\Domain\Model\Entry.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EntryTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Ki\KiCal\Domain\Model\Entry
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = new \Ki\KiCal\Domain\Model\Entry();
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getEntryTitleReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEntryTitle()
		);
	}

	/**
	 * @test
	 */
	public function setEntryTitleForStringSetsTitle() {
		$this->subject->setEntryTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'entryTitle',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsTitle() {
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEntryDateReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEntryDate()
		);
	}

	/**
	 * @test
	 */
	public function setEntryDateForStringSetsTitle() {
		$this->subject->setEntryDate('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'entryDate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getStartTimeReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getStartTime()
		);
	}

	/**
	 * @test
	 */
	public function setStartTimeForStringSetsTitle() {
		$this->subject->setStartTime('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'startTime',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEndTimeReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEndTime()
		);
	}

	/**
	 * @test
	 */
	public function setEndTimeForStringSetsTitle() {
		$this->subject->setEndTime('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'endTime',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getVisitorReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getVisitor()
		);
	}

	/**
	 * @test
	 */
	public function setVisitorForStringSetsTitle() {
		$this->subject->setVisitor('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'visitor',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCompanyReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getCompany()
		);
	}

	/**
	 * @test
	 */
	public function setCompanyForStringSetsTitle() {
		$this->subject->setCompany('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'company',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getContactReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getContact()
		);
	}

	/**
	 * @test
	 */
	public function setContactForStringSetsTitle() {
		$this->subject->setContact('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'contact',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPublicReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getPublic()
		);
	}

	/**
	 * @test
	 */
	public function setPublicForStringSetsTitle() {
		$this->subject->setPublic('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'public',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getImageReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getImage()
		);
	}

	/**
	 * @test
	 */
	public function setImageForStringSetsTitle() {
		$this->subject->setImage('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'image',
			$this->subject
		);
	}
}
