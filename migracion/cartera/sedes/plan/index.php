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
                <th>PLAN</th>
                <th>Inversion</th>
                <th>Pago Inicial</th>
                <th>Mensulaidad</th>
                <th>Cuotas</th>
                <th>Primer Saldo</th>
                <th>Sum Pagado</th>
                <th>Saldo Maestro</th>
                <th>Saldo Calculado</th>
                 <th>DIferencia</th>
			</thead>
			<tbody>
                <?php
                $i=0;
                foreach($migcartera->mostrarTodo("migrado<>1 and idplan>0") as $f){
                    if ($f['sede']==2) {
                        $sede= "ORURO";
                    }elseif ($f['sede']==3) {
                        $sede=  "Sucre";
                    }
                    $dp=$admplan->muestra($f['idplan']);
                    $monto=$f['plan']*$f['cuota'];
                    // suma detalle
                    $sum=$migdetalle->sql("SELECT cuenta, sum(montoBs) as monto,sum(descuento) as descuento FROM duartema_nacional.migdetalle where cuenta=".$f['cuenta']." group by cuenta");
                    $sum= array_shift($sum);
                    //diferencia
                    $MontoSumado=$sum['monto']+$sum['descuento'];
                    //saca diferencia
                    $estilo="";
                    $SaldoSistema=$dp['inversion']-$f['pagadoprod']-$MontoSumado;
                    $diferencia=$f['saldo']-$SaldoSistema;
                    $estiloPlan="";
                    if ($dp['mensualidad']==760 && $dp['cuotas']==12) {
                        $estiloPlan="background-color: green;";
                    }
                        $i++;
                    
                    $dpri=$migdetalle->mostrarPrimero("cuenta=".$f['cuenta']);

                    if ($diferencia !=0) {
                        $estilo="background-color: red;";
                        /***/
                    }else{
                        
                        $valores=array(
                            "migrado"=>1,
                        );
                        $migcartera->actualizar($valores,$f['idmigcartera']);
                    }//plan

                    ?>
                            <tr style="<?php echo $estilo ?>" align="center">
                                <td><?php echo $i."-".$f['idmigcartera'] ?></td>
                                <td><?php echo $sede ?></td>
                                <td><?php echo $f['cuenta'] ?></td>
                                <td><?php echo $f['matricula'] ?></td>
                                <td style="<?php echo $estiloPlan ?>"><?php echo $dp['nombre'] ?></td>
                                <td><?php echo $dp['inversion'] ?></td>
                                <td><?php echo $dp['pagoinicial'];?></td> 
                                <td><?php echo $dp['mensualidad']; ?></td>  
                                <td><?php echo $dp['cuotas'] ?></td>
                                <td><?php echo $dpri['saldoAnterior']; ?></td>
                                <td><?php echo $MontoSumado; ?></td>
                                <td><?php echo $f['saldo'] ?></td>
                                <td><?php echo $SaldoSistema ?></td>
                                <td><?php echo $diferencia ?></td>
                            </tr>
                        <?php
                    
                    
                }
                ?>
            </tbody>
        </table>