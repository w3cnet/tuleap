<?php
/**
 * Copyright (c) Enalean, 2014. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

class Search_SearchPeople {
    const NAME = 'people';

    /**
     * @var UserDao
     */
    private $dao;


    public function __construct(UserDao $dao) {
        $this->dao = $dao;
    }

    public function search($words, $exact, $offset) {
        return $this->getSearchPeopleResultPresenter($this->dao->searchGlobal($words, $offset, $exact), $words);
    }

    private function getSearchPeopleResultPresenter(DataAccessResult $results, $words) {
        return new Search_SearchResultsPresenter(
            new Search_SearchResultsIntroPresenter($results, $words),
            $this->getResultsPresenters($results)
        );
    }

    private function getResultsPresenters(DataAccessResult $results) {
        $results_presenters = array();

        foreach ($results as $result) {
            $results_presenters[] = new Search_SearchPeopleResultPresenter($result);
        }

        return $results_presenters;
    }
}
