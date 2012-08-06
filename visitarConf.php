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


<?php
function formVis($unome_tmp, $inome_tmp, $cnome_tmp, $nomecama_tmp, $vnome_tmp, $tipoID_tmp, $numID_tmp, $vnomeErro, $idErro, $cart_tmp, $cart, $codint_tmp){	
		echo '
		                                            <form id="formVis" name="formVis" method="post" action="visitarConf.php">        
                                            <tr>
                                              <td width="300" class="tabFormEsq">Codigo de Internamento:</td>
                                              <td width="300">
                                              <input type="text" name="codint" id="codint" class="tabFormDir" value="'.$codint_tmp.'" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Nome do Utente:</td>
                                              <td width="300">
                                              <input type="text" name="unome" id="unome" class="tabFormDir" value="'.$unome_tmp.'" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Serviço:</td>
                                              <td width="300">
                                              <input type="text" name="inome" id="inome" class="tabFormDir" value="'.$inome_tmp.'" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Codigo da Cama:</td>
                                              <td width="300">
                                              <input type="text" name="cnome" id="cnome" class="tabFormDir" value="'.$cnome_tmp.'" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Cama:</td>
                                              <td width="300">
                                              <input type="text" name="nomecama" id="nomecama" class="tabFormDir" value="'.$nomecama_tmp.'" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Nome Visitante:</td>
                                              <td width="300">
                                              <input type="text" name="vnome" id="vnome" class="tabFormDir" value="'.$vnome_tmp.'"/>'.$vnomeErro.'</td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Tipo ID:</td>
                                              <td>
                                                 <select name="tipoID" id="tipoID" class="tabFormDir">';
                                                   if($tipoID_tmp=="CC"){
					   echo'
						   <option value="CC" selected="selected">Cartão de Cidadão</option>
						   <option value="BI">BI</option>';
					 }else{
						echo '
							<option value="CC">Cartão de Cidadão</option>
							<option value="BI" selected="selected">BI</option>';
					 }
					 echo '
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Num.º ID:</td>
                                              <td>
                                              <input type="text" name="numID" id="numID" class="tabFormDir " value="'.$numID_tmp.'" />'.$idErro.'</td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Cartão:</td>
                                              <td><select name="cart" id="cart" class="tabFormDir">';
                while ($resp=mysqli_fetch_assoc($cart)){
					$cartao=$resp["codCartao"];
					if ($cartao==$cart_tmp){
					echo '<option value="'.$cartao.'" selected="selected">'.$cartao.'</option>';
					}
					else {
					echo '<option value="'.$cartao.'">'.$cartao.'</option>';
					}
				}
                                              
                                              echo '</select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td><input type="submit" name="visitar" id="visitar" value="Visitar" class="tabFormDir" />
                                              <input type="reset" name="limpar" id="limpar" value="Limpar" class="tabFormDir" /></td>
                                            </tr>
                                        </form>';

}

?>
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
                                        <tr><td id="textoCabTabCorpo" colspan="9">Adicionar Novo Utente</td></tr>
                                        <tr><td colspan="9"><div class="adicReg" align="left"><a href="utentes.php">Voltar</a></div></td></tr>                                
        <?php
			$unome_tmp = $_POST['unome']; //criação de variáveis temporárias com os valores do formulário
			$codint_tmp = $_POST['codint'];
			$inome_tmp = $_POST['inome'];
			$cnome_tmp = $_POST['cnome'];
			$nomecama_tmp = $_POST['nomecama'];
			$vnome_tmp= $_POST['vnome'];
			$tipoID_tmp = $_POST['tipoID'];
			$numID_tmp = $_POST['numID'];
			$cart_tmp = $_POST['cart'];
			
			$vnomeErro=NULL;
			$idErro=NULL;
			//$cartErro=NULL;
						

			$nNomes = explode(" ",$vnome_tmp);
			//Verifica se é nome está correto
			if(empty($vnome_tmp)) {
				$vnomeErro=" * Preencha este campo!";
				}
				elseif((count($nNomes)<=1) || (strlen($vnome_tmp)<=6)){//verifica se tem mais de 2 nomes
					$vnomeErro=" * Insira um nome mais completo!";
				}
				
			if(empty($numID_tmp)) {
				$idErro=" * Preencha este campo!";
				}
				
			if((!empty($vnomeErro)) || (!empty($idErro))) { //caso existam mensagens de erros, executa a linha abaixo imprimindo o formulário dentro da função formRegUtil
					$sql="select * from t_cartao where occ=0 and codCama=$cnome_tmp";
					$cart=mysqli_query($cn,$sql);
					formVis($unome_tmp, $inome_tmp, $cnome_tmp, $nomecama_tmp, $vnome_tmp, $tipoID_tmp, $numID_tmp, $vnomeErro, $idErro, $cart_tmp, $cart, $codint_tmp);	//Em caso de erro, imprime o conteúdo da função dando informação do tipo de erro no próprio formulário
				}
				else { //caso não existam mensagens de erros, executa as linhas abaixo inserindo os dados na BD na tabela t_utentes
					$entrada=date('Y-m-d H:i:s');
					//Insere na BD
					$sql="INSERT INTO t_visitantes(vnome, tipoID, numID, datahoraentrada, codCartao, codInt) VALUES ('$vnome_tmp', '$tipoID_tmp', '$numID_tmp', '$entrada', '$cart_tmp', '$codint_tmp')"; 
					$resultado=mysqli_query($cn, $sql); //Executa a query
					mysqli_free_result($resultado);
					$sql="UPDATE t_cartao SET occ=1 WHERE codCartao=$cart_tmp"; 
					$resultado=mysqli_query($cn, $sql); //Executa a query
					mysqli_free_result($resultado);
					header("location:visitantes.php");
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
