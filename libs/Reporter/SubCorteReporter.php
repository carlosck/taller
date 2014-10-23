<?php
/** @package    Taller::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Venta object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Taller::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class SubCorteReporter extends Reporter
{

  // the properties in this class must match the columns returned by GetCustomQuery().
  // 'CustomFieldExample' is an example that is not part of the `venta` table
  public $CustomFieldExample;

  public $Id;
  public $CajaId;
  public $ProductoId;
  public $Producto;
  public $Sugerido;
  public $Precio;
  public $Cantidad;
  public $Caja;
  public $Total;

  /*
  * GetCustomQuery returns a fully formed SQL statement.  The result columns
  * must match with the properties of this reporter object.
  *
  * @see Reporter::GetCustomQuery
  * @param Criteria $criteria
  * @return string SQL statement
  */
  static function GetCustomQuery($criteria)
  {
    $sql = "select
      
      `venta_producto`.`id` as Id           
      ,`venta_producto`.`producto_id` as ProductoId
      ,`producto`.`nombre` as Producto
      ,`producto`.`precio_sugerido` as Sugerido
      ,`venta_producto`.`precio` as Precio
      ,`venta_producto`.`cantidad` as Cantidad
      ,`venta_producto`.`total` as Total       
    from `venta_producto`
    join producto on producto.id = venta_producto.producto_id
    where venta_producto.venta_id=".$criteria->id." 
    ";

    // the criteria can be used or you can write your own custom logic.
    // be sure to escape any user input with $criteria->Escape()
    // $sql .= $criteria->GetWhere();
    // $sql .= $criteria->GetOrder();

    return $sql;
  }
  
  /*
  * GetCustomCountQuery returns a fully formed SQL statement that will count
  * the results.  This query must return the correct number of results that
  * GetCustomQuery would, given the same criteria
  *
  * @see Reporter::GetCustomCountQuery
  * @param Criteria $criteria
  * @return string SQL statement
  */
  static function GetCustomCountQuery($criteria)
  {
    $sql = "select count(1) as counter from `venta`";

    // the criteria can be used or you can write your own custom logic.
    // be sure to escape any user input with $criteria->Escape()
    // $sql .= $criteria->GetWhere();

    return $sql;
  }
}

?>