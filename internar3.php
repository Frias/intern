<?php
session_start(); //inicia a sessão
define("ADMIN",$_SESSION['name']); //Recebe o código e nome do utilizador e tipo de utilizador e guarda na constante ADMIN
if(!isset($_SESSION['name'])){ //Informa se a variável não foi iniciada
	header("location:login.php"); // redireciona para a página index.php no caso de login errado
}
else { //Se a variável foi iniciada, executa a página de administração
	include_once('conexao.php'); 
	list($codU_tmp, $userU_tmp, $tipoU_tmp) = explode("-", ADMIN); //Separa informação da $_SESSION['name'] pelo traço, ex. 1-Pedro-Administrador
	
//Imprime tabela de utilizadoresa
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <link href="http://fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css" />
    <link href="estilosCSS.css" rel="stylesheet" type="text/css" media="all" /><!-- importa os estilos do ficheiro estilosCSS.css-->    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>.:: Utentes ::.</title>
    </head>
    <body>
    <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td colspan="3" id="bodyCab">
            <table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td height="100" id="bodyCabFont">Administração<br />EBMG02</td>
              </tr>
              <tr>
                <td height="33"><font color="#FFFFFF"><b>Utilizador:</b> <?php echo $userU_tmp; ?></font></td>
              </tr>              
              <tr>
                <td height="68" id="textoCabTab">
                    <?php
                    if($tipoU_tmp=="Administrador"){ //Se tipo de utilizador é igual a Administrador, aparece o menuAdmin com todas as funcionalidades e permissões e abre a página utilizadores.php caso contrário, não permite que utilizadores normais acessem a esta página
                        require('menuAdmin.php');
                        menuAdmin("utentes");
					}else{ //Senão aparece o menuTopo apenas com permissões limitadas
						require('menuTopo.php');
                        menuTopo("utentes");
						}
                    ?>
                </td>
              </tr>
              <tr>
                <td align="center">
                	<table border="0" cellspacing="0" cellpadding="0">
               			<tr>
                        	<td id="corpoTop" colspan="3"></td>
                              </tr>
                              <tr>
                                <td width="5" bgcolor="#FFFFFF"></td>                              
                                    <td bgcolor="#FFFFFF" align="center">
                                    <?php
                                    $codut=$_POST["codut"];
                                    $codmed=$_POST["med"];
                                    $nome=$_POST["nome"];
                                    $serv=$_POST["serv"];
                                    $cama=$_POST["cama"];
                                    $visit=$_POST["visit"];
                                    $obs=$_POST["obs"];
                                    if ($visit=="Yes"){
                                    $vis=1;
                                    }
                                    else{
                                    $vis=0;
                                    }
                                    $sql="select * from t_medicos, t_especialidade where codEsp=esp and codMed=$codmed";
                                    $resm=mysqli_query($cn,$sql);
                                    $sql="SELECT * FROM t_serv_int where codServInt=$serv";
                                    $ress=mysqli_query($cn,$sql);
                                    $sql="SELECT * FROM t_serv_int, t_quartos, t_cama where codServint=codS and codQuar=codQ and codServint=$serv";
                                    $res=mysqli_query($cn,$sql);
                                    $sql="SELECT * FROM t_cama WHERE codCama=$cama";
                                    $resc=mysqli_query($cn,$sql);
                                    while ($cam=mysqli_fetch_assoc($resc)) { 
                                           $codcama=$cam["codCama"];
                                           $codq=$cam["codQ"];
                                           $oc=$cam["oc"];
                                           }
                                    if ($oc==1){
                                    	echo "<br>** Cama ocupada, tente novamente **<br>";
                                    }
                                    else{
                                    $dataAtual=date('Y-m-d H:i:s');
                                    $sql="UPDATE t_cama SET oc=1 WHERE codCama=$cama";
                                    $resul=mysqli_query($cn,$sql);
                                    mysqli_free_result($resultado);
                                    $sql="UPDATE t_utentes SET intr=1 where codUt=$codut";
                                    $resul=mysqli_query($cn,$sql);
                                    mysqli_free_result($resultado);
                                    $sql="INSERT INTO t_internamentos(codUt, codMed, datahoraentrada, codCama, obs, vis) VALUES ('$codut', '$codmed', '$dataAtual', '$cama', '$obs', '$vis')";
                                    $resul=mysqli_query($cn,$sql);
                                    mysqli_free_result($resultado);
                                    header("location:internamentos.php");
                                    }
                                    ?>
                                        <table width="600" border="0" cellspacing="1" cellpadding="1" align="center">
                                            <tr><td id="textoCabTabCorpo" colspan="9">Internar <?php echo $nome; ?></td></tr>
											<tr><td colspan="9"><div class="adicReg" align="left"><a href="utentes.php">Voltar</a></div></td></tr>
                                            
                                      </table>                                            
                                      <?php 
                                      ?>
                                    </td>
                                <td width="5" bgcolor="#FFFFFF"></td>                                
                              </tr>
                              <tr>
                                <td id="corpoRod" colspan="3"></td>
                              </tr>                       
                    </table>
                </td>
              </tr>       
            </table>
           </td>
      </tr>
      <tr>
          <td id="bodyRod">
            <?php include('rodape.php');?>
          </td>
      </tr>  
    </table>
    
    </body>
    </html>
    </body>
    </html>

<?php
}
?>