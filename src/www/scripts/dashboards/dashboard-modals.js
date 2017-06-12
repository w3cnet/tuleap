/**
 * Copyright (c) Enalean, 2017. All Rights Reserved.
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

import { find, flatMapDeep, map } from 'lodash';
import { render } from 'mustache';
import { sanitize } from 'dompurify';
import { get } from 'jquery';
import { modal as createModal, filterInlineTable } from 'tlp';

export default init;

function init() {
    var buttons = document.querySelectorAll(
        [
            '#add-dashboard-button',
            '#delete-dashboard-button',
            '#edit-dashboard-button',
            '#no-widgets-edit-dashboard-button',
            '.delete-widget-button',
            '#add-widget-button',
            '.edit-widget-button'
        ].join(', ')
    );

    [].forEach.call(buttons, function (button) {
        if (! button) {
            return;
        }

        var modal_id = button.dataset.targetModalId;
        if (! modal_id) {
            throw "Missing data-target-modal-id attribute for button " + button.id;
        }

        var modal_content = document.getElementById(modal_id);
        if (! modal_content) {
            throw "Cannot find the modal " + modal_id;
        }

        var modal = createModal(modal_content);
        button.addEventListener('click', function (event) {
            event.preventDefault();
            modal.toggle();
        });

        if (button.classList.contains('edit-widget-button')) {
            modal.addEventListener('tlp-modal-shown', loadDynamicallyEditModalContent);
        } else if (button.id === 'add-widget-button') {
            modal.addEventListener('tlp-modal-shown', loadDynamicallyWidgetsContent);
        }

        function loadDynamicallyEditModalContent() {
            var widget_id = modal_content.dataset.widgetId,
                container = modal_content.querySelector('.edit-widget-modal-content'),
                button    = modal_content.querySelector('button[type=submit]');

            get('/widgets/?widget-id=' + encodeURIComponent(widget_id) +'&action=get-edit-modal-content')
                .done(function (html) {
                    button.disabled     = false;
                    container.innerHTML = sanitize(html);
                })
                .fail(function (data) {
                    container.innerHTML = sanitize('<div class="tlp-alert-danger">' + data.responseJSON + '</div>');
                })
                .always(function () {
                    container.classList.remove('edit-widget-modal-content-loading');
                    modal.removeEventListener('tlp-modal-shown', loadDynamicallyEditModalContent);
                });
        }

        function loadDynamicallyWidgetsContent() {
            var widgets_categories_template = document.getElementById('dashboard-add-widget-list-table-placeholder').textContent;

            var table     = modal_content.querySelector('#dashboard-add-widget-list-table');
            var container = modal_content.querySelector('.dashboard-add-widget-content-container');

            get(button.dataset.href)
                .done(function (data) {
                    const filter = filterInlineTable(document.getElementById('dashboard-add-widget-list-header-filter-table'));
                    modal.addEventListener('tlp-modal-hidden', function () {
                        filter.filterTable()
                    });

                    container.outerHTML = sanitize(render(widgets_categories_template, data));
                    initializeWidgets(table, data);
                })
                .fail(function (data) {
                    var alert = document.getElementById('dashboard-add-widget-error-message');

                    alert.classList.add('tlp-alert-danger');
                    alert.innerHTML = sanitize(data.responseJSON);

                    document.getElementById('dashboard-add-widget-list-header-filter').remove();
                    document.getElementById('dashboard-add-widget-list-table').remove();
                })
                .always(function () {
                    modal.removeEventListener('tlp-modal-shown', loadDynamicallyWidgetsContent);
                });
        }
    });
}

function initializeWidgets(table, data) {
    const data_widgets = flatMapDeep(data, function (category) {
        return map(category, 'widgets');
    });
    const widgets_element = table.querySelectorAll('.dashboard-add-widget-list-table-widget');
    [].forEach.call(widgets_element, function (widget_element) {
        widget_element.addEventListener('click', function (event) {
            displayWidgetSettings(table, widget_element, data_widgets, event);
        });
    });
}

function displayWidgetSettings(table, widget_element, data_widgets, event) {
    var widget_settings_template = document.getElementById('dashboard-add-widget-settings-placeholder').textContent;

    var widget_data = find(data_widgets, function (widget) {
        return widget.id === event.target.dataset.widgetId;
    });
    if (widget_data) {
        document.getElementById('dashboard-add-widget-settings').innerHTML = sanitize(render(widget_settings_template, widget_data));

        var already_selected_widget = table.querySelector('.dashboard-add-widget-list-table-widget-selected');
        if (already_selected_widget) {
            already_selected_widget.classList.remove('dashboard-add-widget-list-table-widget-selected');
        }
        widget_element.classList.add('dashboard-add-widget-list-table-widget-selected');

        var add_widget_button = document.getElementById('dashboard-add-widget-button');
        if (! widget_data.is_used && widget_data.configurations === '') {
            add_widget_button.disabled = false;
        } else {
            add_widget_button.disabled = true;
        }
    }
}
