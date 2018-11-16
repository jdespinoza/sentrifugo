<?php
ini_set("session.auto_start", 0);
require 'html_table.php';
if(!empty($_POST))
{

    	   	$pdfcontent = urldecode($_POST['pdfcontent']);
    	   	$loginusername = $_POST['loginusername'];
    	   	$loginpwd = $_POST['loginpwd'];
    	   	$dbhost = $_POST['dbhost'];
			$dbusername = $_POST['dbusername'];
			$dbpassword = $_POST['dbpassword']!=''?$_POST['dbpassword']:'--';
			$dbname = $_POST['dbname'];
			$appname = $_POST['appname'];
			$appemail = $_POST['appemail'];
			$mailusername = $_POST['mailusername'];
			$mailpassword = $_POST['mailpassword'];
			$mailsmtp = $_POST['mailsmtp'];
			$mailtls = $_POST['mailtls'];
			$mailport = $_POST['mailport'];
			$cronjoburl = $_POST['cronjoburl'];
			$expirydocurl = $_POST['expirydocurl'];
			$tmcronurl = $_POST['tmcronurl'];


			$output = '<table border="1"  bordercolor="#CCCCCC">
<tr>
<td width="700" height="50"><b>Credenciales de inicio de sesión para '.$appname.'</b></td><td width="200" height="30"></td>
</tr>
<tr>
<td width="200" height="40">Nombre de Usuario:</td><td width="500" height="40">'.$loginusername.'</td>
</tr>
<tr>
<td width="200" height="40">Contraseña:</td><td width="500" height="40">'.$loginpwd.'</td>
</tr>
<tr>
<td width="700" height="50"><b>Pre Requisitos</b></td><td width="200" height="30"></td>
</tr>
<tr>
<td width="700" height="40">PHP v5.3 o mayor</td><td width="200" height="30"></td>
</tr>
<tr>
<td width="700" height="40">Extensión PDO-Mysql para PHP (pdo_mysql)</td><td width="200" height="40"></td>
</tr>
<tr>
<td width="700" height="40">Biblioteca GD (gd)</td><td width="200" height="40"></td>
</tr>
<tr>
<td width="700" height="40">Open SSL (openssl)</td><td width="200" height="40"></td>
</tr>
<tr>
<td width="700" height="50"><b>Configuración de BD</b></td><td width="200" height="40"></td>
</tr>
<tr>
<td width="200" height="40">Host:</td><td width="500" height="40">'.$dbhost.'</td>
</tr>
<tr>
<td width="200" height="40">Nombre de Usuario:</td><td width="500" height="40">'.$dbusername.'</td>
</tr>
<tr>
<td width="200" height="40">Contraseña:</td><td width="500" height="40">'.$dbpassword.'</td>
</tr>
<tr>
<td width="200" height="40">Base de Datos:</td><td width="500" height="40">'.$dbname.'</td>
</tr>
<tr>
<td width="700" height="50"><b>Configuración de la Aplicación</b></td><td width="200" height="40"></td>
</tr>
<tr>
<td width="200" height="40">Nombre de la Aplicación:</td><td width="500" height="40">'.$appname.'</td>
</tr>
<tr>
<td width="200" height="40">Correo:</td><td width="500" height="40">'.$appemail.'</td>
</tr>
<tr>
<td width="700" height="50"><b>Configuración del servidor de correo</b></td><td width="200" height="40"></td>
</tr>
<tr>
<td width="200" height="40">Nombre de Usuario:</td><td width="500" height="40">'.$mailusername.'</td>
</tr>
<tr>
<td width="200" height="40">Contraseña:</td><td width="500" height="40">'.$mailpassword.'</td>
</tr>
<tr>
<td width="200" height="40">Servidor SMTP:</td><td width="500" height="40">'.$mailsmtp.'</td>
</tr>
<tr>
<td width="200" height="40">Secure Transport Layer:</td><td width="500" height="40">'.$mailtls.'</td>
</tr>
<tr>
<td width="200" height="40">Puerto:</td><td width="500" height="40">'.$mailport.'</td>
</tr>
<tr>
<tr>
<td width="700" height="50"><b>Cron Job</b></td><td width="200" height="40"></td>
</tr>
<td width="700" height="40">'.$cronjoburl.'</td><td width="200" height="40"></td>
</tr>
<tr>
<td width="700" height="40">'.$expirydocurl.'</td><td width="200" height="40"></td>
</tr>
<tr>
<td width="700" height="40">'.$tmcronurl.'</td><td width="200" height="40"></td>
</tr>
</table>';

		    $pdf=new PDF();
			$pdf->SetFont('Arial','',12);
		    $pdf->AddPage();
		    if(ini_get('magic_quotes_gpc')=='1')
		    $output=stripslashes($output);
		    $pdf->WriteHTML($output);
		    $pdf->Output('Instalación.pdf','D');
		    exit;

}else
{
	header("Location: ".BASE_URL."");
}

?>
