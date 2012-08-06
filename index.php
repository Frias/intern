<?php
session_start(); //inicia a sessão
define("ADMIN",$_SESSION['name']); //Recebe o código e nome do utilizador e tipo de utilizador e guarda na constante ADMIN
if(!isset($_SESSION['name'])){ //Informa se a variável não foi iniciada
	header("location:login.php"); // redireciona para a página index.php no caso de login errado
}
else {
	include_once('conexao.php'); //Se a variável foi iniciada, executa a página de administração
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
                    if($tipoU_tmp=="Administrador"){ //Se tipo de utilizador igual a Administrador, aparece o menuAdmin com todas as funcionalidades e permissões
                        require('menuAdmin.php');
                        menuAdmin("indexLogin");
                    }else{				 //Senão aparece o menuTopo apenas com permissões limitadas
                        require('menuTopo.php');
                        menuTopo("indexLogin");
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
                    					if($tipoU_tmp=="Administrador"){ //Se tipo de utilizador igual a Administrador, aparece o menu de imagens com todas as funcionalidades e permissões imprimindo a tabela a seguir                                     
										?>
                                        <!-- Tabela para Administradores-->
                                        <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
                                        	<tr>
                                            	<td colspan="3" id="textoCabTabCorpo">
                                                	Menu
                                                </td>
                                            </tr>
                                          <tr>
                                            <td width="200" id="menuIL" align="center"><a href="utentes.php"><img src="imagens/utentesHover.png" width="150" alt="Utentes"/><br />Utentes</a></td>
                                            <td width="200" id="menuIL" align="center"><a href="visitantes.php"><img src="imagens/visitantesHover.png" width="150" alt="Visitantes"/><br />Visitantes</a></td>
                                            <td width="200" id="menuIL" align="center"><a href="medicos.php"><img src="imagens/medicosHover.png" width="150" alt="Médicos"/><br />Médicos</a></td>
                                          </tr>
                                          <tr>
                                          	<td>&nbsp;</td>
                                          	<td>&nbsp;</td>
                                          	<td>&nbsp;</td>                                                                                      
                                          </tr>    
                                          <tr>
                                            <td width="200" id="menuIL" align="center"><a href="utilizadores.php"><img src="imagens/utilizadoresHover.png" width="150" alt="Utilizadores"/><br />Utilizadores</a></td>
                                            <td width="200" id="menuIL" align="center"><a href="outros.php"><img src="imagens/outrosHover.png" width="150" alt="Outros"/><br />Outros</a></td>
                                            <td width="200" id="menuIL" align="center"><a href="sair.php"><img src="imagens/sairHover.png" width="150" alt="Sair"/><br />Sair</a></td>
                                          </tr>
                                        </table>  
                                         <!-- Fim da Tabela para Administradores-->
									<?php
									}else{ //Se tipo de utilizador igual a Normal, aparece o menu de imagens com as funcionalidades e permissões limitadas imprimindo a tabela a seguir
                                    ?>  
                                    	 <!-- Tabela para Utilizadores normais-->  
										<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
                                        	<tr>
                                            	<td colspan="3" id="textoCabTabCorpo">
                                                	Menu
                                                </td>
                                            </tr>
                                          <tr>
                                            <td width="200" id="menuIL" align="center"><a href="utentes.php"><img src="imagens/utentesHover.png" width="150" alt="Utentes"/><br />Utentes</a></td>
                                            <td width="200" id="menuIL" align="center"><a href="visitantes.php"><img src="imagens/visitantesHover.png" width="150" alt="Visitantes"/><br />Visitantes</a></td>
                                            <td width="200" id="menuIL" align="center"><a href="sair.php"><img src="imagens/sairHover.png" width="150" alt="Sair"/><br />Sair</a></td>
                                          </tr>
                                        </table>  
                                         <!-- Fim da tabela para utilizadores normais-->                                   
                                    <?php
									} //fim do else
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