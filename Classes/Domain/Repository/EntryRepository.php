<?php
namespace Ki\KiCal\Domain\Repository;

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
 * The repository for Entries
 */
class EntryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

  /**
   * action search
   *
   * @param \Ki\KiCal\Domain\Model\Entry $searchData
   * @return void
   */
  public function getEntry(\Ki\KiCal\Domain\Model\Entry $searchData) {

    $query = $this->createQuery();

    // Check if user has entered an entry title
    if($searchData->getEntryTitle() !== "") {
      $query->matching($query->like('entry_title', '%' . $searchData->getEntryTitle() . '%'));
    }

    // Check if user has entered a description
    if($searchData->getDescription() !== "") {
      $query->matching($query->like('description', '%' . $searchData->getDescription() . '%'));
    }

    // Check if user has entered a date
    if($searchData->getEntryDate() !== "") {
      $searchData->setEntryDate(date("Y-m-d", strtotime($searchData->getEntryDate())));
      $query->matching($query->equals('entry_date', $searchData->getEntryDate()));
    }

    // Check if user has entered a start time
    if($searchData->getStartTime() !== "") {
      $query->matching($query->like('start_time', $searchData->getStartTime() . '%'));
    }

    // Check if user has entered an end time
    if($searchData->getEndTime() !== "") {
      $query->matching($query->like('end_time', $searchData->getEndTime() . '%'));
    }

    // Check if user has entered a visitor
    if($searchData->getVisitor() !== "") {
      $query->matching($query->like('visitor', $searchData->getVisitor() . '%'));
    }

    // Check if user has entered a company
    if($searchData->getCompany() !== "") {
      $query->matching($query->like('company', $searchData->getCompany() . '%'));
    }

    // Check if user has entered a contact
    if($searchData->getContact() !== "") {
      $query->matching($query->like('contact', $searchData->getContact() . '%'));
    }

    // Check if user looks for public entries
    if($searchData->getPublic() !== "") {
      $query->matching($query->equals('public', $searchData->getPublic() . '%'));
    }

    return $query->execute();
  }

  public function getAllPublicEntries() {

    $query = $this->createQuery();
    $query->matching($query->equals('public', '1'));
    return $query->execute();
  }
}
