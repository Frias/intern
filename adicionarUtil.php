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
    <title>.:: Utilizadores ::.</title>
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
                        require_once('menuAdmin.php');
                        menuAdmin("utilizadores");
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
                                        <tr><td id="textoCabTabCorpo" colspan="9">Adicionar Novo Utilizador</td></tr>
                                        <tr><td colspan="9"><div class="adicReg" align="left"><a href="utilizadores.php">Voltar</a></div></td></tr>
                                        <form id="formRegUser" name="formRegUser" method="post" action="adicionarUtilConf.php">        
                                        <tr>
                                          <td width="300" class="tabFormEsq">Nome Completo:</td>
                                          <td width="300">
                                          <input type="text" name="nome" id="nome" class="tabFormDir" /></td>
                                        </tr>
                                        <tr>
                                          <td class="tabFormEsq">Nome de Utilizador:</td>
                                          <td>
                                          <input type="text" name="user" id="user" class="tabFormDir" /></td>
                                        </tr>
                                        <tr>
                                          <td class="tabFormEsq">Palavra passe:</td>
                                          <td>
                                          <input type="password" name="pass" id="pass" class="tabFormDir" /></td>
                                        </tr>
                                        <tr>
                                          <td class="tabFormEsq">Confirmar palavra passe:</td>
                                          <td>
                                          <input type="password" name="confPass" id="confPass" class="tabFormDir" /></td>
                                        </tr>
                                        <tr>
                                          <td class="tabFormEsq">Email:</td>
                                          <td>
                                          <input type="text" name="email" id="email" class="tabFormDir" /></td>
                                        </tr>                                              
                                        <tr>
                                          <td class="tabFormEsq">Tipo de utilizador:</td>
                                          <td>
                                             <select name="tipoUtil" id="tipoUtil" class="tabFormDir">
                                               <option value="Administrador">Administrador</option>
                                               <option value="Normal" selected="selected">Normal</option>
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>&nbsp;</td>
                                          <td><input type="submit" name="registar" id="registar" value="Registar" class="tabFormDir" />
                                          <input type="reset" name="limpar" id="limpar" value="Limpar" class="tabFormDir" /></td>
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
	}else{ //Se o utilizador não for adminsitrador, redireciona o mesmo para a página de entrada de utilizador registado
		header("location:index.php");	
	}
}
?>