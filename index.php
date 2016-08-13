<?php

$fotolog_file = "fotolog.txt";

if (file_exists("webconf.php")) {
include "webconf.php";
}

if (!file_exists("contador.php")) {
$contador_file = fopen("contador.php", "a+");
fwrite($contador_file,"<?php \$contador = 1; ?>\n");
include "contador.php";
} else {
$contador_file = fopen("contador.php", "a+");
fwrite($contador_file,"<?php \$contador++; ?>\n");
include "contador.php";
}


?>
<html>
<head>
<title><?php if(isset($webtitle)) { echo $webtitle; } ?></title>
</head>
<body bgcolor="<?php if(isset($webbg)) { echo $webbg; } ?>">
<?php

   if (isset($_POST['nombre_comentarios']) && !isset($_POST['comentario_nick']) || isset($_POST['nombre_comentarios']) && $_POST['comentario_nick'] == "" || isset($_POST['nombre_comentarios']) && !isset($_POST['comentario_guest']) || isset($_POST['nombre_comentarios']) && $_POST['comentario_guest'] == "") {
   echo "<table border=\"1\" cellspacing=\"5\"><tr><td>";
   echo "(!) <b>ERROR</b> !(!)<br></td></tr>";
   echo "<tr><td>FALTA <b>RELLENAR</b> ALGUN <b>CAMPO</b><br><b>No se envi&oacute; nada</b></b>";
   echo "</td></tr></table>";
   echo "<br><br><br>";
   }
   
if (isset($contador)) { echo "<table align=\"right\" border=\"1\" cellpadding=\"5\"><tr><td>N&uacute;mero de visitas: <b>".$contador."</b></td></tr></table><br><br><br>"; }

if(isset($webtitle_body)) { echo "<h1>".$webtitle_body."</h1>"; }

if (isset($comentario_inicial)) {
echo $comentario_inicial."<br><br><br>";
}

if (file_exists("fotolog.txt")) {
include $fotolog_file;

if (isset($_POST['nombre_comentarios']) && $_POST['nombre_comentarios'] != "" && isset($_POST['comentario_guest']) && $_POST['comentario_guest'] != "" && isset($_POST['comentario_nick']) && $_POST['comentario_nick'] != "") {


                 $archivo = fopen($fotolog_file, "a+");

                 if (isset($comentarios_guest[$_POST['nombre_comentarios']]) && $comentarios_guest[$_POST['nombre_comentarios']] != "") {
                 fwrite($archivo,"<?php\n\$comentarios_guest[\"".$_POST['nombre_comentarios']."\"] .= \"<table width=\\\"100%\\\" border=\\\"1\\\" cellpadding=\\\"5\\\"><tr><td>".$REMOTE_ADDR." (".gethostbyaddr($REMOTE_ADDR).")</td></tr><tr><td>".date("d/m/Y [H:i:s]")." [<b>".$comentario_nick."</b>] <b>".$_POST['comentario_guest']."</b></td></tr></table><br>\";\n?>\n");
                 } else {

                 fwrite($archivo,"<?php\n\$comentarios_guest[\"".$_POST['nombre_comentarios']."\"] = \"<table width=\\\"100%\\\" border=\\\"1\\\" cellpadding=\\\"5\\\"><tr><td>".$REMOTE_ADDR." (".gethostbyaddr($REMOTE_ADDR).")</td></tr><tr><td>".date("d/m/Y [H:i:s]")." [<b>".$comentario_nick."</b>] <b>".$_POST['comentario_guest']."</b></td></tr></table><br>\";\n?>\n");
                 }

                 include $fotolog_file;

}

if (isset($nombre)) {

   foreach ($nombre as $x => $y) {
   echo "<center>";
   echo "<table border=\"1\" width=\"80%\" cellpadding=\"5\"><tr><td>Nombre: <font size=\"5\"><b>".$nombre[$y]."</b></font></td></tr></table>";
   echo "<table border=\"1\" width=\"80%\" cellpadding=\"5\"><tr><td>Comentarios propios: <font size=\"4\"><b>".$comentarios[$y]."</b></font></td></tr></table>";

   echo "<table border=\"1\" width=\"80%\" cellpadding=\"5\"><tr><td>";
   echo "<table border=\"1\" width=\"100%\" cellpadding=\"5\"><tr><td>Imagen:</td></tr></table>";
   echo "<br><center>".$path[$y]."</center><br>";
   echo "</td></tr><tr><td>";
//   echo "<table border=\"1\" width=\"80%\" cellpadding=\"5\"><tr><td>";

   echo "<table border=\"1\" width=\"100%\" cellpadding=\"5\"><tr><td><b>Comentarios enviados</b>:</td></tr></table>";

   echo "<br>";

   if (isset($comentarios_guest[$y])) {
   echo $comentarios_guest[$y];
   }

   echo "<br><br>";

   echo "<table border=\"1\" cellpadding=\"5\"><tr><td>";
   echo "<b>Enviar comentario</b>:</td></tr>";
   echo "<tr><td>";
   echo "<form method=\"post\" action=\"index.php\">";
   echo "<input type=\"hidden\" name=\"nombre_comentarios\" value=\"".$y."\">";
   echo "Nombre:</td></tr>";
   echo "<tr><td><input type=\"text\" name=\"comentario_nick\"></td></tr>";
   echo "<tr><td>Comentario:</td></tr>";
   echo "<tr><td><textarea cols=\"60\" rows=\"5\" name=\"comentario_guest\"></textarea></td></tr>";
   echo "<tr><td><input type=\"submit\" value=\"Enviar comentario\"></td></tr>";
   echo "</form>";
   echo "</td></tr></table>";

   echo "<br></td></tr></table><br><br>";
   echo "</center>";
   }

}

}

               
?>
<br>
<br>
<table align="right" border="1" cellpadding="5"><tr><td>Fotolog by <b>A-Kristo</b></td></tr></table><br>
</body>
</html>
