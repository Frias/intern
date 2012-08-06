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
						
					$codUt_tmp=$_GET['codElim'];//Guarda o código de utilizador na variável $codUtil_tmp que vem por URL				
					$sql="SELECT * FROM t_utentes WHERE codUt=$codUt_tmp"; //variável com comando SQL que selecciona todos os dados do utilizador a ser alterado
				$verResEdit = mysqli_query ($cn,$sql); //guarda os dados vindos da tabela
				if ($verResEdit) { //verifica se a variável tem conteúdo
					while ($regEdit=mysqli_fetch_assoc($verResEdit)) { //Imprime o conteúdo do array
							$cod=$regEdit["codUt"]; //guarda os dados do utilizador 
							$nome=$regEdit["nome"];
							$tipoID=$regEdit["tipoID"];
							$numID=$regEdit["numID"];
							$tipoCartUt=$regEdit["tipoCartUtente"];
							$numCart=$regEdit["numCartUtente"];
							$tipoSangue=$regEdit["tipoSangue"];														
							$morada=$regEdit["morada"];																
							$contacto=$regEdit["contacto"];	
							$obs=$regEdit["obs"];	
						}
					}
					include('funcUtente.php'); //inclusão da página com algumas funções referentes a dados do Utente como tipo de sangue e cartão de utente						
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
                                        <table width="600" border="0" cellspacing="1" cellpadding="1" align="center">
                                            <tr><td id="textoCabTabCorpo" colspan="9">Alterar Dados do Utente</td></tr>
											<tr><td colspan="9"><div class="adicReg" align="left"><a href="utentes.php">Voltar</a></div></td></tr>
                                            <form id="formRegUt" name="formRegUt" method="post" action="eliminarUtenteConf.php">        
                                            <tr>
                                              <td width="300" class="tabFormEsq">Cod.:</td>
                                              <td width="300">
                                              <input type="text" name="cod" id="cod" class="tabFormDir"  value="<?php echo $codUt_tmp; ?>" readonly="readonly"/></td>
                                            </tr
                                            ><tr>
                                              <td width="300" class="tabFormEsq">Nome Completo:</td>
                                              <td width="300">
                                              <input type="text" name="nome" id="nome" class="tabFormDir" value="<?php echo $nome; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Tipo ID:</td>
                                              <td>
                                                 <input type="text" name="tipoID" id="tipoID" class="tabFormDir" value="<?php echo $tipoID; ?>" readonly="readonly" />
                                              </td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Num.º ID:</td>
                                              <td>
                                              <input type="text" name="numID" id="numID" class="tabFormDir" value="<?php echo $numID; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Tipo Cartão:</td>
                                              <td>
												<input type="text" name="tipoCart" id="tipoCart" class="tabFormDir" value="<?php echo $tipoCartUt; ?>" readonly="readonly" />
                                              </td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Num.º Cartão:</td>
                                              <td>
                                              <input type="text" name="numCartUt" id="numCartUt" class="tabFormDir"  value="<?php echo $numCart; ?>" readonly="readonly"/></td>
                                            </tr>  
                                            <tr>
                                              <td class="tabFormEsq">Tipo Sangue:</td>
                                              <td>
                                                <input type="text" name="tipoSangue" id="tipoSangue" class="tabFormDir"  value="<?php echo $tipoSangue; ?>" readonly="readonly"/>
                                              </td>
                                            </tr>                                                                                      
                                            <tr>
                                              <td class="tabFormEsq">Morada:</td>
                                              <td><textarea name="morada" cols="40" rows="10" class="tabFormDir" id="morada" readonly="readonly"> <?php echo $morada; ?> </textarea></td>
                                            </tr>
											<tr>
                                              <td class="tabFormEsq">Contactos:</td>
                                              <td><textarea name="contacto" cols="40" rows="10" readonly="readonly" class="tabFormDir" id="contacto"><?php echo $contacto; ?></textarea></td>
                                            </tr>                                              
                                            <tr>
                                              <td class="tabFormEsq">Observações:</td>
                                              <td><textarea name="obs" cols="40" rows="10" readonly="readonly" class="tabFormDir" id="obs"><?php echo $obs; ?></textarea>	
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td><input type="submit" name="eliminar" id="eliminar" value="Eliminar" class="tabFormDir" /></td>
                                            </tr>
                                            <tr bgcolor="#CCCCCC">
                                              <td class="tabFormEsq"><div class="msgErro"<b>ATENÇÂO:</b></div></td>			
                                              <td colspan="2" class="msgErro">&nbsp;&nbsp; Confirma a eliminação destes dados?</td>
                                            </tr>                                            
                                        </form>                                              			
                                      </table>                                            
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