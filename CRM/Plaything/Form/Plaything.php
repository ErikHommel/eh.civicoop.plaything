<?php

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Plaything_Form_Plaything extends CRM_Core_Form {

  private $_playthingId = NULL;

  /**
   * Method to build the form
   */
  public function buildQuickForm() {
    // return if disable
    if ($this->_action == CRM_Core_Action::DISABLE) {
      return;
    }
    //readonly elements when view action
    if ($this->_action == CRM_Core_Action::VIEW) {
      $this->addViewElements();
    } else {
      $this->addElements();
    }
    $this->addButtons(array(
      array('type' => 'next', 'name' => ts('Save'), 'isDefault' => true,),
      array('type' => 'cancel', 'name' => ts('Cancel'),),));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * Method to add form elements for view
   */
  private function addViewElements() {
    $this->add('text', 'title', ts('Title'), array('readonly' => 'readonly'), FALSE);
    $this->add('wysiwyg', 'description', ts('Description'), array(
        'readonly' => 'readonly',
        'rows' => 4,
        'cols' => 80,)
      , FALSE);
  }

  /**
   * Method to add form elements (for update and add)
   */
  private function addElements() {
    $this->add('text', 'title', ts('Title'), array(),TRUE);
    $this->add('wysiwyg', 'description', ts('Description'), array('rows' => 4, 'cols' => 80), FALSE);
  }

  /**
   * Method to prepare form
   */
  public function preProcess() {
    // retrieve plaything id from request
    $requestValues = CRM_Utils_Request::exportValues();
    if (isset($requestValues['pid']) && !empty($requestValues['pid'])) {
      $this->_playthingId = $requestValues['pid'];
    }
    if ($this->_action == CRM_Core_Action::DISABLE) {
      $this->assign('action', $this->_action);
      $this->context = CRM_Utils_System::url('civicrm/plaything/page/plaything', "reset=1&action=browse");
      $this->controller->_destination = $this->context;
    }
  }

  /**
   * Method to set the default values in view and update mode
   * @return array
   */
  public function setDefaultValues() {
    if ($this->_action == CRM_Core_Action::DISABLE) {
      return;
    }
    $defaults = array();
    if ($this->_action == CRM_Core_Action::UPDATE || $this->_action == CRM_Core_Action::VIEW) {
      try {
        $plaything = civicrm_api3('Plaything', 'getsingle', array('id' => $this->_playthingId));
        foreach ($plaything as $key => $value) {
          $defaults[$key] = $value;
        }
      } catch (CiviCRM_API3_Exception $ex) {
      }
    }
    return $defaults;
  }

  /**
   * Method to process the form once it is submitted
   */
  public function postProcess() {
    CRM_Core_Error::debug('submitValues', $this->_submitValues);
    CRM_Core_Error::debug('this', $this);
    exit();
    $values = $this->exportValues();
    $ignores = array('entryURL', 'qfKey');
    foreach ($values as $key => $data) {
      if (substr($key, 0, 1) != "_" && !in_array($key, $ignores)) {
        $params[$key] = $data;
      }
    }
    if ($this->_action != CRM_Core_Action::ADD) {
      $params['id'] = $this->_playthingId;
    }
    try {
      civicrm_api3('Plaything', 'create', $params);
      CRM_Core_Session::setStatus(' Plaything in database saved', ' Plaything saved', 'success');
    }
    catch (CiviCRM_API3_Exception $ex) {
      CRM_Core_Session::setStatus('Error saving Plaything in database', 'NOT Saved Plaything', 'error');
    }
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
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
