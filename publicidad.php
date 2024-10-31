<?php
/*
Plugin Name: Publicidades 
Plugin URI: http://www.claudiomarrero.com.ar/
Description: Plugin creado con la intencion de identificar los clicks en las publicidades de Salgamosmas
Author: Claudio A. Marrero
Version: 1.0
Author URI: http://claudiomarrero.com.ar/
*/
/*Acciones de instalacion*/
global $jal_db_version;
$jal_db_version = "1.0";

function jal_install() {
   global $wpdb;
   global $jal_db_version;

   $table_name = "sa_publicidad";
      
   $sql = "CREATE TABLE " . $table_name . " (
		  id int(11) NOT NULL auto_increment,
		  cliente varchar(250) NOT NULL,
		  redireccion text NOT NULL,
		  clicks int(11) default NULL,
		  imp int(11) default NULL,
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    ";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
 
   add_option("jal_db_version", $jal_db_version);
}
register_activation_hook(__FILE__,'jal_install');
/*Comienza el plugin*/
function publicidad_menu(){
	$publicidad = add_menu_page('publicidad','Publicidad',0,'publicidad','publicidades');
	add_contextual_help($publicidad ,'Gestion de Publicidades');
}
add_action('admin_menu','publicidad_menu');

/**/
function publicidades(){
global $wpdb;
?>
<div class="wrap">
<h2>Clientes</h2>
<?php
if(isset($_POST['nuevo_cliente'])){
	$cliente = $_POST['cliente'];
	$redireccion = $_POST['redireccion'];
	//Insertar
	$retorno = $wpdb->insert('sa_publicidad',array('cliente'=>$cliente,'redireccion'=>$redireccion));
	if($retorno == 1){
		?>
        <div id="message" class="updated"><p>Cliente creado con exito.</p></div>
        <?php
	}else{
		?>
        <div id="message" class="updated"><p>No se pudo crear el cliente, revise los datos suministrados.</p></div>
		<?php
	}
}
if(isset($_GET['delete'])){
	$delete = $_GET['delete'];
	$delete = $wpdb->query('DELETE FROM sa_publicidad WHERE id = '.$delete);
	?>
        <div id="message" class="updated"><p>Cliente Eliminado con Exito</p></div>
   <?php
}
$clientes = $wpdb->get_results('SELECT id,cliente,redireccion,clicks,imp FROM sa_publicidad');
		?>
<form action="admin.php?page=publicidad" method="post">
        <table class="widefat">
        <thead>
        	<tr>
            	<th>ID</th>
            	<th>Cliente</th>
                <th>Redireccion</th>
                <th>Clicks</th>
                <th>IMP</th>
                <th>...</th>
            </tr>
        </thead>
       	<tbody>
        <?php if(!empty($clientes)){ ?>
			<?php foreach($clientes as $c){ ?>
                <tr>
                	<td><?=$c->id;?></td>
                    <td><?=$c->cliente;?></td>
                    <td><?=$c->redireccion;?></td>
                    <td><?=$c->clicks;?></td>
                    <td><?=$c->imp;?></td>
                    <th><a href="admin.php?page=publicidad&delete=<?=$c->id;?>">Delete</a></th>
                </tr>
            <?php } ?>
        <?php } ?>
        	<tr>
            	<td><input type="text" value="" name="cliente" id="cliente" placeholder="Nuevo Cliente"></td>
                <td><input size="30" type="text" value="" name="redireccion" id="cliente" placeholder="Redireccion de Publicidad"></td>
                <td colspan="4"><input type="submit" value="Nuevo" name="nuevo_cliente"></td>
            </tr>
        </tbody>
        <tfoot>
        	<tr>
            	<th>ID</th>
            	<th>Cliente</th>
                <th>Redireccion</th>
                <th>Clicks</th>
                <th>IMP</th>
                <th>...</th>
            </tr>
        </tfoot>
        </table>
</form>
</div>
<?php
}

?>