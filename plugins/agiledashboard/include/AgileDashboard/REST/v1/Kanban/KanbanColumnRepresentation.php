<?php
/**
 * Copyright (c) Enalean, 2014-2015. All Rights Reserved.
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
 * along with Tuleap; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

namespace Tuleap\AgileDashboard\REST\v1\Kanban;

use AgileDashboard_KanbanColumn;
use Tuleap\REST\JsonCast;

class KanbanColumnRepresentation {

    const ROUTE = "kanban_columns";

    /**
     * @var int {@type int}
     */
    public $id;

    /**
     * @var string {@type string}
     */
    public $label;

    /**
     * @var bool {@type bool}
     */
    public $is_open;

    /**
     * @var int {@type int}
     */
    public $limit;

    /**
     * @var string {@type string}
     */
    public $color;

    /**
     * @var bool {@type bool}
     */
    public $user_can_add_in_place;

    /**
     * @var bool {@type bool}
     */
    public $user_can_remove_column;

    const ARCHIVE_COLUMN = 'archive';

    const BACKLOG_COLUMN = 'backlog';

    public function build(AgileDashboard_KanbanColumn $column, $user_can_add_in_place, $user_can_remove_column) {
        $this->id                     = JsonCast::toInt($column->getId());
        $this->label                  = $column->getLabel();
        $this->is_open                = $column->isOpen();
        $this->color                  = $column->getColor();
        $this->limit                  = JsonCast::toInt($column->getLimit());
        $this->user_can_add_in_place  = $user_can_add_in_place;
        $this->user_can_remove_column = $user_can_remove_column;
    }
}
