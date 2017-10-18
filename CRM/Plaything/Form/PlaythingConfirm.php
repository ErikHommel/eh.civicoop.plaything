<?php

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Plaything_Form_PlaythingConfirm extends CRM_Core_Form {
  private $_playthingId = NULL;
  /**
   * Overridden parent method to build the form
   */
  public function buildQuickForm() {
    $this->add('hidden', 'plaything_id');
    $this->add('text', 'plaything_title', 'Plaything Title', array(), false);
    $this->add('text', 'action_label', 'Action Label', array(), false);
    $this->addButtons(array(
      array('type' => 'next', 'name' => ts('Confirm'), 'isDefault' => true,),
      array('type' => 'cancel', 'name' => ts('Cancel'),),));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * Method to set the default values
   * @return array
   */
  public function setDefaultValues() {
    $defaults = array();
    if (isset($this->_playthingId) && !empty($this->_playthingId)) {
      $defaults['plaything_id'] = $this->_playthingId;
      switch ($this->_action) {
        case CRM_Core_Action::DELETE:
          $defaults['action_label'] = 'delete';
          break;
        case CRM_Core_Action::DISABLE:
          $defaults['action_label'] = 'disable';
          break;
        case CRM_Core_Action::ENABLE:
          $defaults['action_label'] = 'enable';
          break;
      }
      try {
        $defaults['plaything_title'] = civicrm_api3('Plaything', 'getvalue', array(
          'id' => $this->_playthingId,
          'return' => 'title',
        ));
      }
      catch (CiviCRM_API3_Exception $ex) {
      }
    }
    return $defaults;
  }

  /**
   * Overridden parent method before form is processed
   */
  public function preProcess() {
    $requestValues = CRM_Utils_Request::exportValues();
    if (isset($requestValues['pid'])) {
      $this->_playthingId = $requestValues['pid'];
    }
    $this->context = CRM_Utils_System::url('civicrm/plaything/page/plaything', "reset=1&action=browse");
    $this->controller->_destination = $this->context;
  }

  /**
   * Overridden method to process the output once the form has been submitted (saved)
   */
  public function postProcess() {
    if (isset($this->_submitValues['plaything_id']) && !empty($this->_submitValues['plaything_id'])) {
      switch ($this->_action) {
        case CRM_Core_Action::DELETE:
          civicrm_api3('Plaything', 'delete', array(
            'id' => $this->_submitValues['plaything_id'],
          ));
          $message = 'delete';
          break;
        case CRM_Core_Action::DISABLE:
          civicrm_api3('Plaything', 'create', array(
            'id' => $this->_submitValues['plaything_id'],
            'is_active' => 0,
          ));
          $message = 'disable';
          break;
        case CRM_Core_Action::ENABLE:
          civicrm_api3('Plaything', 'create', array(
            'id' => $this->_submitValues['plaything_id'],
            'is_active' => 1,
          ));
          $message = 'enable';
          break;
      }
      CRM_Core_Session::setStatus('Plaything '.$message.'d from the database', 'Succesfully '.$message.'d', 'success');
    } else {
      CRM_Core_Session::setStatus('Nothing to delete, enable or disable', 'Nothing done', 'info');
    }
    parent::postProcess();
  }


  /**
   * Method to get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
