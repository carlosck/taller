<?php
/** @package    Taller::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * ProductoMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the ProductoDAO to the producto datastore.
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
class ProductoMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","producto","id",true,FM_TYPE_INT,11,null,true);
			self::$FM["SeccionId"] = new FieldMap("SeccionId","producto","seccion_id",false,FM_TYPE_INT,11,null,false);
			self::$FM["Nombre"] = new FieldMap("Nombre","producto","nombre",false,FM_TYPE_VARCHAR,250,null,false);
			self::$FM["Foto"] = new FieldMap("Foto","producto","foto",false,FM_TYPE_VARCHAR,250,null,false);
			self::$FM["Codigo"] = new FieldMap("Codigo","producto","codigo",false,FM_TYPE_VARCHAR,250,null,false);
			self::$FM["PrecioSugerido"] = new FieldMap("PrecioSugerido","producto","precio_sugerido",false,FM_TYPE_FLOAT,null,null,false);
			self::$FM["Estatus"] = new FieldMap("Estatus","producto","estatus",false,FM_TYPE_TINYINT,1,null,false);
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
			self::$KM["venta_ibfk_1"] = new KeyMap("venta_ibfk_1", "Id", "Venta", "ProductoId", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			self::$KM["producto_ibfk_1"] = new KeyMap("producto_ibfk_1", "SeccionId", "Seccion", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
		}
		return self::$KM;
	}

}

?>