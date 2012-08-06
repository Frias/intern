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
									<?php
										$sql=NULL;//inicia as variaveis
										$pro=NULL;
										if ($_GET['procura']) {//se existir conteudo get e define a query neste caso
										$pro = $_GET['procura'];
										$sql="select * from t_utilizador where nomeCompUtil like '%$pro%'";
										
										}
										else{//não existindo faz a listagem completa da tabela t_utilizador, neste caso a tabela tem pelo menos uma linha (senão nem sessao existia)
										$sql="SELECT * FROM t_utilizador";
										}			
										$resultado = mysqli_query ($cn,$sql);
										$count=mysqli_num_rows($resultado);//faz a contagem das linhas da tebale retribuida
										if ($count==0) {//$resultado existe, no entanto se tiver 0 linhas não houve resultados e é indicada a string abaixo
											echo "<br>** A Busca não teve Resultados **<br>";
											}
										else {//no caso de existir uma ou mais linhas inprime a tabela. O campo de busca fica na mesma linha que a ligação para adicionar outro utilizador
                                     ?>
                                        <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                            <tr><td id="textoCabTabCorpo" colspan="9">Utilizadores</td></tr>
											<tr><td colspan="4"><div class="adicReg" align="left"><a href="adicionarUtil.php">Adicionar novo utilizador</a></div></td><td colspan="4"><div class="adicReg" align="right"><form method="GET" action="utilizadores.php"><label for="procura">Buscar:</label><input type="text" id="procura" name="procura" maxlength="255" /><input type="submit" value="P" /></form></div></td></tr>
                                              <tr class="cabTabLista" height="20">
                                                <td width="30">Código</td><td width="150">Nome</td><td width="100">Nome Utilizador</td><td width="150">Email</td><td width="100">Tipo de Utilizador</td><td width="100">Data de registo</td><td width="2">E</td><td width="2">R</td>
                                              </tr>
                                                    
                                            <?php
                                            while ($registo=mysqli_fetch_assoc($resultado)) { //Enquanto a variável $resultado tiver dados passa para a variável $registo
                                                    $codU=$registo["codUtil"]; 
                                                    $nomeU=$registo["nomeCompUtil"];
                                                    $userU=$registo["user"];
                                                    $passU=$registo["pass"];
                                                    $emailU=$registo["email"];
                                                    $tipoU=$registo["tipoUtil"];
                                                    $dataRegU=$registo["dataRegUtil"];

                                                    //A seguir irá imprimir todos os utilizadores registados

                                                    if($codU==$codU_tmp){
                                            ?>
                                              <tr class="tabLista" height="20">
                                                <td><?php echo $codU;?></td><td><a href="perfilUtil.php?codutil=<?php echo $codU; ?>"><?php echo $nomeU;?></a></td><td><?php echo $userU;?></td><td><?php echo $emailU;?></td><td><?php echo $tipoU;?></td><td><?php echo $dataRegU;?></td><td><a href="alterarUtil.php?codUEditar=<?php echo $codU;?>">E</a></td><td></td>
                                              </tr>	
                                        <?php
                                                    }
                                                    else{
                                                        ?>
                                                          <tr class="tabLista" height="20">
                                                            <td><?php echo $codU;?></td><td><a href="perfilUtil.php?codutil=<?php echo $codU; ?>"><?php echo $nomeU;?></a></td><td><?php echo $userU;?></td><td><?php echo $emailU;?></td><td><?php echo $tipoU;?></td><td><?php echo $dataRegU;?></td><td><a href="alterarUtil.php?codUEditar=<?php echo $codU;?>">E</a></td><td><a href="eliminarUtil.php?codElim=<?php echo $codU;?>">R</a></td>
                                                          </tr>	
                                                    <?php							
                                                    } //ciclo else
                                            }//ciclo while, é colocada também uma ligação a perfilUtil.php
                                            ?> 
                                            </table>
                                    </td>
                                            <?php
                                        }//ciclo if
                                        
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
	if ($resultado){
		mysqli_free_result ($resultado);
		}
	mysqli_close($cn); //Fecha ligação à BD
	
	}else{ //Se o utilizador não for adminsitrador, redireciona o mesmo para a página de entrada de utilizador registado
		header("location:index.php");	
	}	
}
?>