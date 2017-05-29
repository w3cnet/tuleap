<?php
/**
 * Copyright (c) Enalean, 2017. All rights reserved
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

namespace Tuleap\Dashboard\Widget;

class DashboardWidgetReorder
{
    /**
     * @var DashboardWidgetDao
     */
    private $dao;
    /**
     * @var DashboardWidgetRetriever
     */
    private $retriever;
    /**
     * @var DashboardWidgetDeletor
     */
    private $deletor;

    public function __construct(
        DashboardWidgetDao $dao,
        DashboardWidgetRetriever $retriever,
        DashboardWidgetDeletor $deletor
    ) {
        $this->dao       = $dao;
        $this->retriever = $retriever;
        $this->deletor   = $deletor;
    }

    /**
     * @param DashboardWidgetLine[] $widgets_lines
     * @param DashboardWidget $widget_to_update
     * @param $new_column_id
     * @param $new_widget_rank
     */
    public function reorderWidgets(
        array $widgets_lines,
        DashboardWidget $widget_to_update,
        $new_column_id,
        $new_widget_rank
    ) {
        $new_column = $this->retriever->getColumnByIdInWidgetsList($new_column_id, $widgets_lines);
        $old_column = $this->retriever->getColumnByIdInWidgetsList($widget_to_update->getColumnId(), $widgets_lines);

        if ($new_column === null || $old_column === null) {
            return;
        }

        if ($old_column->getId() !== $new_column_id) {
            $this->dao->updateColumnIdByWidgetId($widget_to_update->getId(), $new_column_id);
            $this->updateWidgetRankToLeaveColumn($widget_to_update, $old_column);
            $this->deletor->deleteEmptyColumn($old_column);
        }

        $this->updateRankToEnterInColumn($widget_to_update, $new_widget_rank, $new_column);
    }

    /**
     * @param DashboardWidget $widget_to_update
     * @param DashboardWidgetColumn $column
     */
    private function updateWidgetRankToLeaveColumn(
        DashboardWidget $widget_to_update,
        DashboardWidgetColumn $column
    ) {
        $widgets = $this->deletor->removeWidgetInWidgetsListColumn($widget_to_update, $column);
        $this->updateWidgetsRank($widgets);
    }

    /**
     * @param DashboardWidget $widget_to_update
     * @param $new_widget_rank
     * @param DashboardWidgetColumn $column
     */
    private function updateRankToEnterInColumn(
        DashboardWidget $widget_to_update,
        $new_widget_rank,
        DashboardWidgetColumn $column
    ) {
        $widgets = $this->deletor->removeWidgetInWidgetsListColumn($widget_to_update, $column);
        array_splice($widgets, $new_widget_rank, 0, array($widget_to_update));
        $this->updateWidgetsRank($widgets);
    }

    /**
     * @param DashboardWidget[] $widgets
     */
    private function updateWidgetsRank(array $widgets)
    {
        foreach ($widgets as $index => $widget) {
            $this->dao->updateWidgetRankByWidgetId($widget->getId(), $index);
        }
    }
}
