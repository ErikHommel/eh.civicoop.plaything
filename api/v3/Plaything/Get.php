<?php

/**
 * Plaything.Get API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_plaything_Get($params) {
  return civicrm_api3_create_success(CRM_Plaything_BAO_Plaything::getValues($params), $params, 'Plaything', 'Get');
}
