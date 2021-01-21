<?php
  /**
  * Clase que gestiona métodos de la tabla inspeccion_apartados
  */

  require_once "base-catalogo.php";

	define( "TABLA_INSPECCION_APARTADO", "inspeccion_apartados" );

  class InspeccionApartado extends Catalogo
  {
    protected $id;
    protected $nombre;
    protected $descripcion;

		// Constructor
		public function __construct( )
    {
      parent::__construct( );
    }


		// Función para asignar atributos de la clase
    public function setAttributes( $parametros = array( ) )
    {
      foreach( $parametros as $atributo=>$valor )
			{
        $this->{$atributo} = $valor;
      }
    }


		// Método para consultar todos los registros
    public function consultarTodos( )
    {
      $resultado = parent::consultarTodosCatalogo( TABLA_INSPECCION_APARTADO );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_INSPECCION_APARTADO );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_INSPECCION_APARTADO );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_INSPECCION_APARTADO );
			return $resultado;
    }


  }
?>
