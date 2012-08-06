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
include('funcUtente.php'); //inclusão da página com algumas funções referentes a dados do Utente
function formRegUt($cod_tmp,$nome_tmp, $nomeErro, $tipoID_tmp, $numID_tmp, $idErro,$tipoCartUt_tmp, $numCartUt_tmp, $cartErro,$tipoSangue_tmp, $morada_tmp, $moradaErro, $contacto_tmp, $obs_tmp){	
		echo '
			 <form id="formRegUt" name="formRegUt" method="post" action="alterarUtenteConf.php">        
								<tr>
				  <td width="150" class="tabFormEsq">Nome Completo:</td>
				  <td width="550" class="msgErro">
				  <input type="text" name="cod" id="cod" class="tabFormDir" value="'.$cod_tmp.'" readonly="readonly"/></td>
				</tr>
				<tr>
				  <td width="150" class="tabFormEsq">Nome Completo:</td>
				  <td width="550" class="msgErro">
				  <input type="text" name="nome" id="nome" class="tabFormDir" value="'.$nome_tmp.'"/>'.$nomeErro.'</td>
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
			echo'		 
					</select>
				  </td>
				</tr>
				<tr>
				  <td class="tabFormEsq">Num.º ID:</td>
				  <td class="msgErro">
				  <input type="text" name="numID" id="numID" class="tabFormDir" value="'.$numID_tmp.'"/>'.$idErro.'</td>
				</tr>
				<tr>
				  <td class="tabFormEsq">Tipo Cartão:</td>
				  <td>
					 <select name="tipoCartUt" id="tipoCartUt" class="tabFormDir">';
					 
					 //Invoca a função tipoCartUt e verifica que cartão foi escolhido
					 tipoCartUt($tipoCartUt_tmp);
			echo'
					</select>
				  </td>
				</tr>
				<tr>
				  <td class="tabFormEsq">Num.º Cartão:</td>
				  <td class="msgErro">
				  <input type="text" name="numCartUt" id="numCartUt" class="tabFormDir" value="'.$numCartUt_tmp.'"/>'.$cartErro.'</td>
				</tr>				
				<tr>
				  <td class="tabFormEsq">Tipo Sangue:</td>
				  <td>
					 <select name="tipoSangue" id="tipoSangue" class="tabFormDir">';
					 //Invoca a função tipoSangue Verifica que tipoSangue foi escolhido
					 tipoSangue($tipoSangue_tmp);
				echo'
					</select>
				  </td>
				</tr> 				
				<tr>
				  <td class="tabFormEsq">Morada:</td>
				  <td class="msgErro"><textarea name="morada" cols="40" rows="10" class="tabFormDir" id="morada">'.$morada_tmp.'</textarea>'.$moradaErro.'</td>
				</tr>
				<tr>
				  <td class="tabFormEsq">Contactos:</td>
				  <td class="msgErro">
				  <textarea name="contacto" cols="40" rows="10" class="tabFormDir" id="contacto">'.$contacto_tmp.'</textarea></td>
				</tr>                                              
				<tr>
				  <td class="tabFormEsq">Observações:</td>
				  <td class="msgErro"><textarea name="obs" cols="40" rows="10" class="tabFormDir" id="obs">'.$obs_tmp.'</textarea>	
				  </td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><input type="submit" name="registar" id="registar" value="Registar" class="tabFormDir" />
				  <input type="reset" name="limpar" id="limpar" value="Limpar" class="tabFormDir" /></td>
				</tr>
			</form> ';
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
                                        <tr><td id="textoCabTabCorpo" colspan="9">Alterar Dados do Utente</td></tr>
                                        <tr><td colspan="9"><div class="adicReg" align="left"><a href="utentes.php">Voltar</a></div></td></tr>                                
        <?php
			$cod_tmp = $_POST['cod']; //criação de variáveis temporárias com os valores do formulário
			$nome_tmp = $_POST['nome'];			
			$tipoID_tmp = $_POST['tipoID'];			
			$numID_tmp = $_POST['numID'];
			$tipoCartUt_tmp = $_POST['tipoCartUt'];			
			$numCartUt_tmp = $_POST['numCartUt'];
			$tipoSangue_tmp = $_POST['tipoSangue'];						
			$morada_tmp = $_POST['morada'];
			$contacto_tmp = $_POST['contacto'];			
			$obs_tmp = $_POST['obs'];
			
			$nomeErro=NULL;
			$idErro=NULL;
			$cartErro=NULL;
			$moradaErro=NULL;
			//$contactoErro=NULL;			
						

			$nNomes = explode(" ",$nome_tmp);
			//Verifica se é nome de utilizador está correto
			if(empty($nome_tmp)) {
				$nomeErro=" * Preencha este campo!";
				}
				elseif((count($nNomes)<=1) || (strlen($nome_tmp)<=6)){//verifica se tem mais de 2 nomes
					$nomeErro=" * Insira um nome mais completo!";
				}
				
			if(empty($numID_tmp)) {
				$idErro=" * Preencha este campo!";
				//}
				//elseif($numID_tmp){ //Verifica se o nome de médico tem menos de 6 ou mais de 15 caracteres, se sim, executa linha abaixo
					//$userErro=" * O nome de utilizador deve ter entre 6 e 15 caracteres!";
					}else{
						//Verifica se o email já existe na BD
						$sql="SELECT * FROM t_utentes"; //variável com comando SQL que selecciona todos os campos
						$verRes = mysqli_query ($cn,$sql); //guarda os dados vindos da tabela
						if ($verRes) { //verifica se a variável tem conteúdo
							while ($reg=mysqli_fetch_assoc($verRes)) { //Imprime o conteúdo do array
								if (($reg["numID"]==$numID_tmp)&&($reg["codUt"]!=$cod_tmp)){ //verifica se o ID de médico que está a ser registado já existe na BD
									$idErro=" * Este ID já se encontra registado na nossa BD!";
									break; 
								}
							}
						}
						mysqli_free_result($verRes);
					}

				if(empty($numCartUt_tmp)) {
				$cartErro=" * Preencha este campo!";
				//}
				//elseif($numID_tmp){ //Verifica se o nome de médico tem menos de 6 ou mais de 15 caracteres, se sim, executa linha abaixo
					//$userErro=" * O nome de utilizador deve ter entre 6 e 15 caracteres!";
					}else{
						//Verifica se o email já existe na BD
						$sql="SELECT * FROM t_utentes"; //variável com comando SQL que selecciona todos os campos
						$verRes = mysqli_query ($cn,$sql); //guarda os dados vindos da tabela
						if ($verRes) { //verifica se a variável tem conteúdo
							while ($reg=mysqli_fetch_assoc($verRes)) { //Imprime o conteúdo do array
								if (($reg["numCartUtente"]==$numCartUt_tmp)&&($reg["codUt"]!=$cod_tmp)){ //verifica se o ID de médico que está a ser registado já existe na BD
									$idErro=" * Este n.º de cartão já se encontra registado na nossa BD!";
									break; 
								}
							}
						}
						mysqli_free_result($verRes);
					}					
					
				//veririfica preencheu o campo referente à morada
				if(empty($morada_tmp)) {
					$moradaErro=" * Inserir uma morada de Utente!";
					}
					elseif((strlen($morada_tmp)<9)){
						$moradaErro=" * Insira uma morada mais completa!";
					}							

			
			if((!empty($nomeErro)) || (!empty($idErro))|| (!empty($cartErro))|| (!empty($moradaErro))) { //caso existam mensagens de erros, executa a linha abaixo imprimindo o formulário dentro da função formRegUtil
					formRegUt($cod_tmp,$nome_tmp, $nomeErro, $tipoID_tmp, $numID_tmp, $idErro,$tipoCartUt_tmp, $numCartUt_tmp, $cartErro,$tipoSangue_tmp, $morada_tmp, $moradaErro, $contacto_tmp, $obs_tmp);	//Em caso de erro, imprime o conteúdo da função dando informação do tipo de erro no próprio formulário
				}
				else { //caso não existam mensagens de erros, executa as linhas abaixo alterando os dados na BD na tabela t_utentes
					//Insere na BD
					ob_start(); //Ativa o buffer de saída para evitar alguns erros
					$sql="UPDATE t_utentes SET nome='".$nome_tmp."',tipoID='".$tipoID_tmp."',numID='".$numID_tmp."',tipoCartUtente='".$tipoCartUt_tmp."',numCartUtente='".$numCartUt_tmp."',tipoSangue='".$tipoSangue_tmp."',morada='".$morada_tmp."',contacto='".$contacto_tmp."',obs='".$obs_tmp."' WHERE codUt = '".$cod_tmp."'";
					$resultado=mysqli_query($cn, $sql); //Executa a query
					//mysqli_free_result($resultado);
					ob_end_flush();
					header("location:utentes.php");
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
