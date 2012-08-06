<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Erro de Login ::.</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css" />
<link href="estilosCSS.css" rel="stylesheet" type="text/css" media="all" /><!-- importa os estilos do ficheiro estilosCSS.css-->
</head>
<body>
<?php
function formLogin($msgU,$msgP, $msgG, $user, $pass){ //Função com formulário para imprimir mensagens de erro
	echo '
		<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
		  <tr>
			<td colspan="3" id="bodyCab">
				<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
				  <tr>
					<td height="133" id="bodyCabFont">Administração<br>EBMG02</td>
				  </tr>
				  <tr>
					<td height="68" id="textoCabTab">Login</td>
				  </tr>
				  <tr>
					<td id="corpoTop"></td>
				  </tr>
				  <tr>
					<td bgcolor="#FFFFFF">
					<form name="formLogin" method="post" action="checkLogin.php">
					  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
						  <td width="450" class="tabFormEsq">Utilizador:</td>
						  <td width="450" class="msgErro"><input type="text" name="user" id="user" class="tabFormDir" value='.$user.'>'.$msgU.'</td>
						</tr>
						<tr>
						  <td class="tabFormEsq">Palavra - passe:</td>
						  <td class="msgErro"><input type="password" name="pass" id="pass" class="tabFormDir"  value='.$pass.'>'.$msgP.'</td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td class="msgErro"><input type="submit" name="entrar" id="entrar" value="Entrar" class="tabFormEsq">'.$msgG.'</td>
						</tr>
					  </table>
					</form>
					</td>
				  </tr>
				  <tr>
					<td id="corpoRod"></td>
				  </tr>                    
				</table>
			   </td>
		  </tr>
		  <tr>
			  <td id="bodyRod"> UM - Mestrado Integrado Engenharia Biomédica <br>Trabalho elaborado pelo grupo 2: Manuela Marinho, Carolina Fernandes, Vitor Frias</td>
		  </tr>  
		</table>
	';
}



$user_tmp = $_POST['user']; //recebe o nome de utilizador
$pass_tmp = $_POST['pass']; //recebe a password de utilizador

$msgGeral=NULL; //Inicializa variáveis globais a nulo;
$msgUser=NULL;
$msgPass=NULL;

//Verifica se é um utilizador correto
if(empty($user_tmp)) { //Verifica se o campo user está vazio
	$msgUser=" * Inserir um nome de utilizador!";
	}
	elseif((strlen($user_tmp)<6)||(strlen($user_tmp)>15)){  //Verifica se o campo user tem menos de 6 caracteres ou mais de 15
		$msgUser=" * O nome de utilizador deve ter entre 6 e 15 caracteres!";
	}
	
// verifica se inseriu alguma palavra passe
if(empty($pass_tmp)) {
	$msgPass=" * Inserir uma palavra-passe!";
	}
	elseif((strlen($pass_tmp)<6)||(strlen($pass_tmp)>15)){  //Verifica se o campo user tem menos de 6 caracteres ou mais de 15
		$msgPass=" * A palavra passe deve ter entre 6 e 15 caracteres!";
	}

//caso não existam erros ou mensagens
if((!empty($msgUser)) || (!empty($msgPass))) { // se as tiver mensagens
		formLogin($msgUser,$msgPass,$msgGeral,$user_tmp,$pass_tmp);	//Em caso de erro, imprime o conteúdo da função
	}
	else {
		//Faz o LOGIN e Cria Sessão
		ob_start(); //Ativa o buffer de saída para evitar alguns erros
		
		include_once('conexao.php');//Executa o código de ligação à base de dados
		
		// As seguintes linhas de código servirão para evitar o SQL Injection, daí usar mysqli em vez do mysql
		$userCheck = stripslashes($user_tmp); // stripslashes - Remove barras invertidas de uma string.
		$passCheck = stripslashes($pass_tmp);
		$userCheck = mysqli_real_escape_string($cn, $userCheck); //Variável $cn está declarada no ficheiro conexao.php
		$passCheck = mysqli_real_escape_string($cn, $passCheck);
		$sql="SELECT * FROM t_utilizador WHERE user='$userCheck' and pass=SHA('$passCheck')"; //Variável que guarda a query SELECT
		$resultado=mysqli_query($cn, $sql); //Executa query e guarda resultado na variável $resultado
		$count=mysqli_num_rows($resultado); //Conta quantos resultados (linhas) obteve.
		//Se $userCheck e $userCheck estiverem na mesma linha, retorna 1
		if($count==1){ 
			// Regista $userCheck e redireciona o ficheiro para "index.php"
			session_register("ADMIN");
//			$_SESSION['name']= $userCheck;
			
			while ($row = mysqli_fetch_assoc($resultado)) { //Enquanto existir dados na variável $resultado
					$_SESSION['name']= $row["codUtil"]."-".$userCheck."-".$row["tipoUtil"]; //$_SESSION['name'] guardará o códido do utilizador, o nome do utilizador e o tipo de utilizador ex. 1-Pedro-Administrador
					header("location:index.php"); //redireciona para a página index.php
				}
			}
			else{
					$msgGeral="** O utilizador não está registado neste site!";
					formLogin($msgUser,$msgPass,$msgGeral,$user_tmp,$pass_tmp);	//Em caso de não existir o utilizador na BD, imprime o conteúdo da função com utilizador não registado
				}
				ob_end_flush();

				mysqli_free_result($resultado);
				mysqli_close($cn);	
		}	

?>
</body>
</html>