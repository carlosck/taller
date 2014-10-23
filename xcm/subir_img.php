 <?php
 
 $item=mysql_escape_string($_GET["item"]);
 $folder="";
 switch($item)
 {
	case "seccion":
		$folder="../img/secciones";
		break;
	case "producto":
		$folder="../img/productos";
		break;
 }

$file = $_FILES["archivo_upload"];
if(isset($file['name']))
{
	$n = $file['name'];             
	$s = $file['size']; 
	$t = $file["tmp_name"];	
}
else
{
	echo "no file";
	die();
}


if(!move_uploaded_file($t, $folder.'/'.$n))
{
	echo "error:: intenta otra vez :O";
}
else
{
	echo trim($n);
}

?>