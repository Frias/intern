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
    <link rel="stylesheet" type="text/css" href="file:///C|/wamp/www/carloslixa/css.css" />
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
									<table width="600" border="0" cellspacing="1" cellpadding="1" align="center">
                                        <tr><td id="textoCabTabCorpo" colspan="9">Eliminar Dados de Utente</td></tr>
                                        <tr><td colspan="9"><div class="adicReg" align="left"><a href="utentes.php">Voltar</a></div></td></tr>                                
        <?php
	$cod_tmp = $_POST['cod']; //criação de variáveis temporárias com os valores do formulário
	$sql="DELETE FROM t_utentes WHERE codUt = '".$cod_tmp."'";
	$resultado=mysqli_query($cn, $sql); //Faz a alteração na BD
	$num_afect=mysqli_affected_rows($cn);
	if ($resultado) {
			header("location:utentes.php"); //Se a variável $resultado tiver dados, significa que alterou e redireciona para a página indexLogin.php
	}
	
	?>
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
<?php
mysqli_close($cn);		
}
?>
