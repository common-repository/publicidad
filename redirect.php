<?
include('../../../wp-blog-header.php');
$cliente = $_GET['cliente'];
$get_client = $wpdb->get_results('SELECT id,redireccion,clicks FROM sa_publicidad WHERE id= '.$cliente);
if(!empty($get_client)){
	$redireccion = $get_client[0]->redireccion;
	$clicks = $get_client[0]->clicks + 1;
	$update = $wpdb->update('sa_publicidad',array('clicks'=>$clicks),array('id'=>$get_client[0]->id));
	if($update == 1){
		header('Location: '.$redireccion);
	}else{
		header('Location: '.get_bloginfo('url'));
	}
}else{
	header('Location: '.get_bloginfo('url'));
}
?>