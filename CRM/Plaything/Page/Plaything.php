<?php
/**
 * Basic Page Plaything
 *
 * @author Erik Hommel <hommel@ee-atwork.nl>
 * @date 16 Oct 2017
 * @license AGPL-3.0
 */

class CRM_Plaything_Page_Plaything extends CRM_Core_Page_Basic {

  public $useLivePageJS = TRUE;

  /**
   * The action links that we need to display for the browse screen.
   *
   * @var array
   */
  static $_links = NULL;

  /**
   * Get BAO Name.
   *
   * @return string
   *   Classname of BAO.
   */
  public function getBAOName() {
    return 'CRM_Plaything_BAO_Plaything';
  }

  /**
   * Get action Links.
   *
   * @return array
   *   (reference) of action links
   */
  public function &links() {
    if (!(self::$_links)) {
      self::$_links = array(
        CRM_Core_Action::VIEW => array(
          'name' => ts('View'),
          'url' => 'civicrm/plaything/form/plaything',
          'qs' => 'action=view&pid=%%id%%&reset=1',
          'title' => 'View Plaything',
        ),
        CRM_Core_Action::UPDATE => array(
          'name' => ts('Edit'),
          'url' => 'civicrm/plaything/form/plaything',
          'qs' => 'action=update&pid=%%id%%&reset=1',
          'title' => 'Edit Plaything',
        ),
        CRM_Core_Action::ENABLE => array(
          'name' => ts('Enable'),
          'url' => 'civicrm/plaything/form/playthingconfirm',
          'qs' => 'action=enable&pid=%%id%%&reset=1',
          'title' => 'Enable Plaything',
        ),
        CRM_Core_Action::DISABLE => array(
          'name' => ts('Disable'),
          'url' => 'civicrm/plaything/form/playthingconfirm',
          'qs' => 'action=disable&pid=%%id%%&reset=1',
          'title' => 'Disable Plaything',
        ),
        CRM_Core_Action::DELETE => array(
          'name' => ts('Delete'),
          'url' => 'civicrm/plaything/form/playthingconfirm',
          'qs' => 'pid=%%id%%&reset=1&action=delete',
          'title' => 'Delete Plaything',
        ),
      );
    }
    return self::$_links;
  }

  /**
   * Get name of edit form.
   *
   * @return string
   *   Classname of edit form.
   */
  public function editForm() {
    return 'CRM_Plaything_Form_Plaything';
  }

  /**
   * Get edit form name.
   *
   * @return string
   *   name of this page.
   */
  public function editName() {
    return 'Play with Plaything';
  }

  /**
   * Get user context.
   *
   * @param null $mode
   *
   * @return string
   *   user context.
   */
  public function userContext($mode = NULL) {
    return CRM_Utils_System::url('civicrm/plaything/page/plaything', 'reset=1&action=browse', true);
  }

}
