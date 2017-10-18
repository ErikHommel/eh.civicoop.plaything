<?php


/**
 * Plaything.Delete API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_plaything_Delete($params) {
  return civicrm_api3_create_success(CRM_Plaything_BAO_Plaything::deleteWithId($params['id']), $params, 'Plaything', 'Delete');
}
