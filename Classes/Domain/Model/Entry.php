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
 * Entry
 */
class Entry extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * entryTitle
	 *
	 * @var string
	 */
	protected $entryTitle;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * entryDate
	 *
	 * @var string
	 */
	protected $entryDate;

	/**
	 * startTime
	 *
	 * @var string
	 */
	protected $startTime;

	/**
	 * endTime
	 *
	 * @var string
	 */
	protected $endTime;

	/**
	 * visitor
	 *
	 * @var string
	 */
	protected $visitor;

	/**
	 * company
	 *
	 * @var string
	 */
	protected $company;

	/**
	 * contact
	 *
	 * @var string
	 */
	protected $contact;

	/**
	 * public
	 *
	 * @var string
	 */
	protected $public;

	/**
	 * image
	 *
	 * @var array
	 */
	protected $image;

	/**
	 * Returns the entryTitle
	 *
	 * @return string $entryTitle
	 */
	public function getEntryTitle() {
		return $this->entryTitle;
	}

	/**
	 * Sets the entryTitle
	 *
	 * @param string $entryTitle
	 * @return void
	 */
	public function setEntryTitle($entryTitle) {
		$this->entryTitle = $entryTitle;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the entry date
	 *
	 * @return string $entryDate
	 */
	public function getEntryDate() {
		return $this->entryDate;
	}

	/**
	 * Sets the entry date
	 *
	 * @param string $entryDate
	 * @return void
	 */
	public function setEntryDate($entryDate) {
		$this->entryDate = $entryDate;
	}

	/**
	 * Returns the start time
	 *
	 * @return string $startTime
	 */
	public function getStartTime() {
		return $this->startTime;
	}

	/**
	 * Sets the start time
	 *
	 * @param string $startTime
	 * @return void
	 */
	public function setStartTime($startTime) {
		$this->startTime =  $startTime;
	}

	/**
	 * Returns the end time
	 *
	 * @return string $endTime
	 */
	public function getEndTime() {
		return $this->endTime;
	}

	/**
	 * Sets the end time
	 *
	 * @param string $endTime
	 * @return void
	 */
	public function setEndTime($endTime) {
		$this->endTime = $endTime;
	}

	/**
	 * Returns the visitor
	 *
	 * @return string $visitor
	 */
	public function getVisitor() {
		return $this->visitor;
	}

	/**
	 * Sets the visitor
	 *
	 * @param string $visitor
	 * @return void
	 */
	public function setVisitor($visitor) {
		$this->visitor = $visitor;
	}

	/**
	 * Returns the company
	 *
	 * @return string $company
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Sets the company
	 *
	 * @param string $company
	 * @return void
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

	/**
	 * Returns the contact
	 *
	 * @return string $contact
	 */
	public function getContact() {
		return $this->contact;
	}

	/**
	 * Sets the contact
	 *
	 * @param string $contact
	 * @return void
	 */
	public function setContact($contact) {
		$this->contact = $contact;
	}

	/**
	 * Returns state of public
	 *
	 * @return string $public
	 */
	public function getPublic() {
		return $this->public;
	}

	/**
	 * Sets the state of public
	 *
	 * @param string $public
	 * @return void
	 */
	public function setPublic($public) {
		$this->public = $public;
	}

	/**
	* Returns the file name
	*
	* @return array $image
	*/
	public function getImage() {
	  return $this->image;
	}

	/**
	* Sets the file name
	*
	* @param array $image
	* @return void
	*/
	public function setImage($image) {
	  $this->image = $image;
	}

}
