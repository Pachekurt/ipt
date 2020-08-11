<?php
	$ruta="../../../";

    include_once($ruta."class/admcontrato.php");
    $admcontrato=new admcontrato;
    include_once($ruta."class/vcontratoplan.php");
    $vcontratoplan=new vcontratoplan;
    include_once($ruta."class/admplan.php");
    $admplan=new admplan;
    include_once($ruta."class/cobcartera.php");
    $cobcartera=new cobcartera;
    include_once($ruta."class/vcartera.php");
    $vcartera=new vcartera;
    include_once($ruta."class/cobcarteradet.php");
    $cobcarteradet=new cobcarteradet;
	include_once($ruta."funciones/funciones.php");
	session_start();
    /*********** actualiza contrato  ***********/
    ?>
    	<table border="1" cellpadding="5" align="center">
			<thead>
                <th>nro</th>
                <th>IDADMPLAN</th>
                <th>CUENTA</th>
                <th>Contrato</th>
                <th>SALDO MAESTRO</th>
				<th>SALDO DETALLE</th>
                <th>DIF</th>
			</thead>
			<tbody>
    <?php
    $i=0;
    foreach($vcartera->mostrarTodo("saldo>0") as $f){
        
    	$i++;
        $dcont=$admcontrato->muestra($f['idcontrato']);
        $dcp=$vcontratoplan->muestra($f['idcontrato']);
        ?>
        <tr style="<?php echo $estilo ?>" align="center">
            <td><?php echo $i." - ".$f['idvcartera'] ?></td>
            <td><?php echo $dcp['idadmplan'] ?></td>
            <td><?php echo $dcont['cuenta'] ?></td>
            <td><?php echo $dcont['nrocontrato'] ?></td>
            <td><?php echo $f['saldo'] ?></td>
            <td>
                <?php
                    $pagado=0;
                    foreach($cobcarteradet->mostrarTodo("idcartera=".$f['idvcartera']) as $g){                                    
                        $pagado=$pagado+$g['monto']+$g['descuento'];
                    }
                    echo $pagado; 
                    $SaldoSistema=$f['monto']-$f['pagadoprod']-$pagado;
                    echo " - ".$SaldoSistema;
                ?>   
            </td> 
            <?php 
                $dif=$f['saldo']-$SaldoSistema;
                if ($dif!=0) {
                    $estilo11="background-color: green;";
                }
                else{
                    $estilo11="";
                }
            ?> 
            <td style="<?php echo $estilo11 ?>"><?php echo $dif ?></td>     
        </tr>
        <?php
    }

?>
</tbody>
    			</table>