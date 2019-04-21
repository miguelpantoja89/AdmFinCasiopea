<?php
ob_start();
?>
<style>
<!--
#encabezado {padding:5px 0; border-bottom: 1px solid; width:100%;margin:auto;}
#encabezado .fila #col_1 {width: 15%; text-align: left;}
#encabezado .fila #col_2 {text-align:left; width: 65%}

#encabezado .fila #col_2 #span1{font-size: 15px;}
#encabezado .fila #col_2 #span2{font-size: 15px; color: #ccc;}

#footer {padding-bottom:5px 0;border-top: 2px solid #46d; width:80%; margin:auto;}
#footer .fila td {text-align:center; width:100%;}
#footer .fila td span {font-size: 10px; color: #000;}

#fecha {margin-top:100px; width:100%;}
#fecha tr td {text-align: right; width:100%;}

#central {margin-top:20px; width:100%;}
#central tr td {padding: 0px; text-align:left; width:100%;}

#datos { margin:auto; width:100%;}
#datos td{border:1px solid black;}
-->
</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="20mm">
   
    <page_header>
        <table id="encabezado">
            <tr class="fila">
                <td id="col_1" >
                <img src="../../imagenes/icono.jpg" width="80" height=80>
                </td>
                <td id="col_2">
                    <span id="span1">CONTROL DE INVENTARIO DE EQUIPO DE PROTECCIÓN PERSONAL </span>
                    <br>
                    <span id="span2">ALMACÉN </span>
                </td>
                <td><br></td>
                <td><br></td>
            </tr>
        </table>
    </page_header>
        
    <page_footer> 
        <table id="footer">
            <tr class="fila">
                <td>
                    <span>CONTROL DE INVENTARIO DE EQUIPO DE PROTECCIÓN PERSONAL</span>
                </td>
            </tr>
        </table>
    </page_footer>
    
    <table id="fecha">
        <tr class="fila">
            <td>
            <?php
$fecha = date('Y-m-j H:i:s'); //inicializo la fecha con la hora

$nuevafecha = strtotime ( '-7 hour' , strtotime ( $fecha ) ) ;

$nuevafecha = date ( 'j/m/Y  H:i:s' , $nuevafecha );

            echo $nuevafecha." hrs<br>";
            $dia = date("j"); 
            $mes = date("n"); 
            $anio = date("Y"); 
            $m="";
            switch ($mes) {
                case 1:$m="Enero"; break;
                case 2:$m="Febrero"; break;
                case 3:$m="Marzo"; break;
                case 4:$m="Abril"; break;
                case 5:$m="Mayo"; break;
                case 6:$m="Junio"; break;
                case 7:$m="Julio"; break;
                case 8:$m="Agosto"; break;
                case 9:$m="Septiembre"; break;
                case 10:$m="Octubre"; break;
                case 11:$m="Noviembre"; break;
                case 12:$m="Diciembre"; break;
            }
            echo $dia." de ".$m." de ".$anio;
            ?>
            </td>
        </tr>
    </table>
    

    <table id="central">
        <tr class="fila">
            <td align="center">
              <b> REPORTE DE INVENTARIO </b>
            </td>
        </tr>       
        <tr>
            <td >
             <table id="datos" border >
                <tr style="height:10px" class="fila">
                    <td style="width:10%;height:auto;" align="center"><b>CLAVE</b></td>
                    <td style="width:40%;height:auto;" align="center"><b>DESCRIPCIÓN</b></td>
                    <td style="width:10%;height:auto;" align="center"><b>STOCK</b></td>
                    <td style="width:10%;height:auto;" align="center"><b>MÍNIMO</b></td>
                    <td style="width:15%;height:auto;" align="center"><b>CANTIDAD</b></td>
                    <td style="width:15%;height:auto;" align="center"><b>ALMACEN</b></td>
                </tr>
                <?php
                    $con = mysql_connect("localhost","root","");
                mysql_select_db("crudisrael", $con);
                $result = mysql_query("SELECT * FROM producto;");
                $i=0;
                while($row=mysql_fetch_array($result)){
                    $i++;
                    $s=$row['Stock'];
                    $m=$row['StockSem'];
                    $c=$m-$s;
                ?>
                 <tr style="height:10px" class="fila">
                    <td style="width:10%;height:auto;" align="center"><?php echo $row['Clave'];?></td>
                    <td style="width:40%;height:auto;"><?php echo $row['Descripcion'];?></td>
                    <td style="width:10%;height:auto;" align="center"><?php echo $s;?></td>
                    <td style="width:10%;height:auto;" align="center"><?php echo $m;?></td>
                    <td style="width:15%;height:auto;" align="center"><?php if($c>0){echo $c;}else{ echo "0"; } ?></td>
                    <td style="width:15%;height:auto;" align="center"><?php if($s<$m){ echo "<b>COMPRAR</b>"; }else{
                        echo "ALMACÉN"; }
                   ?></td>
                   

                </tr>
                <?php
                }
                ?>
                <tr style="height:10px" class="fila">
                    <td colspan="6"  align="right"><?php echo "<b>Cantidad de Productos: </b>".$i; ?></td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td>
            </td>
        </tr>
    </table>
</page>
<?php
    $content = ob_get_clean();
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', 3); 
        $html2pdf->pdf->SetDisplayMode('fullpage'); 
        $html2pdf->writeHTML($content);
        $html2pdf->Output('calificaciones.pdf'); 
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
