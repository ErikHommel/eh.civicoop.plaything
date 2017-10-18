{*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.7                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2017                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*}
{if $action eq 1 or $action eq 2 or $action eq 4 or $action eq 8}
  {include file="CRM/Plaything/Form/Plaything.tpl"}
{else}
  <div class="help">
    <p>{ts}This page shows all the available playthings.{/ts}</p>
  </div>
  {if $rows}
    {if !($action eq 1 and $action eq 2)}
      <div class="action-link">
        {crmButton q="action=add&reset=1" class="new_play_thing" icon="plus-circle"}{ts}Add Plaything{/ts}{/crmButton}
      </div>
    {/if}

    <div id="eh_plaything">

      {strip}
        {include file="CRM/common/jsortable.tpl"}
        <table id="options" class="display">
          <thead>
          <tr>
            <th>{ts}Title{/ts}</th>
            <th>{ts}Description{/ts}</th>
            <th>{ts}Active?{/ts}</th>
            <th></th>
          </tr>
          </thead>
          {foreach from=$rows item=row}
            <tr id="plaything-{$row.id}" class="crm-entity {cycle values="odd-row,even-row"} {$row.class}">
              <td class="crm-plaything-title" data-field="title">{$row.title}</td>
              <td class="crm-plaything-description" data-field="title">{$row.description}</td>
              {if $row.is_active eq 1}
                <td class="crm-plaything-is_active">{ts}Yes{/ts}</td>
              {else}
                <td class="crm-plaything-is_inactive">{ts}No{/ts}</td>
              {/if}
              <td>{$row.action|replace:'xx':$row.id}</td>
            </tr>
          {/foreach}
        </table>
      {/strip}

    </div>
  {else}
    <div class="messages status no-popup">
      <img src="{$config->resourceBase}i/Inform.gif" alt="{ts}status{/ts}"/>
      {ts}None found.{/ts}
    </div>
  {/if}
  <div class="action-link">
    {crmButton q="action=add&reset=1" class="new_play_thing" icon="plus-circle"}{ts}Add Plaything{/ts}{/crmButton}
    {crmButton p="civicrm/" q="reset=1" class="cancel" icon="times"}{ts}Done{/ts}{/crmButton}
  </div>
{/if}

