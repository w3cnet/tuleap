<?php
/**
 * Copyright (c) Enalean, 2012. All Rights Reserved.
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

require_once(dirname(__FILE__).'/../../../include/Tracker/Hierarchy/Presenter.class.php');
require_once(dirname(__FILE__).'/../../../include/Tracker/Hierarchy/Controller.class.php');
require_once(dirname(__FILE__).'/../../Test_Tracker_Builder.php');
Mock::generate('Tracker');
Mock::generate('TrackerFactory');

if (!defined('TRACKER_BASE_URL')) {
    define('TRACKER_BASE_URL', '/plugins/tracker');
}

class Tracker_Hierarchy_ControllerTest extends TuleapTestCase {

    function testObtainsTheChildrenFromTheFactory() {
        $tracker    = aTracker()->withName('Stories')->build();
        $possible_children = array('1' => aTracker()->withId(1)->withName('Bugs')->build(), 
                                   '2' => aTracker()->withId(2)->withName('Tasks')->build());
        $factory = new MockTrackerFactory();
        $factory->setReturnValue('getPossibleChildren', $possible_children, array($tracker));

        ob_start();
        $controller = new Tracker_Hierarchy_Controller($tracker, $factory);
        $controller->edit();
        $content = ob_get_clean();
        
        $this->assertContainsAll(array('value="1".*Bugs', 'value="2".*Tasks'), $content);
    }
    
    private function assertContainsAll($expected_strings, $actual_text) {
        foreach($expected_strings as $string) {
            $this->assertPattern('/'.$string.'/', $actual_text);
        }
    }
}

?>
