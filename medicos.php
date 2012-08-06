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
    <title>.:: Médicos ::.</title>
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
                        menuAdmin("medicos");
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
										$sql=NULL;
										$pro=NULL;
										if ($_GET['procura']) {
										$pro = $_GET['procura'];
										$sql="SELECT * FROM t_medicos, t_especialidade WHERE codEsp=esp AND nome LIKE '%$pro%'";
										}
										else{
										$sql="SELECT * FROM t_medicos, t_especialidade WHERE esp=codEsp";
										}
										$resultado = mysqli_query ($cn,$sql); 
										$count=mysqli_num_rows($resultado);
										if ($count==0) {
											echo "<br>** A Busca não teve Resultados **<br>";
											}
										else {
                                     ?>
                                        <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                            <tr><td id="textoCabTabCorpo" colspan="9">Médicos</td></tr>
											<tr><td colspan="4"><div class="adicReg" align="left"><a href="adicionarMed.php">Adicionar novo médico</a></div></td><td colspan="5"><div class="adicReg" align="right"><form method="GET" action="medicos.php">

<label for="procura">Buscar:</label>
<input type="text" id="procura" name="procura" maxlength="255" />
<input type="submit" value="P" />

</form>
</div></td></tr>
                                              <tr class="cabTabLista" height="20">
                                                <td width="20">Código</td><td width="100">Nome</td><td width="50">Tipo ID</td><td width="50">N.º ID</td><td width="150">Morada</td><td width="150">Contactos</td><td width="200">Especialidade</td><td width="2">E</td><td width="2">R</td>
                                              </tr>
                                                    
                                            <?php
                                            while ($registo=mysqli_fetch_assoc($resultado)) { //Enquanto a variável $resultado tiver dados passa para a variável $registo
                                                    $codM=$registo["codMed"]; //guarda os dados do utilizador 
                                                    $nomeM=$registo["nome"];
                                                    $tipoID=$registo["tipoID"];
                                                    $numID=$registo["numID"];	
                                                    $moradaM=$registo["morada"];																
                                                    $contactoM=$registo["contacto"];	
                                                    //$obsM=$registo["obs"];
                                                    $esp=$registo["enome"];
                                                    $cesp=$registo["esp"];//guardado para futura utilização
													?>                            
                                                    <tr class="tabLista" height="20">
                                                      <td><?php echo $codM;?></td><td><a href="perfilMed.php?codmed=<?php echo $codM; ?>"><?php echo $nomeM;?></a></td><td><?php echo $tipoID;?></td><td><?php echo $numID;?></td><td><?php echo $moradaM;?></td><td><?php echo $contactoM;?></td><td><?php echo $esp;?></td><td><a href="alterarMed.php?codEditar=<?php echo $codM;?>">E</a></td><td><a href="eliminarMed.php?codElim=<?php echo $codM;?>">R</a></td>
                                                    </tr>
                                                    <?php							
                                            }//fecha o while($registo=mysqli_fetch_assoc($resultado))
                                            ?>
                                            </table>
                                                    </td>
                                            <?php
                                        } //fecha o else($resultado)
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
	mysqli_free_result ($resultado); //Liberta a memória
	mysqli_close($cn); //Fecha ligação à BD
	
	}else{ //Se o utilizador não for adminsitrador, redireciona o mesmo para a página de entrada de utilizador registado
		header("location:index.php");	
	}	
}
?>