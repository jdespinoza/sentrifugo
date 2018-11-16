<?php
/*********************************************************************************
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2014 Sapplica
 *
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/
?>

<?php
if(defined('SENTRIFUGO_HOST') && defined('SENTRIFUGO_USERNAME') && defined('SENTRIFUGO_PASSWORD') && defined('SENTRIFUGO_DBNAME') && defined('APPLICATION_NAME') && defined('SUPERADMIN_EMAIL') && defined('MAIL_SMTP') && defined('MAIL_USERNAME') && defined('MAIL_PASSWORD') && defined('MAIL_PORT') && defined('MAIL_TLS') && defined('MAIL_AUTH'))
{ ?>
<form name="frmstep5" id="idfrmstep5" action="../success.php" method="post" class="frm_install">
    <h3 class="page_title">Revisión final</h3>
    <div class="content_part">
<?php
$req_html_arr = array(
		'php' => "PHP v5.3 o mayor",
		"pdo_mysql" => "Extensión PDO-Mysql para PHP (pdo_mysql)",
		//"mod_rewrite" => "Rewrite module (mod_rewrite)",
		"gd" => "Biblioteca GD (gd)",
        'openssl' => "Open SSL (openssl)"
);
?>
<div id="accordion">
        <ul class="progress">
        <li class="accclass"><h4>Pre Requisitos<span class="iteminfo">(5 items)</span></h4></li>
        <div>
<?php

	foreach($req_html_arr as $req => $req_value)
	{
?>
            <li><?php echo $req_value;?> <div class="status_yes"></div></li>
<?php
        }
?>
    </div>

    <li class="accclass"><h4>Configuración de BD<span class="iteminfo">(4 items)</span></h4></li>
    <div>
    <li><span class="info">Host:</span><span class="infotext"><?php echo SENTRIFUGO_HOST;?></span></li>
    <li><span class="info">Nombre de Usuario:</span><span class="infotext"><?php echo SENTRIFUGO_USERNAME;?></span></li>
    <li><span class="info">Contraseña:</span><span class="infotext"><?php echo SENTRIFUGO_PASSWORD;?></span></li>
    <li><span class="info">Base de Datos:</span><span class="infotext"><?php echo SENTRIFUGO_DBNAME;?></span></li>
    </div>

    <li class="accclass"><h4>Configuración de la Aplicación<span class="iteminfo">(2 items)</span></h4></li>
    <div>
    <li><span class="info">Nombre de la Aplicación:</span><span class="infotext"><?php echo APPLICATION_NAME;?></span></li>
    <li><span class="info">Correo:</span><span class="infotext"><?php echo SUPERADMIN_EMAIL;?></span></li>
    </div>

    <li class="accclass"><h4>Configuración del servidor de correo<span class="iteminfo">(6 items)</span></h4></li>
    <div>
	<li><span class="info">Autenticación:</span><span class="infotext"><?php echo MAIL_AUTH;?></span></li>
    <li><span class="info">Nombre de Usuario:</span><span class="infotext"><?php echo MAIL_USERNAME;?></span></li>
    <li><span class="info">Contraseña:</span><span class="infotext"><?php echo MAIL_PASSWORD;?></span></li>
    <li><span class="info">Servidor SMTP:</span><span class="infotext"><?php echo MAIL_SMTP;?></span></li>
    <li><span class="info">Secure Transport Layer:</span><span class="infotext"><?php echo MAIL_TLS;?></span></li>
    <li><span class="info">Puerto:</span><span class="infotext"><?php echo MAIL_PORT;?></span></li>
    </div>

    <li class="accclass"><h4>Cron Job <span class="iteminfo">(1 item)</span></h4></li>
    <div>
    <li><?php echo str_replace("install/", "",BASE_URL.'cronjob');?></li>
    <li><?php echo str_replace("install/", "",BASE_URL).'cronjob/empdocsexpiry';?></li>
    <li><?php echo str_replace("install/", "",BASE_URL).'timemanagement/cronjob';?></li>
    </div>

    </ul>
    </div>


<div id="mailcontentdiv"  style="display: none;">
        <ul style="list-style: none outside none; width: 100%; background: none repeat scroll 0% 0% rgb(255, 255, 255); padding: 0px;">
         <li style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><h4 style="color: rgb(105, 145, 61); margin-top: 8px; margin-bottom: 0px;">Pre Requisitos</h4></li>
        <div>
<?php

	foreach($req_html_arr as $req => $req_value)
	{
?>
            <li style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><?php echo $req_value;?> <div class="status_yes"></div></li>
<?php
        }
?>
    </div>
     <?php
	$password = '--';
		if (defined('SENTRIFUGO_PASSWORD')) {
			if (SENTRIFUGO_PASSWORD) {
				$password = SENTRIFUGO_PASSWORD;
			}
		}
	?>
    <li style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><h4 style="color: rgb(105, 145, 61); margin-top: 8px; margin-bottom: 0px;">Configuración de BD</h4></li>
    <div>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Host: </span><span><?php echo SENTRIFUGO_HOST;?></span></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Nombre de Usuario: </span><span><?php echo SENTRIFUGO_USERNAME;?></span></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Contraseña: </span><span><?php echo $password;?></span></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Base de Datos: </span><span><?php echo SENTRIFUGO_DBNAME;?></span></li>
    </div>

    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><h4 style="color: rgb(105, 145, 61); margin-top: 8px; margin-bottom: 0px;">Configuracion de la Aplicación</h4></li>
    <div>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Nombre de la Aplicación: </span><span><?php echo APPLICATION_NAME;?></span></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Correo: </span><span><?php echo SUPERADMIN_EMAIL;?></span></li>
    </div>

    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><h4 style="color: rgb(105, 145, 61); margin-top: 8px; margin-bottom: 0px;">Configuración del servidor de correo</h4></li>
    <div>
	 <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Autenticación: </span><span><?php echo MAIL_AUTH;?></span></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Nombre de Usuario: </span><span><?php echo MAIL_USERNAME;?></span></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Contraseña: </span><span><?php echo MAIL_PASSWORD;?></span></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Servidor SMTP: </span><span><?php echo MAIL_SMTP;?></span></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Secure Transport Layer: </span><span><?php echo MAIL_TLS;?></span></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><span>Puerto: </span><span><?php echo MAIL_PORT;?></span></li>
    </div>

    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><h4 style="color: rgb(105, 145, 61); margin-top: 8px; margin-bottom: 0px;">Cron Job</h4></li>
    <div>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><?php echo str_replace("install/", "",BASE_URL.'cronjob');?></li>
    <li  style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><?php echo str_replace("install/", "",BASE_URL).'cronjob/empdocsexpiry';?></li>
    <li style="border-bottom: 1px solid rgb(204, 204, 204); margin: 0px; padding: 10px 5px 10px 15px;"><?php echo str_replace("install/", "",BASE_URL).'timemanagement/cronjob';?></li>
    </div>

    </ul>
    </div>


    <input type="hidden" id="mailcontent" name="mailcontent" />
    <input type="hidden" id="dbhost" name="dbhost" value="<?php echo SENTRIFUGO_HOST;?>" />
    <input type="hidden" id="dbusername" name="dbusername" value="<?php echo SENTRIFUGO_USERNAME;?>" />
    <input type="hidden" id="dbpassword" name="dbpassword" value="<?php echo SENTRIFUGO_PASSWORD;?>" />
    <input type="hidden" id="dbname" name="dbname" value="<?php echo SENTRIFUGO_DBNAME;?>" />
    <input type="hidden" id="appname" name="appname" value="<?php echo APPLICATION_NAME;?>" />
    <input type="hidden" id="appemail" name="appemail" value="<?php echo SUPERADMIN_EMAIL;?>" />
    <input type="hidden" id="mailusername" name="mailusername" value="<?php echo MAIL_USERNAME;?>" />
    <input type="hidden" id="mailpassword" name="mailpassword" value="<?php echo MAIL_PASSWORD;?>" />
    <input type="hidden" id="mailsmtp" name="mailsmtp" value="<?php echo MAIL_SMTP;?>" />
    <input type="hidden" id="mailtls" name="mailtls" value="<?php echo MAIL_TLS;?>" />
    <input type="hidden" id="mailport" name="mailport" value="<?php echo MAIL_PORT;?>" />
	<input type="hidden" id="mailauth" name="mailauth" value="<?php echo MAIL_AUTH;?>" />
    <input type="hidden" id="cronjoburl" name="cronjoburl" value="<?php echo str_replace("install/", "",BASE_URL.'cronjob');?>" />
    <input type="hidden" id="expirydocurl" name="expirydocurl" value="<?php echo str_replace("install/", "",BASE_URL).'cronjob/empdocsexpiry';?>" />
	<input type="hidden" id="tmcronurl" name="tmcronurl" value="<?php echo str_replace("install/", "",BASE_URL).'timemanagement/cronjob';?>" />
    <input type="submit" name="btnfinish" id="idbtnfinish"   class="save_button finish_step" value="Terminar" />
    <button name="previous" id="previous" type="button" class="previous_button"  onclick="window.location='index.php?s=<?php echo sapp_Global::_encrypt(4);?>';">Anterior</button>
</form>


<script type="text/javascript">
		$(document).ready(function(){
			$( "#accordion" ).accordion({ header: ".accclass",
										collapsible: true,
										active:false ,
										heightStyle:"content",
										icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus"}

										});


			$(".first_li").addClass('active');
			$(".first_icon").addClass('yes');

			<?php if(defined('SENTRIFUGO_HOST') && defined('SENTRIFUGO_USERNAME') && defined('SENTRIFUGO_PASSWORD') && defined('SENTRIFUGO_DBNAME')){ ?>
			$(".second_li").addClass('active');
			$(".second_icon").addClass('yes');
			<?php }?>

			<?php if(defined('APPLICATION_NAME') && defined('SUPERADMIN_EMAIL') && constant('SUPERADMIN_EMAIL') !='') { ?>
			$(".third_li").addClass('active');
			$(".third_icon").addClass('yes');
			<?php }?>

			<?php if(defined('MAIL_SMTP') && defined('MAIL_USERNAME') && defined('MAIL_PASSWORD') && defined('MAIL_PORT') && defined('MAIL_TLS')){ ?>
			$(".fourth_li").addClass('active');
			$(".fourth_icon").addClass('yes');
			<?php }?>

			<?php if(defined('SENTRIFUGO_HOST') && defined('SENTRIFUGO_USERNAME') && defined('SENTRIFUGO_PASSWORD') && defined('SENTRIFUGO_DBNAME') && defined('APPLICATION_NAME') && defined('SUPERADMIN_EMAIL') && defined('MAIL_SMTP') && defined('MAIL_USERNAME') && defined('MAIL_PASSWORD') && defined('MAIL_PORT') && defined('MAIL_TLS')){ ?>
			$(".fifth_li").addClass('active');
			$(".fifth_icon").addClass('yes');
			<?php }?>

			var html =$("#mailcontentdiv").html();
			$("#mailcontent").val(html);
		});
</script>

<?php }else{?>
   <div class="content_part">
      <div  class="error-txt" style="margin: 40px auto 0px;"> <h2>All the steps are not installed properly</h2></div>
   </div>
<?php }?>
