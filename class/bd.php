<?php
$archivo=$_SERVER['SCRIPT_NAME'];
$carpeta=explode("/",$archivo);
$subcarpeta=$carpeta[1];
include_once($_SERVER['DOCUMENT_ROOT']."/".$subcarpeta."/class/conexion.php");
include_once($_SERVER['DOCUMENT_ROOT']."/".$subcarpeta."/funciones/funciones.php");
class bd{
	var $l;
	var $tabla;
	var $resultado;
	var $campos=array();
	function __construct(){
		global $bost,$user,$pass,$database;
		@$link=mysql_connect($host,$user,$pass);
		if($link){
			if(@mysql_select_db($database,$link)){
				mysql_query("SET NAMES utf8");
				$this->l=$link;
			}
			else{
				echo "No se pudo encontrar la Base de Datos ";
				exit();
			}
		}else{
			echo "No se Puede Conectar a la Base de Datos";
			exit();
		}
		if($this->tabla=="" && empty($this->tabla)){
			$this->tabla=mb_strtolower(get_class($this),"utf8");
		}
	}
	function __destruct(){
		@mysql_close($this->l);
	}
	function getTables(){
		global $database;
		return $this->sql("SHOW TABLES FROM ".$database);
	}
	function get_db(){
		global $database;
		return $database;
	}
	function sql($consulta){
		//echo mysql_real_escape_string ($consulta);
		$consQ =mysql_query (($consulta));
		$resultado =array ();
		if ($consQ)
		{
			while ($consF =mysql_fetch_assoc ($consQ))
				array_push ($resultado, $consF);
		}
		//echo ($consulta);
		return $resultado;
	}
	function sqlProc($consulta){
		//echo mysql_real_escape_string ($consulta);
		$consQ =mysql_query (($consulta));
		$resultado =array ();
				//array_push ($resultado, $consQ);
		//echo ($consulta);
		return $resultado;
	}
	function queryE($data,$f){
		//echo $data;
		if($f=="lock" && md5("lock")==md5($f))
		{
			mysql_query($data); //or die(mysql_err($this->l));
		}
	}
	function statusTable(){
		$query ="SHOW TABLE STATUS LIKE '$this->tabla'";
		$res=mysql_query($query);
		return mysql_fetch_array($res);
	}
	function getUsuario($where_str){
		$camposs ="*";
		$where =$where_str ? "WHERE $where_str" : "";
		$query ="SELECT $camposs FROM ".$this->tabla." $where";
		echo $query."<br>";
		//return $this->sql ($query);
	}
	function getRecords($where_str=false, $order_str=false,$group_str=false, $count=false, $start=0, $order_strDesc=false){
		$where =$where_str ? "WHERE $where_str" : "";
		$order =$order_str ? "ORDER BY $order_str ASC" : "";
		$order =$order_strDesc ? "ORDER BY $order_str DESC" : $order;
		$group =$group_str ? "GROUP BY $group_str":"";
		$count = $count ? "LIMIT $start, $count" : "";
		$camposs =implode (', ', $this->campos);
		$query ="SELECT $camposs FROM {$this->tabla} $where $group $order $count ";
  	   	//echo $query."\n";
		return $this->sql ($query);
	}
	function last_id(){
		return mysql_insert_id($this->l);
	}
	public function insertRow ($data,$sw=1,$swadicional=1){
		$key=array();
		$val=array();
		foreach($data as $k => $v){
			$key[]=$k;
			$val[]=$v;
		}
		if($swadicional==1){
			if (!isset($_SESSION['codusuario']))$codusuario=0;
			else $codusuario=$_SESSION['codusuario'];
			$fecha=date("Y-m-d");
			$hora=date("H:i:s");
			$hostname = ObtenerIP()."-".gethostbyaddr($_SERVER['REMOTE_ADDR']);
			/****** definimos parametros ******/
			array_push($key, "usuariocreacion");
			array_push($key,"fechacreacion");
			array_push($key,"horacreacion");
			array_push($key,"nombrehost");
			array_push($key, "activo");
			/****** Asignamos parametros ******/
			array_push($val,$codusuario);
			array_push($val,"'$fecha'");
			array_push($val,"'$hora'");
			array_push($val,"'$hostname'");
			array_push($val,"1");
		}
		$campos=implode(",",$key);
		$datos= implode(",",$val);
		if($sw==0)
			$query ="INSERT INTO {$this->tabla} VALUES ($datos)";
		else
			$query ="INSERT INTO {$this->tabla} ($campos) VALUES ($datos)";
		//echo $query."\n";
		return mysql_query($query);
	}
	function deleteRecord($where_str){
		$where =$where_str ? "WHERE $where_str" : "";
		mysql_query ("DELETE FROM {$this->tabla} $where");
	}
	function updateRow($dataValues,$where_str){
		$where =$where_str ? "WHERE $where_str" : "";
		$data=array();
		foreach($dataValues as $k =>$v){
			array_push($data,$k."=".$v);
		}
		$datos=implode(",",$data);
		 //echo "UPDATE {$this->tabla} SET $datos $where";
		return mysql_query ("UPDATE {$this->tabla} SET $datos $where");
	}
	function insertar($Values,$swadicional=1){
		return $this->insertRow($Values,1,$swadicional);
	}
	function mostrar($Cod){
		$this->campos=array("*");
		return $this->getRecords("id".$this->tabla."=$Cod");
	}
	function muestra($Cod){
		$this->campos=array("*");
		$tablaRes=$this->getRecords("id".$this->tabla."=$Cod");
		return array_shift($tablaRes);
	}
	function mostrarUsuario($usuario,$pass){
		$this->campos=array("*");
		return $this->getUsuario($this->tabla."='$usuario' and pass='$pass'");
	}
	function mostrarTodoDesdendente($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden=$orden?$orden:"id".$this->tabla;
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)

