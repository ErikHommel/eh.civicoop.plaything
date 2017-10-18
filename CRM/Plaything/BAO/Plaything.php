<?php
/**
 * Class BAO Plaything
 *
 * @author Erik Hommel <hommel@ee-atwork.nl>
 * @date 25 July 2017
 * @license AGPL-3.0
 */

class CRM_Plaything_BAO_Plaything extends CRM_Plaything_DAO_Plaything {

  /**
   * Method to get values
   *
   * @return array $result found rows with data
   * @access public
   * @static
   */
  public static function getValues($params) {
    $result = array();
    $plaything = new CRM_Plaything_BAO_Plaything();
    if (!empty($params)) {
      $fields = self::fields();
      foreach ($params as $key => $value) {
        if (isset($fields[$key])) {
          $plaything->$key = $value;
        }
      }
    }
    $plaything->find();
    while ($plaything->fetch()) {
      $row = array();
      self::storeValues($plaything, $row);
      $result[$row['id']] = $row;
    }
    return $result;
  }

  /**
   * Method to add or update material
   *
   * @param array $params
   * @return array $result
   * @access public
   * @throws Exception when params is empty
   * @static
   */
  public static function add($params) {
    $result = array();
    if (empty($params)) {
      throw new Exception('Params can not be empty when adding or updating a plaything in '.__METHOD__);
    }
    $plaything = new CRM_Plaything_BAO_Plaything();
    $fields = self::fields();
    foreach ($params as $key => $value) {
      if (isset($fields[$key])) {
        $plaything->$key = $value;
      }
    }
    // always is_active to 1 if add mode (no id)
    if (!isset($params['id'])) {
      $plaything->is_active = 1;
    }
    $plaything->save();
    self::storeValues($plaything, $row);
    $result[$row['id']] = $row;
    return $result;
  }

  /**
   * Method to delete a material by id
   *
   * @param int $playthingId
   * @return array $result
   * @throws Exception when playthingId is empty
   */
  public static function deleteWithId($playthingId) {
    if (empty($playthingId)) {
      throw new Exception('plaything id can not be empty when attempting to delete a plaything in '.__METHOD__);
    }
    $plaything = new CRM_Plaything_BAO_Plaything();
    $plaything->id = $playthingId;
    $plaything->delete();
    $result[$playthingId] = array('id' => $playthingId);
    return $result;
  }
}