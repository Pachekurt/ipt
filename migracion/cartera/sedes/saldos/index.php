<?php
	$ruta="../../../../";
	include_once($ruta."class/migcartera.php");
	$migcartera=new migcartera;

    include_once($ruta."class/migdetalle.php");
    $migdetalle=new migdetalle;

    include_once($ruta."class/admcontrato.php");
    $admcontrato=new admcontrato;
    include_once($ruta."class/vcontratoplan.php");
    $vcontratoplan=new vcontratoplan;
    include_once($ruta."class/admplan.php");
    $admplan=new admplan;
	include_once($ruta."funciones/funciones.php");
	session_start();
    /*********** actualiza contrato  ***********/
    ?>
    	<table border="1" cellpadding="5" align="center">
			<thead>
                <th>nro</th>
                <th>Sede</th>
                <th>CUENTA</th>
                <th>Contrato</th>
                <th>Plazo</th>
                <th>Cuota</th>
                <th>Monto</th>
                <th>Sumatoria Det</th>
                <th>Saldo Ma</th>
                <th>Diferencia</th>
                <th>Plan</th>
			</thead>
			<tbody>
                <?php
                $i=0;
                foreach($migcartera->mostrarTodo("migrado<>1 and idplan=0") as $f){
                    if ($f['sede']==2) {
                        $sede= "ORURO";
                    }elseif ($f['sede']==3) {
                        $sede=  "Sucre";
                    }
                    $monto=$f['plan']*$f['cuota'];
                    // suma detalle
                    $sum=$migdetalle->sql("SELECT cuenta, sum(montoBs) as monto,sum(descuento) as descuento FROM duartema_nacional.migdetalle where cuenta=".$f['cuenta']." group by cuenta");
                    $sum= array_shift($sum);
                    //diferencia
                    $MontoSumado=$monto-$sum['monto']-$sum['descuento'];
                    //saca diferencia
                    $estilo="";
                    $estiloPlan="";
                    $diferencia=$f['saldo']-$MontoSumado;
                    
                    if ($diferencia !=0) {
                        $estilo="background-color: red;";
                        /***/
                    }else{
                        $estilo="";
                        $diferencia=0;
                    }//plan
                    $dplan=$admplan->mostrarTodo("mensualidad=".$f['cuota']." and cuotas=".$f['plan']);
                    /*
                    if (count($dplan)==1) {
                        # code...
                    
                        
                        $dplan= array_shift($dplan);
                        $valores=array(
                            "idplan"=>$dplan['idadmplan'],
                            "pagadoprod"=>"'".$dplan['pagoinicial']."'",
                        );
                        
                        $migcartera->actualizar($valores,$f['idmigcartera']);
                        */
                        $i++;
                    if ($f['plan']==10 && $f['cuota']==890) {
                        $estiloPlan="background-color: green;";
                        
                        //$dplan=$admplan->mostrarPrimero("mensualidad=".$f['cuota']." and cuotas=".$f['plan']);
                        $dplan=$admplan->mostrarPrimero("idadmplan=323");
                        $valores=array(
                            "idplan"=>$dplan['idadmplan'],
                            "pagadoprod"=>"'".$dplan['pagoinicial']."'",
                        );
                        $migcartera->actualizar($valores,$f['idmigcartera']);
                        //*/
                    }
                 ?>
                    <tr align="center">
                        <td><?php echo $i ?></td>
                        <td><?php echo $sede ?></td>
                        <td><?php echo $f['cuenta'] ?></td>
                        <td><?php echo $f['matricula'] ?></td>
                        <td style="<?php echo $estiloPlan ?>"><?php echo $f['plan'] ?></td>
                        <td><?php echo $f['cuota'];?></td> 
                        <td><?php echo $monto; ?></td>  
                        <td><?php echo $sum['monto'] ?></td>
                        <td><?php echo $f['saldo'] ?></td>
                        <td style="<?php echo $estilo ?>" ><?php echo $diferencia ?></td>
                        <td><?php echo count($dplan) ?></td>
                    </tr>
                <?php  
                
                }
                ?>
            </tbody>
        </table>