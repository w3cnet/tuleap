<?php
/**
 * Copyright (c) Enalean, 2014 - 2017. All rights reserved
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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/
 */

use Tuleap\User\ForgeUserGroupPermission\RetrieveSystemEventsInformationApi;

class User_ForgeUserGroupPermissionsFactory {

    const GET_PERMISSION_DELEGATION = 'get_permission_delegation';

    /**
     * @var User_ForgeUserGroupPermissionsDao
     */
    private $permissions_dao;

    /**
     * @var EventManager
     */
    private $event_manager;

    public function __construct(
        User_ForgeUserGroupPermissionsDao $dao,
        EventManager $event_manager
    ) {
        $this->permissions_dao = $dao;
        $this->event_manager   = $event_manager;
    }

    /**
     * @return User_ForgeUserGroupPermission
     * @throws User_ForgeUserGroupPermission_NotFoundException
     */
    public function getForgePermissionById($permission_id) {
        $all_permissions = $this->getAllAvailableForgePermissions();

        if (array_key_exists($permission_id, $all_permissions)) {
            return $all_permissions[$permission_id];
        }

        throw new User_ForgeUserGroupPermission_NotFoundException();
    }

    /**
     * @return User_ForgeUserGroupPermission[]
     */
    public function getAllUnusedForgePermissionsForForgeUserGroup(User_ForgeUGroup $user_group) {
        $unused_permissions    = array();
        $group_permissions_ids = $this->extractPermissionIds($this->permissions_dao->getPermissionsForForgeUGroup($user_group->getId()));
        $all_permissions_ids   = $this->getAllAvailableForgePermissionIds();

        $remaining_permission_ids = array_diff($all_permissions_ids, $group_permissions_ids);

        foreach ($remaining_permission_ids as $remaining_permission_id) {
            $unused_permissions[] = $this->getForgePermissionById($remaining_permission_id);
        }

        return $unused_permissions;
    }

    private function extractPermissionIds($permissions) {
        $permission_ids = array();

        if ($permissions) {
            foreach ($permissions as $permission) {
                $permission_ids[] = $permission['permission_id'];
            }
        }

        return $permission_ids;
    }

    private function getAllAvailableForgePermissionIds() {
        return array_keys($this->getAllAvailableForgePermissions());
    }

    public function getAllAvailableForgePermissions() {
        $plugins_permission = array();

        $params = array(
            'plugins_permission' => &$plugins_permission
        );

        $this->event_manager->processEvent(
            self::GET_PERMISSION_DELEGATION,
            $params
        );

        $all_permissions = $plugins_permission + array(
            User_ForgeUserGroupPermission_ProjectApproval::ID
                => new User_ForgeUserGroupPermission_ProjectApproval(),
            User_ForgeUserGroupPermission_RetrieveUserMembershipInformation::ID
                => new User_ForgeUserGroupPermission_RetrieveUserMembershipInformation(),
            User_ForgeUserGroupPermission_UserManagement::ID
                => new User_ForgeUserGroupPermission_UserManagement(),
            RetrieveSystemEventsInformationApi::ID
                => new RetrieveSystemEventsInformationApi()
        );

        return $all_permissions;
    }

    /**
     * @return User_ForgeUserGroupPermission[]
     */
    public function getPermissionsForForgeUserGroup(User_ForgeUGroup $user_group) {
        $permissions   = array();
        $user_group_id = $user_group->getId();

        $rows = $this->permissions_dao->getPermissionsForForgeUGroup($user_group_id);

        if (! $rows) {
            return $permissions;
        }

        foreach ($rows as $row) {
            $permissions[$row['permission_id']] = $this->instantiateFromRow($row);
        }

        return array_values($permissions);
    }

    private function instantiateFromRow($row) {
        return $this->getForgePermissionById($row['permission_id']);
    }

}
