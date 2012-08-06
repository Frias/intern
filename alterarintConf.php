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
    <title>.:: Internamentos ::.</title>
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
                        menuAdmin("internamento");
					}else{ //Senão aparece o menuTopo apenas com permissões limitadas
						require('menuTopo.php');
                        menuTopo("internamento");
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
									$codInt_tmp=$_POST['codint'];
									$obs_tmp=$_POST['obs'];
									if ($codInt_tmp == NULL) {
									echo "<br>** Especifique um utente **<br>";
									}
									else{
									$sql="select t_internamentos.obs as obs, t_cama.codCama as codCama, ncama, codQ, codInt, t_utentes.codUt as codUt, t_medicos.codMed as codMed, datahoraentrada, datahorasaida, vis,  t_medicos.nome as mnome, t_utentes.nome as unome, inome from t_cama, t_internamentos, t_medicos, t_utentes, t_quartos, t_serv_int where t_internamentos.codUt=t_utentes.codUt and t_internamentos.codMed=t_medicos.codMed and t_internamentos.codCama=t_cama.codCama and t_quartos.codQuar=t_cama.codQ and codS=codServInt and codInt = $codInt_tmp";
									$verPerfInt = mysqli_query ($cn,$sql);
									$count = mysqli_num_rows($verPerfInt);
									if ($count == 0) {
									echo "<br>** Internamento inexistente **<br>";
									}
									else { 
										while ($dad=mysqli_fetch_assoc($verPerfInt)) {
											$saida=$dad["datahorasaida"];
											}
										if ($saida!="0000-00-00 00:00:00"){
												echo "<br>** O utente já teve alta **<br>";
											}
										else{
                                    $sql="UPDATE t_internamentos SET obs='$obs_tmp' where codInt=$codInt_tmp";
                                    $resul=mysqli_query($cn,$sql);
                                    mysqli_free_result($resultado);
                                    header("location:perfilInt.php?codint=$codInt_tmp");
										
									
									
                                    }
                                    }
                                    }
                                    ?>
                                    
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
	mysqli_close($cn); 

}
?>