 <?php
 header('Content-type: application/json');
// echo "<pre>";
 // var_dump($_POST);
 require_once("clases.php");
 require_once("conectar.php");


if(!isset($_POST["venta"]))
{
	echo '{"data": { "error":{"ID":1,"message":"no hay venta"}}}';
}


@$comentario=mysql_escape_string($_POST["comentario"]);
$ventas=$_POST["venta"];


$total=0;
foreach($ventas as $venta)
{
	$total+=$venta["total"];
}
$q_venta="insert into venta(total,caja_id,fecha,comentarios,estatus)values(".$total.",1,NOW(),'".$comentario."',1)";
$c_venta=new Consulta($q_venta);
$id_venta=$c_venta->lastInsertId();


foreach($ventas as $venta)
{
	$q_producto ="insert into venta_producto(venta_id,producto_id,precio,cantidad,total)";
	$q_producto.="values(".$id_venta.",".$venta["id"].",".$venta["precio"].",".$venta["cantidad"].",".$venta["total"].")";
	$c_producto=new Consulta($q_producto);
}
echo '{"data": { "error":{"ID":0,"message":"no error"}}}';


// $q_productos="select p.id,p.nombre,p.foto,p.codigo,p.seccion_id,p.precio_sugerido,s.nombre as seccion from producto p join seccion s on s.id = p.seccion_id where p.nombre like('%".$item."%') or p.codigo like('%".$item."%') or s.nombre like('%".$item."%')";
// $c_productos= new Consulta($q_productos);



// $cadena ='{
//             "data": {
//                 "error": {
//                     "ID": 0,
//                     "message": "No hubo error"
//                 },
//                 "list": [';
// $items="";
// $cont=0;


// if($c_productos->cuantos_S()>0)
// {  
//   while($c_productos->sacar_V())
//   {
//     $items.='{
//                 "id": '.$c_productos->m["id"].',
//                 "nombre": "'.$c_productos->m["nombre"].'",
//                 "foto": "'.$c_productos->m["foto"].'",
//                 "codigo": "'.$c_productos->m["codigo"].'",
//                 "seccion_id": "'.$c_productos->m["seccion_id"].'",
//                 "seccion": "'.$c_productos->m["seccion"].'",
//                 "precio_sugerido": "'.$c_productos->m["precio_sugerido"].'"
//             },';
//     $cont++;
//   }  
// }


//  if($cont>0)
//  {
//      $items=substr($items, 0,strlen($items)-1);
//  }
//  $cadena=$cadena.$items.']}}';
//  echo $cadena;
?>