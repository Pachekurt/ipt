<?php
	$ruta="../../../../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/personaplan.php");
	$personaplan=new personaplan;
	include_once($ruta."class/admplan.php");
	$admplan=new admplan;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);

	session_start();
    /*********** actualiza contrato  ***********/
    ?>
    	<table border="1" cellpadding="5" align="center">
			<thead>
				<th>Contrato</th>
				<th>Pagado</th>
				<th>estado</th>
				<th>PLAN</th>
				<th>Pago Inicial</th>
				<th>Diferencia</th>
			</thead>
			<tbody>
    <?php
    foreach($admcontrato->mostrarTodo("estado<>60 and estado<>61 and estado<>64 and estado<>68 and estado<>65 and estado<>66 and estado<>67") as $f){
    	if ($f['idpersonaplan']==0) {
    		$dordet=$personaplan->mostrarUltimo("idcontrato=".$f['idadmcontrato']);
    		$dplan=$admplan->muestra($dordet['idadmplan']);
    		$diferencia=$dplan['pagoinicial']-$f['pagado'];
    		//echo "Cont. ".$f['nrocontrato']." pagado: ".$f['pagado']." estado: ".$f['estado']." PLAN: ".$dplan['nombre']." INICIAL: ".$dplan['pagoinicial']." <br>";
    		if ($diferencia<0) {
    			$diferencia=0;
    		}
    		?>
    			
    					<tr>
    						<td><?php echo $f['nrocontrato'] ?></td>
    						<td><?php echo $f['pagado'] ?></td>
    						<td><?php echo $f['estado'] ?></td>
    						<td><?php echo $dplan['nombre']." ".$dplan['inversion'] ?></td>
    						<td><?php echo $dplan['pagoinicial'] ?></td>
    						<td><?php echo $diferencia ?></td>
    					</tr>
    				
    		<?php

    		$valores=array(
				"idpersonaplan"=>$dordet['idpersonaplan'],
				"abono"=>"'$diferencia'",
			);
			$admcontrato->actualizar($valores,$f['idadmcontrato']);
    	}
    }
/*
    foreach($personaplan->mostrarTodo("") as $f){
    	$idpersonaplan=$f['idpersonaplan'];
    	$dcont=$admcontrato->muestra($f['idcontrato']);
    	if ($dcont['idpersonaplan']==0) {
    		echo "Cont. ".$dcont['nrocontrato']."<br>";
    		$valores=array(
				"idpersonaplan"=>"'$idpersonaplan'"
			);
			//$admcontrato->actualizar($valores,$f['idcontrato']);
    	}
    }
    */
?>
</tbody>
    			</table>