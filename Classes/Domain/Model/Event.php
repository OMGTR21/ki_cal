<?php
namespace Ki\KiCal\Domain\Model;

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
 * Event
 */
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * eventTitle
	 *
	 * @var string
	 */
	protected $eventTitle;

	/**
	 * eventDate
	 *
	 * @var string
	 */
	protected $eventDate;

	/**
	 * Returns the event title
	 *
	 * @return string $eventTitle
	 */
	public function getEventTitle() {
		return $this->eventTitle;
	}

	/**
	 * Sets the event title
	 *
	 * @param string $eventTitle
	 * @return void
	 */
	public function setEventTitle($eventTitle) {
		$this->eventTitle = $eventTitle;
	}

	/**
	 * Returns the event date
	 *
	 * @return string $eventDate
	 */
	public function getEventDate() {
		return $this->eventDate;
	}

	/**
	 * Sets the event date
	 *
	 * @param string $eventDate
	 * @return void
	 */
	public function setEventDate($eventDate) {
		$this->eventDate = $eventDate;
	}
}
