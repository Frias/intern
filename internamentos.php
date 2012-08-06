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
                    if($tipoU_tmp=="Administrador"){ //Se tipo de utilizador é igual a Administrador, aparece o menuAdmin com todas as funcionalidades e permissões e abre a página utilizadores.php caso contrário, não permite que utilizadores normais acessem a esta página
                        require('menuAdmin.php');
                        menuAdmin("internamento");
					}else{ //Senão aparece o menuTopo apenas com permissões limitadas
						require('menuTopo.php');
                        menuTopo("internamento");
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
										$sai=NULL;
										$st=NULL;
										if ($_GET['sai']!=0){
											$sai=" and datahorasaida='0000-00-00 00:00:00' ";
											$st="<a href='internamentos.php'>Todos</a>";
										}
										else {
											$sai="and 1";
											$st="<a href='internamentos.php?sai=1'>Apenas os que não tiveram alta</a>";
										}
										if ($_GET['procura']) {
										$pro = $_GET['procura'];
										$sql="select codInt, t_utentes.codUt, t_utentes.nome as unome, datahorasaida, t_medicos.codMed, t_medicos.nome as menome, esp, t_cama.codCama, vis, codQ, ncama from t_cama, t_utentes, t_medicos, t_internamentos where t_utentes.codUt=t_internamentos.codUt and t_internamentos.codMed=t_medicos.codMed and t_cama.codCama=t_internamentos.codCama $sai and t_utentes.nome LIKE '%$pro%' order by t_internamentos.codInt desc";
										}
										else{
										$sql="select codInt, t_utentes.codUt, t_utentes.nome as unome, datahorasaida, t_medicos.codMed, t_medicos.nome as menome, esp, t_cama.codCama, vis, codQ, ncama from t_cama, t_utentes, t_medicos, t_internamentos where t_utentes.codUt=t_internamentos.codUt and t_internamentos.codMed=t_medicos.codMed and t_cama.codCama=t_internamentos.codCama $sai  order by t_internamentos.codInt desc";
										}
										$resultado = mysqli_query ($cn,$sql); 
										$count=mysqli_num_rows($resultado);
										if ($count==0) {
											echo "<br>** A Busca não teve Resultados **<br>";
											}
										else {
                                     ?>
                                        <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                            <tr><td id="textoCabTabCorpo" colspan="8">Internamentos</td></tr>
											<tr><td colspan="4"><div class="adicReg" align="left"><?php echo $st; ?></div></td></td><td colspan="4"><div class="adicReg" align="right"><form method="GET" action="internamentos.php">

<label for="procura">Buscar:</label>
<input type="text" id="procura" name="procura" maxlength="255" />
<input type="submit" value="P" />

</form>
</div></td></tr>
                                              <tr class="cabTabLista" height="20">
                                                <td width="10">Cód</td><td width="100">Utente</td><td width="100">Medico</td><td width="50">Cama</td><td width="120">Quarto</td><td width="30">Visitas</td><td width="2">E</td><td width="2">R</td>
                                              </tr>
                                                    
                                            <?php
                                            while ($registo=mysqli_fetch_assoc($resultado)) { //Enquanto a variável $resultado tiver dados passa para a variável $registo
                                                    $cod=$registo["codInt"]; //guarda os dados do internamento 
                                                    $codut=$registo["codUt"];
                                                    $codmed=$registo["codMed"];
                                                    $unome=$registo["unome"];
                                                    $menome=$registo["menome"];
                                                    $cama=$registo["ncama"];
                                                    $quarto=$registo["codQ"];
													$vis=$registo["vis"];
													$saida=$registo["datahorasaida"];
													if ($saida!="0000-00-00 00:00:00"){
														$s="";
														$e="";
														$intr="Já teve alta";
													}
													else{
														$s="<a href='alta.php?codint=$cod'>Dar alta</a>";
														$e="<a href='alterarint.php?codint=$cod'>E</a>";
                                                    if ($vis==1){
                                                    	$intr="<a href='visitar.php?codint=$cod'>Sim, visitar</a>";
                                                    }
                                                    else{
                                                    	$intr="Não";
                                                    }
                                                    }
													?>                            
                                                    <tr class="tabLista" height="20">
                                                      <td><?php echo $cod;?></td><td><a href="perfilInt.php?codint=<?php echo $cod; ?>"><?php echo $unome;?></a></td><td><?php echo $menome;?></td><td><?php echo $cama;?></td><td><?php echo $quarto;?></td><td><?php echo $intr;?></td><td><?php echo $e;?></td><td><?php echo $s;?></td>>
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
	mysqli_close($cn); 

}
?>