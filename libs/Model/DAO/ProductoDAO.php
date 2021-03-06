<?php
/** @package Taller::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/Phreezable.php");
require_once("ProductoMap.php");

/**
 * ProductoDAO provides object-oriented access to the producto table.  This
 * class is automatically generated by ClassBuilder.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * Add any custom business logic to the Model class which is extended from this DAO class.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package Taller::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class ProductoDAO extends Phreezable
{
	/** @var int */
	public $Id;

	/** @var int */
	public $SeccionId;

	/** @var string */
	public $Nombre;

	/** @var string */
	public $Foto;

	/** @var string */
	public $Codigo;

	/** @var float */
	public $PrecioSugerido;

	/** @var int */
	public $Estatus;


	/**
	 * Returns a dataset of Venta objects with matching ProductoId
	 * @param Criteria
	 * @return DataSet
	 */
	public function GetVentas($criteria = null)
	{
		return $this->_phreezer->GetOneToMany($this, "venta_ibfk_1", $criteria);
	}

	/**
	 * Returns the foreign object based on the value of SeccionId
	 * @return Seccion
	 */
	public function GetSeccion()
	{
		return $this->_phreezer->GetManyToOne($this, "producto_ibfk_1");
	}


}
?>