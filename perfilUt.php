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
									$codUt_tmp=$_GET['codut'];
									if ($codUt_tmp == NULL) {
									echo "<br>** Especifique um utente **<br>";
									}
									else{
									$sql="select * from t_utentes where codUt = $codUt_tmp";
									$verPerfUt = mysqli_query ($cn,$sql);
									$count = mysqli_num_rows($verPerfUt);
									if ($count == 0) {
									echo "<br>** Utente inexistente **<br>";
									}
									else { 
										while ($dad=mysqli_fetch_assoc($verPerfUt)) {
											$nomeU=$dad["nome"];
											$tipoid=$dad["tipoID"];
											$numid=$dad["numID"];
											$tipout=$dad["tipoCartUtente"];
											$numut=$dad["numCartUtente"];
											$sangue=$dad["tipoSangue"];
											$mor=$dad["morada"];
											$con=$dad["contacto"];
											$obs=$dad["obs"];
											$int=$dad["intr"];
											}
										
                                                    if ($int==1){
                                                    	$sql="select * from t_internamentos where datahorasaida ='0000-00-00 00:00:00' and codUt=$codUt_tmp";
                                                    	$got=mysqli_query($cn,$sql);
                                                    	while ($in=mysqli_fetch_assoc($got)){
                                                    	$cint=$in["codInt"];
                                                    	}
                                                    	$intr="<a href='perfilInt.php?codint=$cint'>Internado</a>";
                                                    }
                                                    else{
                                                    	$intr="<a href='internar.php?codut=$cod'>Internar</a>";
                                                    }
									?>
									<table width="100%" border="0" cellspacing="1" cellpadding="1">
									<tr><td id="textoCabTabCorpo" colspan="9">Perfil de <?php echo $nomeU ?> </td></tr>
									<tr><td colspan="9"><div class="adicReg" align="left"><a href="utentes.php">Voltar</a></div></td></tr>
									<tr>
									<td class="cabTabperfUtil1" width="180">Nome Completo</td>
									<td class="cabTabperfUtil2"><?php echo $nomeU ?></td>
									</tr>
									<tr>
									<td class="cabTabperfUtil1" width="180"><?php echo $tipoid ?></td>
									<td class="cabTabperfUtil2"><?php echo $numid ?></td>
									</tr>
									<tr>
									<td class="cabTabperfUtil1" width="180"><?php echo $tipout ?></td>
									<td class="cabTabperfUtil2"><?php echo $numut ?></td>
									</tr>
									<tr>
									<td class="cabTabperfUtil1" width="180">Tipo de Sangue</td>
									<td class="cabTabperfUtil2"><?php echo $sangue ?></td>
									</tr>
									<tr>
									<td class="cabTabperfUtil1" width="180">Morada</td>
									<td class="cabTabperfUtil2"><?php echo $mor ?></td>
									</tr>
									<tr>
									<td class="cabTabperfUtil1" width="180">Contacto</td>
									<td class="cabTabperfUtil2"><?php echo $con ?></td>
									</tr>
									<tr>
									<td class="cabTabperfUtil1" width="180">Obs</td>
									<td class="cabTabperfUtil2"><?php echo $obs ?></td>
									</tr>
									<tr><td colspan="5"><div class="adicReg" align="left"><a href="alterarUtente.php?codEditar=<?php echo $codUt_tmp ?>">Alterar</a></div></td><td colspan="5"><div class="adicReg" align="right"><?php echo $intr ?></div></td></tr>

									</table>                                                                    
                                    </td>
                                    <?php 
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