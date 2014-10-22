 <?php
 require_once("clases.php");
 require_once("conectar.php");
$item=mysql_escape_string($_GET["to_find"]);


$q_productos="select p.id,p.nombre,p.foto,p.codigo,p.seccion_id,p.precio_sugerido,s.nombre as seccion from producto p join seccion s on s.id = p.seccion_id where p.nombre like('%".$item."%') or p.codigo like('%".$item."%') or s.nombre like('%".$item."%')";
$c_productos= new Consulta($q_productos);



$cadena ='{
            "data": {
                "error": {
                    "ID": 0,
                    "message": "No hubo error"
                },
                "list": [';
$items="";
$cont=0;


if($c_productos->cuantos_S()>0)
{  
  while($c_productos->sacar_V())
  {
    $items.='{
                "id": '.$c_productos->m["id"].',
                "nombre": "'.$c_productos->m["nombre"].'",
                "foto": "'.$c_productos->m["foto"].'",
                "codigo": "'.$c_productos->m["codigo"].'",
                "seccion_id": "'.$c_productos->m["seccion_id"].'",
                "seccion": "'.$c_productos->m["seccion"].'",
                "precio_sugerido": "'.$c_productos->m["precio_sugerido"].'"
            },';
    $cont++;
  }  
}


 if($cont>0)
 {
     $items=substr($items, 0,strlen($items)-1);
 }
 $cadena=$cadena.$items.']}}';
 echo $cadena;
?>