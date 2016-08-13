<?php
session_name('nombre_persona');
session_start('nombre_persona');

if (!isset($PHP_SELF)) { $PHP_SELF = "edit.php"; }

if (isset($_GET['agregar_fotos'])) { $agregar_fotos = $_GET['agregar_fotos']; }
if (isset($_GET['paso_dos'])) { $paso_dos = $_GET['paso_dos']; }
if (isset($_GET['paso_1'])) { $paso_1 = $_GET['paso_1']; }
if (isset($_GET['borrar_foto'])) { $borrar_foto = $_GET['borrar_foto']; }
if (isset($_GET['primer_paso'])) { $primer_paso = $_GET['primer_paso']; }
if (isset($_GET['finalizar'])) { $finalizar = $_GET['finalizar']; }


$_SESSION['yas_pass'] = "password_a_usar";

$nombre_propietario = "nombre_persona";


if (file_exists("webconf.php")) { include "webconf.php"; }


echo "<html>";
echo "<head><title>Panel de control para la web de ".$nombre_propietario."</title></head>";

echo "<body>";
echo "<h1>Panel de control para la web de ".$nombre_propietario."</h1>";

$fotolog_file = "fotolog.txt";
if (file_exists($fotolog_file)) {
include $fotolog_file;
}

if (!$_GET && !isset($_SESSION['correct_password'])) {
?>

<form action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data" name="form1"> 

  <h1>Password:</h1>
  <p align="center">Pass: 
   <input name="password" type="text" id="password"> 
  </p> 
  <p align="center"><input name="boton4" type="submit" id="boton" value="Enviar"></p> 
</form> 

<?php
}


if (isset($_POST['password']) && $_POST['password'] == $_SESSION['yas_pass'] || isset($_SESSION['correct_password'])) {
$_SESSION['correct_password'] = "ok";
echo "Passwords correcto<br><br>";
echo "<a href=\"index.php\">Ver web</a><br><br>";
echo "<a href=\"edit.php?agregar_fotos=ok\">Agregar fotos</a><br>";
echo "<a href=\"edit.php?borrar_foto=ok\">Borrar foto</a><br>";
echo "<a href=\"edit.php?modificar_web=ok\">Modificar parametros de la web</a><br><br>";
} elseif (isset($_POST['password']) && $_POST['password'] != $_SESSION['yas_pass']) {
echo "Passwords incorrecto<br><br>";
}


if (isset($_GET['borrar_foto']) && $_GET['borrar_foto'] == "ok" && isset($_SESSION['correct_password']) && $_SESSION['correct_password'] == "ok" && !isset($_GET['paso_1'])) {
?>

<form action="<?=$PHP_SELF?>?paso_1=ok" method="post" enctype="multipart/form-data" name="form1"> 

  <h1>Primer paso:</h1>
  <p align="center">Nombre unico de la imagen a borrar: 
   <input name="img_name_del" type="text" id="img_name_del">
  </p>
  <p align="center"><input name="boton69" type="submit" id="boton" value="Enviar"></p> 
</form> 

<?php
} elseif (isset($_GET['paso_1']) && $_GET['paso_1'] == "ok") {

if (isset($nombre[$_POST['img_name_del']])) {

                 $archivo = fopen($fotolog_file, "a+");
                 fwrite($archivo,"<?php\nunset(\$nombre[\"".$_POST['img_name_del']."\"]);\n?>\n");
                 
                 echo "Imagen borrada con exito";


} else {
echo "Imagen inexistente";
}

}


if (isset($_GET['modificar_web']) && $_GET['modificar_web'] == "ok" && isset($_SESSION['correct_password']) && $_SESSION['correct_password'] == "ok") {
if (!isset($paso_dos)) {
?>
<form action="<?=$PHP_SELF?>?modificar_web=ok&paso_dos=ok" method="post" enctype="multipart/form-data" name="form1"> 

  <h1>Primer paso:</h1>
  <p align="center">Color de Fondo en Hexadecimal (#FFFFFF -> 255, 255, 255 (RGB)) o en ingles ("red, green, cyan, etc..."): 
   <input name="webbg" type="text" id="webbg" value="<?php if (isset($webbg)) { echo str_replace("&gt;", "&amp;gt;", str_replace("&lt;", "&amp;lt;", str_replace("\"", "&quot;", $webbg))); } ?>">
  </p>
  <p align="center">Comentario inicial de presentacion:<br>
   <textarea cols="60" rows="5" name="comentario_inicial" id="comentario_inicial" value="<?php if (isset($comentario_inicial)) { echo str_replace("&gt;", "&amp;gt;", str_replace("&lt;", "&amp;lt;", str_replace("\"", "&quot;", $comentario_inicial))); } ?>"></textarea>
  </p>
  <p align="center">Titulo (en la barra del titulo, sin tags):
   <input name="webtitle" type="text" id="webtitle" value="<?php if (isset($webtitle)) { echo str_replace("&gt;", "&amp;gt;", str_replace("&lt;", "&amp;lt;", str_replace("\"", "&quot;", $webtitle))); } ?>"> 
  </p> 
  <p align="center">Titulo (con tags, para el body):
   <input name="webtitle_body" type="text" id="webtitle_body" value="<?php if (isset($webtitle_body)) { echo str_replace("&gt;", "&amp;gt;", str_replace("&lt;", "&amp;lt;", str_replace("\"", "&quot;", $webtitle_body))); } ?>"> 
  </p> 
  <p align="center"><input name="boton3" type="submit" id="boton" value="Enviar"></p> 
