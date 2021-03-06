<?php
  /**
  * Archivo que gestiona los web services de la clase Municipio
  */

  require_once "../models/modelo-municipio.php";
  require_once "../utilities/utileria-general.php";

	function retornarWebService( $url, $resultado )
	{
    if( $url!="" )
		{
			header( "Location: $url" );
			exit( );
		}
		else
		{
			echo json_encode( $resultado );
			exit( );
		}
	}

	//====================================================================================================

  // Web service para consultar todos los registros
  if( $_POST["webService"]=="consultarTodos" )
  {
    $obj = new Municipio( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Municipio();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para guardar registro
  if( $_POST["webService"]=="guardar" )
  {
    $parametros = array( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		foreach( $_POST as $atributo=>$valor )
		{
			$parametros[$atributo] = $valor;
		}
		$obj = new Municipio( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Municipio( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
		retornarWebService( $_POST["url"], $resultado );
  }
  if ( $_POST["webService"]=="consultarMunicipios" )
  {
    $obj = new Municipio( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $resultado = $obj->consultarPor('municipios',array('estado_id'=>$_POST['id_estado']),'*');
    retornarWebService( $_POST["url"], $resultado );
  }

?>
