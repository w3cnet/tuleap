<?php
/**
 * Copyright Enalean (c) 2011 - 2017. All rights reserved.
 *
 * Tuleap and Enalean names and logos are registrated trademarks owned by
 * Enalean SAS. All other trademarks or names are properties of their respective
 * owners.
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

namespace Tuleap\Project\Admin\ProjectUGroup;

use Codendi_Request;
use CSRFSynchronizerToken;
use EventManager;
use Project_Admin_UGroup_UGroupController;
use Project_Admin_UGroup_View_Settings;
use ProjectUGroup;
use UGroupManager;
use Valid_WhiteList;

class UGroupRouter
{
    /**
     * @var UGroupManager
     */
    private $ugroup_manager;
    /**
     * @var Codendi_Request
     */
    private $request;
    /**
     * @var BindingController
     */
    private $binding_controller;
    /**
     * @var MembersController
     */
    private $members_controller;
    /**
     * @var IndexController
     */
    private $index_controller;
    /**
     * @var DetailsController
     */
    private $details_controller;

    public function __construct(
        UGroupManager $ugroup_manager,
        Codendi_Request $request,
        BindingController $binding_controller,
        MembersController $members_controller,
        IndexController $index_controller,
        DetailsController $details_controller
    ) {
        $this->ugroup_manager     = $ugroup_manager;
        $this->request            = $request;
        $this->binding_controller = $binding_controller;
        $this->members_controller = $members_controller;
        $this->index_controller   = $index_controller;
        $this->details_controller = $details_controller;
    }

    public function process()
    {
        $ugroup = $this->getUGroup();
        $csrf   = new CSRFSynchronizerToken($this->getUGroupUrl($ugroup));
        switch ($this->request->get('action')) {
            case 'remove_binding':
                $csrf->check();
                $this->binding_controller->removeBinding($ugroup);
                $this->redirect($ugroup);
                break;
            case 'add_binding':
                $csrf->check();
                $this->binding_controller->addBinding($ugroup);
                $this->redirect($ugroup);
                break;
            case 'edit_ugroup_members':
                $csrf->check();
                $this->members_controller->editMembers($ugroup);
                $this->redirect($ugroup);
                break;
            case 'update_details':
                $csrf->check();
                $this->details_controller->updateDetails($ugroup);
                $this->redirect($ugroup);
            default:
                $event = new UGroupEditProcessAction($this->request, $ugroup, $csrf);
                EventManager::instance()->processEvent($event);
                if ($event->hasBeenHandled()) {
                    $this->redirect($ugroup);
                } else {
                    $this->index_controller->display($ugroup, $csrf);
                }
        }
    }

    private function getUGroup()
    {
        $ugroup_id = $this->request->getValidated('ugroup_id', 'uint', 0);
        if (! $ugroup_id) {
            exit_error($GLOBALS['Language']->getText('global', 'error'), 'The ugroup ID is missing');
        }

        return $this->ugroup_manager->getById($ugroup_id);
    }

    protected function redirect(ProjectUGroup $ugroup)
    {
        $GLOBALS['Response']->redirect($this->getUGroupUrl($ugroup));
    }

    protected function getUGroupUrl(ProjectUGroup $ugroup)
    {
        return '/project/admin/editugroup.php?' . http_build_query(
                array(
                    'group_id'  => $ugroup->getProjectId(),
                    'ugroup_id' => $ugroup->getId()
                )
            );
    }
}
