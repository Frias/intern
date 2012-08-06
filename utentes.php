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
										$sql="SELECT * FROM t_utentes WHERE nome LIKE '%$pro%'";
										}
										else{
										$sql="SELECT * FROM t_utentes";
										}
										$resultado = mysqli_query ($cn,$sql); 
										$count=mysqli_num_rows($resultado);
										if ($count==0) {
											echo "<br>** A Busca não teve Resultados **<br>";
											}
										else {
                                     ?>
                                        <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                            <tr><td id="textoCabTabCorpo" colspan="12">Utentes</td></tr>
											<tr><td colspan="5"><div class="adicReg" align="left"><a href="adicionarUtente.php">Adicionar novo utente</a></div></td></td><td colspan="8"><div class="adicReg" align="right"><form method="GET" action="utentes.php">

<label for="procura">Buscar:</label>
<input type="text" id="procura" name="procura" maxlength="255" />
<input type="submit" value="P" />

</form>
</div></td></tr>
                                              <tr class="cabTabLista" height="20">
                                                <td width="10">Cód</td><td width="100">Nome</td><td width="40">Tipo ID</td><td width="50">N.º ID</td><td width="30">Tipo Cartão Utentes</td><td width="50">N.º cartão</td><td width="30">Tipo Sangue</td><td width="120">Morada</td><td width="120">Contactos</td><td width="120">Obs</td><td width="2">E</td><td width="2">R</td><td width="2">I</td>
                                              </tr>
                                                    
                                            <?php
                                            while ($registo=mysqli_fetch_assoc($resultado)) { //Enquanto a variável $resultado tiver dados passa para a variável $registo
                                                    $cod=$registo["codUt"]; //guarda os dados do utilizador 
                                                    $nome=$registo["nome"];
                                                    $tipoID=$registo["tipoID"];
                                                    $numID=$registo["numID"];
                                                    $tipoCartUt=$registo["tipoCartUtente"];
                                                    $numCart=$registo["numCartUtente"];
													$tipoSangue=$registo["tipoSangue"];														
                                                    $morada=$registo["morada"];																
                                                    $contacto=$registo["contacto"];	
                                                    $obs=$registo["obs"];	
                                                    $int=$registo["intr"];
                                                    if ($int==1){
                                                    	$sql="select * from t_internamentos where datahorasaida ='0000-00-00 00:00:00' and codUt=$cod";
                                                    	$got=mysqli_query($cn,$sql);
                                                    	while ($in=mysqli_fetch_assoc($got)){
                                                    	$cint=$in["codInt"];
                                                    	}
                                                    	$intr="<a href='perfilInt.php?codint=$cint'>Internado</a>";
                                                    }
                                                    else{
                                                    	$intr="<a href='internar.php?codut=$cod'>Internar</a>";
                                                    }
													?>                            
                                                    <tr class="tabLista" height="20">
                                                      <td><?php echo $cod;?></td><td><a href="perfilUt.php?codut=<?php echo $cod; ?>"><?php echo $nome;?></a></td><td><?php echo $tipoID;?></td><td><?php echo $numID;?></td><td><?php echo $tipoCartUt;?></td><td><?php echo $numCart;?></td><td><?php echo $tipoSangue;?></td><td><?php echo $morada;?></td><td><?php echo $contacto;?></td><td><?php echo $obs;?></td><td><a href="alterarUtente.php?codEditar=<?php echo $cod;?>">E</a></td><td><a href="eliminarUtente.php?codElim=<?php echo $cod;?>">R</a></td><td><?php echo $intr; ?></td>
                                                    </tr>	
                                                    <?php							
                                            }//fecha o while($registo=mysqli_fetch_assoc($resultado))
                                            ?>
                                            </table>
                                            <?php
                                        } //fecha o else
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
	mysqli_free_result ($resultado); //Liberta a memória
	mysqli_close($cn); //Fecha ligação à BD

}
?>