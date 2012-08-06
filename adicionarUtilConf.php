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
    <title>.:: Utilizadores ::.</title>
    </head>
    <body>


<?php
function formRegUtil($nome, $nomeErro, $user, $userErro, $pass, $passErro, $email, $emailErro, $tipoUtil){	
	$formularioRegUtil='
			<form id="formRegUser" name="formRegUser" method="post" action="adicionarUtilConf.php">
            <tr>
              <td class="tabFormEsq" width="150">Nome Completo:</td>
              <td width="450" class="msgErro">
              <input type="text" name="nome" id="nome" value="'.$nome.'" class="tabFormDir" />'.$nomeErro.'</td>
            </tr>
            <tr>
              <td  class="tabFormEsq">Nome de Utilizador:</td>
              <td class="msgErro">
              <input type="text" name="user" id="user" value="'.$user.'" class="tabFormDir" />'.$userErro.'</td>
            </tr>
            <tr>
              <td class="tabFormEsq">Palavra passe:</td>
              <td class="msgErro">
              <input type="password" name="pass" id="pass" value="'.$pass.'"  class="tabFormDir"/>'.$passErro.'</td>
            </tr>
            <tr>
              <td class="tabFormEsq">Confirmar palavra passe:</td>
              <td>
              <input type="password" name="confPass" id="confPass" class="tabFormDir" /></td>
            </tr>
            <tr>
              <td class="tabFormEsq">Email:</td>
              <td class="msgErro">
              <input type="text" name="email" id="email" value="'.$email.'"  class="tabFormDir"/>'.$emailErro.'</td>
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
        </form>';
		return $formularioRegUtil;	
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
        <?php
			$nome_tmp = $_POST['nome']; //criação de variáveis temporárias com os valores do formulário
			$user_tmp = $_POST['user']; 
			$pass_tmp = $_POST['pass'];
			$confPass_tmp = $_POST['confPass'];
			$email_tmp = $_POST['email']; 			
			$tipoUtil_tmp = $_POST['tipoUtil'];
			
			$nomeErro=NULL;
			$userErro=NULL;
			$passErro=NULL;
			$emailErro=NULL;			
						
			//veririfica se tem mais de 2 nomes
			$nNomes = explode(" ",$nome_tmp);
			if((count($nNomes)<=1) || (strlen($nome_tmp)<=6)){
					$nomeErro=" * Insira um nome mais completo!";
				}
			//Verifica se é nome de utilizador está correto
			if(empty($user_tmp)) {
				$userErro=" * Inserir um nome de utilizador válido!";
				}
				elseif((strlen($user_tmp)<6)||(strlen($user_tmp)>15)){ //Verifica se o nome de utilizador tem menos de 6 ou mais de 15 caracteres, se sim, executa linha abaixo
					$userErro=" * O nome de utilizador deve ter entre 6 e 15 caracteres!";
					}else{
						//Verifica se o email já existe na BD
						$sql="SELECT * FROM t_utilizador"; //variável com comando SQL que selecciona todos os campos
						$verRes = mysqli_query ($cn,$sql); //guarda os dados vindos da tabela
						if ($verRes) { //verifica se a variável tem conteúdo
							while ($reg=mysqli_fetch_assoc($verRes)) { //Imprime o conteúdo do array
								if ($reg["user"]==$user_tmp){ //verifica se o utilizador que está a ser registado já existe na BD
									$userErro=" * Este utilizador já se encontra registado na nossa BD!";
									break; 
								}
							}
						}
						mysqli_free_result($verRes);
					}

			// verifica o campo da palavra passe
			if(empty($pass_tmp)) { //Se o campo password estiver vazio executa a linha a seguir
				$passErro=" * Inserir uma palavra-passe!";
			}elseif((strlen($pass_tmp)<6) || (strlen($pass_tmp)>15)){ //Senão se a pass tiver menos de 6 ou mais de 15 caracteres, executa a linha abaixo
					$passErro=" * A palavra-passe deve ter entre 6 e 15 caracteres!";
				}elseif($pass_tmp!=$confPass_tmp){ //Senão se a pass for diferente da confirmação da pass, executa a linha abaixo
						$passErro=" * Palavra-passe e confirmação da palavra-passe diferentes!";
					}

			//Verifica se é um email correto
			$verificaEmail=preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/",$email_tmp); //Expressão regular que verifica se a sintaxe do email está correta e no caso de sim guarda o valor 1 (email correto) na variável $verificaEmail, se não, guarda o valor 0 (email errado)
			if(empty($email_tmp)) { //Se o campo email estiver vazio executa a linha a seguir
				$emailErro=" * Inserir um email válido!";
				}
				elseif($verificaEmail==0){ //Se a variável $verificaEmail estiver com valor 0 executa a linha a seguir
					$emailErro=" * Este email não é válido!";
					}						
			
			if((!empty($nomeErro)) || (!empty($emailErro))|| (!empty($passErro))|| (!empty($userErro))) { //caso existam mensagens de erros, executa a linha abaixo imprimindo o formulário dentro da função formRegUtil
					echo formRegUtil($nome_tmp, $nomeErro, $user_tmp, $userErro, $pass_tmp, $passErro, $email_tmp, $emailErro, $tipoUtil_tmp);	//Em caso de erro, imprime o conteúdo da função dando informação do tipo de erro no próprio formulário
				}
				else { //caso não existam mensagens de erros, executa as linhas abaixo inserindo os dados na BD na tabela t_utilizadores
					//Insere na BD
					ob_start(); //Ativa o buffer de saída para evitar alguns erros
					$dataAtual=date('Y-m-d H:i:s'); //Guarda a data e hora atual para ficar registado na BD a data e hora de inserção na BD
					$sql="INSERT INTO t_utilizador (nomeCompUtil,user,pass,email,tipoUtil,dataRegUtil) VALUES ('$nome_tmp','$user_tmp',SHA('$pass_tmp'),'$email_tmp','$tipoUtil_tmp','$dataAtual')"; //Com password encryptada SHA
					$resultado=mysqli_query($cn, $sql); //Executa a query
					//mysqli_free_result($resultado);
					ob_end_flush();
					header("location:utilizadores.php");
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
	}else{ //Se o utilizador não for adminsitrador, redireciona o mesmo para a página de entrada de utilizador registado
		header("location:index.php");	
	}
mysqli_close($cn);		
}
?>