</form> 

<?php
}
elseif (isset($paso_dos) && isset($_SESSION['correct_password']) && $_SESSION['correct_password'] == "ok") {

                 $archivo = fopen("webconf.php", "a+");

  //               $texto_modweb = <<<EOD
//                 \$webbg = \$_POST['webbg'];
  //               \$webtitle = \$_POST['webtitle'];
//EOD;



                   fwrite($archivo,"<?php\n\$webbg = \"" . str_replace("&quot;", "\"", str_replace("\\\\", "\\", $_POST['webbg'])) . "\";\n\$comentario_inicial = \"" .  str_replace("&quot;", "\"", str_replace("\\\\", "\\", $_POST['comentario_inicial'])) . "\";\n\$webtitle_body = \"" . str_replace("&quot;", "\"", str_replace("\\\\", "\\", $_POST['webtitle_body'])) . "\";\n\$webtitle = \"". str_replace("&quot;", "\"", str_replace("\\\\", "\\", $_POST['webtitle']))."\";\n?>\n");
//                 fwrite($archivo,$texto_modweb);

echo "<br>Web modificada con exito<br>";
echo "<a href=\"index.php\">Click aqui para ver el resultado</a><br>";

}

}

if (isset($agregar_fotos) && $agregar_fotos == "ok" && !isset($primer_paso) && isset($_SESSION['correct_password']) && $_SESSION['correct_password'] == "ok") {
?>
<form action="<?=$PHP_SELF?>?primer_paso=ok" method="post" enctype="multipart/form-data" name="form1"> 
  <h1>Primer paso:</h1>
  <p align="center">Archivo 
   <input name="archivo" type="file" id="archivo"> 
  </p> 
  <p align="center"><input name="boton" type="submit" id="boton" value="Enviar"></p> 
</form> 

<?php
} elseif (isset($primer_paso) && $primer_paso == "ok" && isset($_SESSION['correct_password']) && $_SESSION['correct_password'] == "ok") {
?>
<form action="<?=$PHP_SELF?>?finalizar=ok" method="post" name="form2"> 
  <h1>Segundo paso:</h1>
  <p align="center">Nombre de la imagen (debe ser unico):<br>
  <input name="nombre_imagen" type="textbox" id="nombre_imagen"></p> 
  <p align="center">Comentarios:<br>
  <textarea cols="60" rows="5" name="comentarios" id="comentarios" ></textarea></p>
  <p align="center"><input name="boton2" type="submit" id="boton" value="Enviar"></p> 
</form> 
<?php
}


if(isset($_POST['boton']) && isset($_SESSION['correct_password']) && $_SESSION['correct_password'] == "ok") { 
    if (is_uploaded_file($HTTP_POST_FILES['archivo']['tmp_name'])) { 
      copy($HTTP_POST_FILES['archivo']['tmp_name'], "img/" . $HTTP_POST_FILES['archivo']['name']); 
      $_SESSION['archivito'] = $HTTP_POST_FILES['archivo']['name'];
      $subio = true; 
    echo "El archivo subio con exito<br>"; 
    echo "<a href=\"edit.php?comentarios=agregar\">Click aqui para agregar comentarios</a>";
    } elseif(!isset($finalizar) && !isset($comentarios)) { 
    echo "El archivo no cumple con las reglas establecidas<br>"; 
die(); 
    }
}


if (isset($finalizar) && $finalizar == "ok" && isset($_SESSION['correct_password']) && $_SESSION['correct_password'] == "ok") {

                 $archivo = fopen($fotolog_file, "a+");

if (!isset($nombre[$_POST['nombre_imagen']])) {

//                 fwrite($archivo,"<img src=\"img/".$_SESSION['archivito']."\">\n<br>\n".str_replace("\\\"", "\"", $_POST['comentarios'])."\n<br><br>\n\n");

                 fwrite($archivo,"<?php\n\$nombre[\"".$_POST['nombre_imagen']."\"] = \"".$_POST['nombre_imagen']."\";\n\$comentarios[\"".$_POST['nombre_imagen']."\"] = \"".$_POST['comentarios']."\";\n\$path[\"".$_POST['nombre_imagen']."\"] = \"<img src=\\\"img/".$_SESSION['archivito']."\\\">\";\n?>\n");
                 
                 } else {
                 echo "<b>ERROR! Ya existe una imagen con ese nombre<br></b>";
                 }

    echo "<a href=\"index.php\">Click aqui para ver el resultado</a><br>";
} 



echo "</body>";
echo "</html>";

?> 