			return $this->getRecords($condicion."activo=1",$orden,0,0,0,1);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,0);
	}
	function mostrarTodo($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden=$orden?$orden:"id".$this->tabla;
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."activo=1",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,0);
	}
	function mostrarLast($where='',$orden=true,$cantidad=1){
		$this->campos=array('*');
		$orden=$orden?$orden:"id".$this->tabla;
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."activo=1",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,0);
	}
	function mostrarT($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');

		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."activo=1",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,0);
	}


	function mostrarT2($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden="horareserva";
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."activo=1",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,0);
	}
	function mostrarNom($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden="nombre";
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."activo=1",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,0);
	}
		function mostrarT3($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden="diareserva";
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."activo=1",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,0);
	}
	function mostrarT4($where='',$orden=false,$cantidad=8){
		$this->campos=array('*');
		$orden="diareserva";
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."activo=1",$orden,0,0,0,1);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,1);
	}
	function mostrarOrdenado($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden=$orden?$orden:"fechaasistencia";
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)

			return $this->getRecords($condicion."activo=1",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,0);
	}
	function mostrarTodoDesactivados($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden=$orden?$orden:"id".$this->tabla;
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."activo=0" ,$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."activo=0" ,$orden,0,$cantidad,0,0);
	}
	function mostrarFull($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden=$orden?$orden:"id".$this->tabla;
		$condicion=$where?$where :'';
		if($cantidad==0)
			return $this->getRecords($condicion  ,$orden,0,0,0,0);
		else
			return $this->getRecords($condicion  ,$orden,0,$cantidad,0,0);
	}
	function mostrarTodos($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden=$orden?$orden:"cod".$this->tabla;
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."activo=1",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."activo=1",$orden,0,$cantidad,0,0);
	}
	function mostrarTodoUnion($tablas='',$campos='*',$orden="",$where='',$activo='',$cantidad=0){
		$this->tabla=$tablas;
		$this->campos=array($campos);
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion.$activo."activo=1",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion.$activo."activo=1",$orden,0,$cantidad,0,0);
	}
	function mostrarUltimo($where=''){
		$this->campos=array('*');
		$condicion=$where?$where.' and ':'';
		$tablaRes=$this->getRecords($condicion."activo=1","id".$this->tabla,0,1,0,1);
		return array_shift($tablaRes);
	}
	function mostrarPrimero($where=''){
		$this->campos=array('*');
		$condicion=$where?$where.' and ':'';
		$tablaRes=$this->getRecords($condicion."activo=1","id".$this->tabla,1,1,0,0);
		return array_shift($tablaRes);
	}
	function mostrarBusqueda($where='',$start=false,$cantidad=false){
		$this->campos=array('*');
		$condicion=$where?$where.' and ':'';
		return $this->getRecords($condicion."activo=1","id".$this->tabla,0,$cantidad,$start,1);
	}
	function actualizar($values,$Cod){
		return $this->updateRow($values,"id".$this->tabla."=$Cod");
	}
	//actualiza la tabla ingresando una condicion
	function actualizarFila($values,$Cond){
		return $this->updateRow($values,$Cond);
	}
	function eliminar($Cod){
		$this->updateRow(array("activo"=>0),"id".$this->tabla."=$Cod");
	}
    function eliminarCondicion($Condicion){
		$this->updateRow(array("activo"=>0),$Condicion);
	}
	function actualizar2($values){
		return $this->updateRow($values,"id".$this->tabla."");
	}
	function eliminarTodo($values){
		return $this->deleteRecord($values);
	}
     /*Nuevas funciones helo*/
	function mostrarTodoSinCondicion($where='',$orden=false,$cantidad=0){
		$this->campos=array('*');
		$orden=$orden?$orden:"id".$this->tabla;
		$condicion=$where?$where.' and ':'';
		if($cantidad==0)
			return $this->getRecords($condicion."",$orden,0,0,0,0);
		else
			return $this->getRecords($condicion."",$orden,0,$cantidad,0,0);
	}
	function desactivar($Cod){
		$this->updateRow(array("activo"=>0),"id".$this->tabla."=$Cod");
	}
	function activar($Cod){
		$this->updateRow(array("activo"=>1),"id".$this->tabla."=$Cod");
	}
	/****************** funciones  jhulios ******************************/
	/************* funcion para organigrama *****************************/
	function bucleOrg($Cod){
		$where='padre='.$Cod;
        echo '<ul>';
	    foreach($this->mostrarTodo($where) as $f)
	    {
	      echo '<li ><a class="ornombre">'.$f["nombre"].'<br>'.$f["paterno"].' '.$f["materno"].'</a><br><span class="orcargo">'.$f['ncargo'].'</span>';
	      //revisar si el siguiente tiene hijos
	      /*********** bucle **************************************/
	      $dato=$this->mostrarTodo("padre=".$f['idvorganigrama']);
	      if (count($dato)>0)$this->bucleOrg($f['idvorganigrama']);
	      /*********************************************************/
	      echo '</li>';
	    }
	    echo '</ul>';
	}
	/******************* funcion para mostrar org. para configurar ***********/
	function bucleOrgConfig($Cod){
		$where='padre='.$Cod;
        echo '<ul>';
	    foreach($this->mostrarTodo($where) as $f)
	    {
	    	// declaramos botones
	    	$agregar=' <button href="#modal5" onclick="agregarBtn('.$f["idvorganigrama"].');" style=" color: white;" class="btj green modal-trigger "> <i class="fa fa-plus-square"></i> </button> ';
	    	$eliminar='<button onclick="quitarBtn('.$f["idvorganigrama"].');" class="btj red"> <i class="fa fa-minus-square"></i> </button>';
	      //revisar si el siguiente tiene hijos
	      /*********** bucle **************************************/
	      $dato=$this->mostrarTodo("padre=".$f['idvorganigrama']);
	      if (count($dato)>0){
	      	$acciones=$agregar;// en caso de tener hijos solo se muestra el boton agregar
	    	echo '<li ><a class="ornombre">'.$f["nombre"].'<br>'.$f["paterno"].' '.$f["materno"].'</a><br><span class="orcargo">'.$f['ncargo'].'</span>'.$acciones;
	    	//realizamos el bucle llamando a la misma funcion
	      	$this->bucleOrgConfig($f['idvorganigrama']);
	      }
	      else{//si no tiene hijos revisar si su cargo es asesor
	      	if ($f['ncargo']=='ASESOR') {//si su cargo es asesor. Ya no puede agregar
	    		$acciones=$eliminar;
	    	}
	    	else{//si no es asesor puede->
	      		$acciones=$agregar.$eliminar;
	    	}
	    	echo '<li ><a class="ornombre">'.$f["nombre"].'<br>'.$f["paterno"].' '.$f["materno"].'</a><br><span class="orcargo">'.$f['ncargo'].'</span>'.$acciones;
	      }
	      /*********************************************************/
	      echo '</li>';
	    }
	    echo '</ul>';
	}
	/************* funcion para organigrama *****************************/
	function insertaOrg($Cod,$idorgdetalle,$idorganigrama){
		$where='padre='.$Cod;
	    foreach($this->mostrarTodo($where) as $f)
	    {
	    	$data=array(
				"padre"=>$idorgdetalle,
				"idadmorgani"=>$idorganigrama,
				"idadmejecutivo"=>$f['idadmejecutivo'],
				"idcargo"=>$f['idcargo']
			);
			$this->insertar($data);
			$dorgDet=$this->mostrarUltimo("padre=".$idorgdetalle." and idadmorgani=".$idorganigrama." and idadmejecutivo=".$f['idadmejecutivo']);
			$idorgdeta=$dorgDet['idadmorganidet'];
			/*********** bucle ***************************************/
			$dato=$this->mostrarTodo("padre=".$f['idadmorganidet']);
			if (count($dato)>0)$this->insertaOrg($f['idadmorganidet'],$idorgdeta,$idorganigrama);
			/*********************************************************/
	    }
	}
	function nroPlanilla($fecha){
		$where='padre='.$Cod;
        echo '<ul>';
	    foreach($this->mostrarTodo($where) as $f)
	    {
	      echo '<li ><a class="ornombre">'.$f["nombre"].'<br>'.$f["paterno"].' '.$f["materno"].'</a><br><span class="orcargo">'.$f['ncargo'].'</span>';
	      //revisar si el siguiente tiene hijos
	      /*********** bucle **************************************/
	      $dato=$this->mostrarTodo("padre=".$f['idvorganigrama']);
	      if (count($dato)>0)$this->bucleOrg($f['idvorganigrama']);
	      /*********************************************************/
	      echo '</li>';
	    }
	    echo '</ul>';
	}
}
?>
