<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-programa.php";
	require_once "../models/modelo-alumno.php";
	require_once "../models/modelo-persona.php";
	require_once "../models/modelo-pais.php";
	require_once "../models/modelo-situacion.php";
  require_once "../models/modelo-alumno-grupo.php";
  require_once "../models/modelo-grupo.php";
	require_once "../models/modelo-institucion.php";
	require_once "../models/modelo-domicilio.php";
	require_once "../models/modelo-estado.php";

	$programa = new Programa( );
	$programa->setAttributes( array( "id"=>$_GET["programa_id"] ) );
	$resultadoPrograma = $programa->consultarId( );

	$plantel = new Plantel( );
	$plantel->setAttributes( array( "id"=>$resultadoPrograma["data"]["plantel_id"] ) );
	$resultadoPlantel = $plantel->consultarId( );

	$institucion = new Institucion( );
	$institucion->setAttributes( array( "id"=>$resultadoPlantel["data"]["institucion_id"] ) );
	$resultadoInstitucion = $institucion->consultarId( );

	$domicilio = new Domicilio( );
	$domicilio->setAttributes( array( "id"=>$resultadoPlantel["data"]["domicilio_id"] ) );
	$resultadoDomicilio = $domicilio->consultarId( );

	$estado = new Estado( );
	$estado->setAttributes( array( ) );
	$resultadoEstado = $estado->consultarTodos( );

	if( $_GET["proceso"]=="consulta" )
	{
		$titulo = "Consulta de Expediente";

		$alumno = new Alumno( );
		$alumno->setAttributes( array( "id"=>$_GET["alumno_id"] ) );
		$resultadoAlumno = $alumno->consultarId( );

		$persona = new Persona( );
		$persona->setAttributes( array( "id"=>$resultadoAlumno["data"]["persona_id"] ) );
		$resultadoPersona = $persona->consultarId( );
	}

	if( $_GET["proceso"]=="edicion" )
	{
		$titulo = "Equivalencia";

		$alumno = new Alumno( );
		$alumno->setAttributes( array( "id"=>$_GET["alumno_id"] ) );
		$resultadoAlumno = $alumno->consultarId( );

		$persona = new Persona( );
		$persona->setAttributes( array( "id"=>$resultadoAlumno["data"]["persona_id"] ) );
		$resultadoPersona = $persona->consultarId( );
	}

	if( $resultadoPrograma["data"]["nivel_id"]==2 || $resultadoPrograma["data"]["nivel_id"]==3 )
	{
		$titulo_certificado1 = "Archivo Certificado de Bachillerato o equivalente (PDF)";
		$titulo_certificado2 = "Acreditación Certificado de Bachillerato";
	}

	if( $resultadoPrograma["data"]["nivel_id"]>=4 && $resultadoPrograma["data"]["nivel_id"]<=7)
	{
		$titulo_certificado1 = "Archivo C&eacute;dula Profesional o T&iacute;tulo (PDF)";
		$titulo_certificado2 = "Acreditación C&eacute;dula Profesional o T&iacute;tulo";
	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIIGES</title>
	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS DATATABLE -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
	<!-- CSS LIVESELECT -->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-select.min.css">
	<!-- CSS CALENDAR -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- CSS PROPIO -->
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body>
	<!-- HEADER Y MENÚ -->
	<?php require_once "menu.php"; ?>

	<!-- CUERPO DE PANTALLA -->
	<div class="container">
		<section class="main row margin-section-formularios">

			<!-- BARRA DE INFORMACION -->
			<div class="row" style="padding-left: 15px; padding-right: 15px;">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<!-- BARRA DE USUARIO -->
					<ol class="breadcrumb pull-right">
						<li><i class="icon icon-user"></i></li>
						<li><?php echo $_SESSION["nombre_rol"]; ?></li>
						<li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
					</ol>
					<!-- BARRA DE NAVEGACION -->
					<ol class="breadcrumb pull-left">
						<li><i class="icon icon-home"></i></li>
						<li><a href="ce-programas.php">Programas de Estudios</a></li>
						<li><a href="ce-alumnos.php?programa_id=<?php echo $_GET["programa_id"]; ?>">Alumnos</a></li>
						<li class="active"><?php echo $titulo; ?></li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-equivalencia.php" enctype="multipart/form-data">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre"><?php echo $titulo; ?></h2>
				<hr class="red">

				<!-- NOTIFICACIÓN -->
				<?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==404 ){ ?>
        <div class="alert alert-danger">
					<p>La matr&iacute;cula ingresada ya se encuentra registrada.</p>
        </div>
        <?php } ?>
				<!-- CONTENIDO -->
        <div class="row">
          <div class="col-sm-12">
						<legend>Datos del Alumno</legend>
					</div>
				</div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="id">Id</label>
							<input type="text" id="alumno_id" name="alumno_id" value="<?php echo (isset($resultadoAlumno)) ? $resultadoAlumno["data"]["id"] : "";
								?>" maxlength="11" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="persona_id">Persona Id</label>
							<input type="text" id="" name="" value="<?php echo(isset($resultadoAlumno)) ? $resultadoAlumno["data"]["persona_id"] : ""; ?>" maxlength="11" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="programa_id">Programa Id</label>
							<input type="text" id="" name="" value="<?php echo $_GET["programa_id"]; ?>" maxlength="11" class="form-control" required readonly />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="nombre">Nombre</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPersona["data"]["nombre"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="apellido_paterno">Apellido Paterno</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPersona["data"]["apellido_paterno"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="apellido_materno">Apellido Materno</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPersona["data"]["apellido_materno"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="curp">CURP</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPersona["data"]["curp"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="nombre_programa">Programa</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPrograma["data"]["nombre"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="expediente">No. de Expediente</label>
							<input type="text" id="expediente" name="expediente" value="<?php //echo (isset($resultadoPersona)) ? $resultadoPrograma["data"]["nombre"] : ""; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
						<br>
					</div>
				</div>
        <div class="row">
          <div class="col-sm-12">
						<legend>Datos de Insituci&oacute;n</legend>
					</div>
				</div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="institucion">Instituci&oacute;n</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoInstitucion)) ? $resultadoInstitucion["data"]["nombre"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label" for="plantel">Plantel</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoDomicilio)) ? $resultadoDomicilio["data"]["calle"]." ".$resultadoDomicilio["data"]["numero_exterior"].", ". $resultadoDomicilio["data"]["municipio"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
					</div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
						<br>
					</div>
				</div>
        <div class="row">
          <div class="col-sm-12">
						<legend>Datos de Insituci&oacute;n de Procedencia</legend>
					</div>
				</div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="nombre_institucion_procedencia">Instituci&oacute;n de Procedencia</label>
							<input type="text" id="nombre_institucion_emisora" name="nombre_institucion_procedencia" value="
							<?php //echo $res_validacion["data"] ? $res_validacion["data"][0]["nombre_institucion_emisora"] : ""; ?>
							" maxlength="255" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="txt-label1" for="estado">Estado de procedencia</label>
							<select id="estado_id" name="estado_id" class="selectpicker" data-live-search="true" data-width="100%" required>
								<option value=""> </option>
								<?php

									$max = count( $resultadoEstado["data"] );

									for( $i=0; $i<$max; $i++ )
									{
										if( $resultadoEstado["data"][$i]["id"]==$res_validacion["data"][0]["estado_id"] )
										{
											echo "<option value='".$resultadoEstado["data"][$i]["id"]."' selected>".$resultadoEstado["data"][$i]["estado"]."</option>";
										}
										else
										{
										  echo "<option value='".$resultadoEstado["data"][$i]["id"]."'>".$resultadoEstado["data"][$i]["estado"]."</option>";
										}
									}
								?>
							</select>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
						<br>
					</div>
				</div>
        <div class="row">
          <div class="col-sm-12">
						<legend>Documentaci&oacute;n</legend>
					</div>
				</div>
				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="control-label" for="archivo_certificado"><?php echo $titulo_certificado1; ?></label>
							<input type="file" id="archivo_certificado" name="archivo_certificado" accept="application/pdf" class="form-control" />
							<div><a href="../uploads/certificados/<?php echo $resultadoAlumno["data"]["archivo_certificado"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_certificado"]; ?></a></div>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="control-label" for="archivo_nacimiento">Archivo Acta de Nacimiento (PDF)</label>
							<input type="file" id="archivo_nacimiento" name="archivo_nacimiento" accept="application/pdf" class="form-control" />
							<div><a href="../uploads/certificados/<?php echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?></a></div>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="control-label" for="archivo_curp">Archivo CURP (PDF)</label>
							<input type="file" id="archivo_curp" name="archivo_curp" accept="application/pdf" class="form-control" />
							<div><a href="../uploads/certificados/<?php echo $resultadoAlumno["data"]["archivo_curp"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_curp"]; ?></a></div>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for=""></label>
						</div>
          </div>
        </div>

				<div class="row">
          <div class="col-sm-12">
						<legend>Documentaci&oacute;n para Equivalencia</legend>
					</div>
				</div>

				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="control-label" for="archivo_certificado_parcial">Certificado Parcial o Total (PDF)</label>
							<input type="file" id="archivo_certificado_parcial" name="archivo_certificado_parcial" accept="application/pdf" class="form-control" />
							<div><a href="../uploads/equivalencias/alumno#<?php //echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?></a></div>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>

				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="control-label" for="archivo_predictamen">Predictamen (PDF)</label>
							<input type="file" id="archivo_predictamen" name="archivo_predictamen" accept="application/pdf" class="form-control" />
							<div><a href="../uploads/equivalencias/alumno#<?php //echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?></a></div>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>

				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="control-label" for="archivo_pago_equivalencias">Pago de equivalencias</label>
							<input type="file" id="archivo_pago_equivalencias" name="archivo_pago_equivalencias" accept="application/pdf" class="form-control" />
							<div><a href="../uploads/equivalencias/alumno#<?php //echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?></a></div>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>
				
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="folio_resolucion">Folio de Resoluci&oacute;n Parcial</label>
							<input type="text" id="folio_resolucion" name="folio_resolucion" value="<?php //echo $res_validacion["data"] ? $res_validacion["data"][0]["folio_envio"] : ""; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="txt-label1" for="fecha_resolucion">Fecha de Resoluci&oacute;n Parcial</label>
							<input type="text" id="fecha_resolucion" name="fecha_resolucion" value="<?php //echo $res_validacion["data"] ? $res_validacion["data"][0]["fecha_envio"] : ""; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>

				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="control-label" for="archivo_resolucion">Resoluci&oacute;n Parcial (PDF)</label>
							<input type="file" id="archivo_resolucion" name="archivo_resolucion" accept="application/pdf" class="form-control" />
							<div><a href="../uploads/equivalencias/alumno#/<?php //echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?></a></div>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
						</div>
          </div>
        </div>

				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for=""></label>
						</div>
          </div>
        </div>

				<?php
					if( $_GET["proceso"]!="consulta" )
					{
				?>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<input type="hidden"  name="id" value="<?php //echo $res_validacion["data"] ? $res_validacion["data"][0]["id"] : ""; ?>" />
							<input type="hidden"  name="usuario_id" value="<?php echo isset($_SESSION["id"])?$_SESSION["id"]:-1; ?>" />
							<input type="hidden"  name="url" value="../views/ce-equivalencia-expediente.php?programa_id=<?php echo $_GET["programa_id"]."&alumno_id=".$_GET["alumno_id"]."&proceso=edicion"."&codigo=200"; ?> "/>
							<input type="hidden"  name="webService" value="guardar" />
							<input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-primary" />
						</div>
          </div>
        </div>
				<?php
					}
				?>
			</div>
			</form>

		</section>
	</div>

<!-- JS GOB.MX -->
<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
<!-- JS JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS DATATABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<!-- JS LIVESELECT -->
<script src="../js/bootstrap-select.min.js"></script>
<!-- JS CALENDAR -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$(document).ready(function(){
		$("#fecha_resolucion").datepicker({
			firstDay: 1,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: 'yy-mm-dd'
		})
	});
</script>
</body>
</html>
