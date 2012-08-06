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
    <title>.:: Visitantes ::.</title>
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
                        menuAdmin("visitantes");
					}else{ //Senão aparece o menuTopo apenas com permissões limitadas
						require('menuTopo.php');
                        menuTopo("visitantes");
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
									$csai=$_GET['codvis'];
									if ($csai == NULL) {
									echo "<br>** Especifique uma visita **<br>";
									}
									else{
									$sql="select codVisit, codCartao, nome, vnome, t_visitantes.tipoID as vtipoID, t_visitantes.numID as vnumID, t_visitantes.datahoraentrada as entrada, t_visitantes.datahorasaida as saida, t_visitantes.codInt as codInt from t_utentes, t_internamentos, t_visitantes where t_utentes.codUt=t_internamentos.codUt and t_internamentos.codInt=t_visitantes.codInt and codVisit=$csai";
									$verPerfVis = mysqli_query ($cn,$sql);
									$count = mysqli_num_rows($verPerfVis);
									if ($count == 0) {
									echo "<br>** Visita inexistente **<br>";
									}
									else { 
										while ($registo=mysqli_fetch_assoc($verPerfVis)) {
											$codvis=$registo["codVisit"]; //guarda os dados do utilizador 
                                            $vnome=$registo["vnome"];
                                            $tipoID=$registo["vtipoID"];
                                            $numID=$registo["vnumID"];
                                            $entrada=$registo["entrada"];
                                            $saida=$registo["saida"];
                                            $nome=$registo["nome"];
											$cartao=$registo["codCartao"];
                                            $codint=$registo["codInt"];
											}
										if ($saida!="0000-00-00 00:00:00"){
												echo "<br>** O visitante já saiu **<br>";
											}
										else{
										
									?>
									<table width="100%" border="0" cellspacing="1" cellpadding="1">
									<tr><td id="textoCabTabCorpo" colspan="9">Dar saida de <?php echo $vnome ?> </td></tr>
									<tr><td colspan="9"><div class="adicReg" align="left"><a href="visitantes.php">Voltar</a></div></td></tr>
									<form id="formRegUt" name="formRegUt" method="post" action="saidaConf.php">        
                                            <tr>
                                              <td width="300" class="tabFormEsq">Vis. Num.:</td>
                                              <td width="300">
                                              <input type="text" name="codvis" id="codvis" class="tabFormDir"  value="<?php echo $codvis; ?>" readonly="readonly"/></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Nome Completo:</td>
                                              <td width="300">
                                              <input type="text" name="vnome" id="vnome" class="tabFormDir" value="<?php echo $vnome; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Tipo de ID:</td>
                                              <td>
                                                 <input type="text" name="tipoID" id="tipoID" class="tabFormDir" value="<?php echo $tipoID; ?>" readonly="readonly" />
                                              </td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Numero de ID:</td>
                                              <td>
                                              <input type="text" name="numID" id="numID" class="tabFormDir" value="<?php echo $numID; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Nome do Utente:</td>
                                              <td width="300">
                                              <input type="text" name="nome" id="nome" class="tabFormDir" value="<?php echo $nome; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Entrada:</td>
                                              <td>
												<input type="text" name="entrada" id="entrada" class="tabFormDir" value="<?php echo $entrada; ?>" readonly="readonly" />
                                              </td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Cartão:</td>
                                              <td>
                                              <input type="text" name="cartao" id="cartao" class="tabFormDir"  value="<?php echo $cartao; ?>" readonly="readonly"/></td>
                                            </tr>  
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td><input type="submit" name="vsair" id="vsair" value="Dar saida" class="tabFormDir" /></td>
                                            </tr>
                                            <tr bgcolor="#CCCCCC">
                                              <td class="tabFormEsq"><div class="msgErro"<b>Nota:</b></div></td>			
                                              <td colspan="2" class="msgErro">&nbsp;&nbsp; Pedir o cartão ao visitante</td>
                                            </tr>                                            
                                        </form>
									

									</table>                                                                    
                                    </td>
                                    <?php 
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