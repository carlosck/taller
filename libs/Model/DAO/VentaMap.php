<?php
/** @package    Taller::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * VentaMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the VentaDAO to the venta datastore.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * You can override the default fetching strategies for KeyMaps in _config.php.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package Taller::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class VentaMap implements IDaoMap, IDaoMap2
{

	private static $KM;
	private static $FM;
	
	/**
	 * {@inheritdoc}
	 */
	public static function AddMap($property,FieldMap $map)
	{
		self::GetFieldMaps();
		self::$FM[$property] = $map;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function SetFetchingStrategy($property,$loadType)
	{
		self::GetKeyMaps();
		self::$KM[$property]->LoadType = $loadType;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetFieldMaps()
	{
		if (self::$FM == null)
		{
			self::$FM = Array();
			self::$FM["Id"] = new FieldMap("Id","venta","id",true,FM_TYPE_BIGINT,20,null,true);
			
			self::$FM["Total"] = new FieldMap("Total","venta","total",false,FM_TYPE_UNKNOWN,null,null,false);			
			self::$FM["CajaId"] = new FieldMap("CajaId","venta","caja_id",false,FM_TYPE_INT,11,null,false);
			self::$FM["Fecha"] = new FieldMap("Fecha","venta","fecha",false,FM_TYPE_DATETIME,null,null,false);
			self::$FM["Comentarios"] = new FieldMap("Comentarios","venta","comentarios",false,FM_TYPE_VARCHAR,250,null,false);
			self::$FM["Estatus"] = new FieldMap("Estatus","venta","estatus",false,FM_TYPE_INT,2,null,false);
		}
		return self::$FM;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
			self::$KM["venta_ibfk_2"] = new KeyMap("venta_ibfk_2", "CajaId", "Caja", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			
		}
		return self::$KM;
	}

}

?>