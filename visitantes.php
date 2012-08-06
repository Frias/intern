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
    <title>.:: Visitantes ::.</title>
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
                        menuAdmin("visitantes");
					}else{ //Senão aparece o menuTopo apenas com permissões limitadas
						require('menuTopo.php');
                        menuTopo("visitantes");
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
										$sai=NULL;
										if ($_GET['sai']!=0){
											$sai=" and t_visitantes.datahorasaida='0000-00-00 00:00:00' ";
											$st="<a href='visitantes.php'>Todos</a>";
										}
										else {
											$sai="and 1";
											$st="<a href='visitantes.php?sai=1'>Apenas os que não tiveram alta</a>";
										}
										//___Seleccionar dados da BD			
										$sql="select codVisit, codCartao, nome, vnome, t_visitantes.tipoID as vtipoID, t_visitantes.numID as vnumID, t_visitantes.datahoraentrada as entrada, t_visitantes.datahorasaida as saida, t_visitantes.codInt as codInt from t_utentes, t_internamentos, t_visitantes where t_utentes.codUt=t_internamentos.codUt and t_internamentos.codInt=t_visitantes.codInt $sai order by codVisit desc"; //Variável que guarda a query SELECT à tabela t_visitantes
										//guarda os dados vindos da tabela			
										$resultado = mysqli_query ($cn,$sql); //Executa query e guarda resultado na variável $resultado
										if ($resultado) { // Se a variável $resultado tiver dados executa as seguintes linhas de código...
                                     ?>
                                        <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                            <tr><td id="textoCabTabCorpo" colspan="9">Visitantes</td></tr>
											<tr><td colspan="9"><div class="adicReg" align="left"><?php echo $st; ?></div></td></tr>
                                              <tr class="cabTabLista" height="20">
                                                <td width="10">Cód</td><td width="40">Nome</td><td width="40">Tipo ID</td><td width="50">N.º ID</td><td width="50">Data/hora Entrada</td><td width="50">Data/hora saída</td><td width="30">Cartão</td><td width="100">Utente</td><td width="10">Dar saida</td>
                                              </tr>
                                                    
                                            <?php
                                            while ($registo=mysqli_fetch_assoc($resultado)) { //Enquanto a variável $resultado tiver dados passa para a variável $registo
                                                    $codvis=$registo["codVisit"]; //guarda os dados do utilizador 
                                                    $vnome=$registo["vnome"];
                                                    $tipoID=$registo["vtipoID"];
                                                    $numID=$registo["vnumID"];
                                                    $entrada=$registo["entrada"];
                                                    $saida=$registo["saida"];
                                                    $nome=$registo["nome"];
													$cartao=$registo["codCartao"];
                                                    $codint=$registo["codInt"];
													if ($saida=="0000-00-00 00:00:00"){
													$dar="<a href='saida.php?codvis=$codvis'>Dar saida</a>";
													}
													else {
													$dar="Já saiu";
													}

													?>                            
                                                    <tr class="tabLista" height="20">
                                                      <td><?php echo $codvis;?></td><td><?php echo $vnome;?></td><td><?php echo $tipoID;?></td><td><?php echo $numID;?></td><td><?php echo $entrada;?></td><td><?php echo $saida;?></td><td><?php echo $cartao;?></td><td><a href="perfilInt.php?codint=<?php echo $codint; ?>"><?php echo $nome;?></a></td><td><?php echo $dar;?></td>
                                                    </tr>	
                                                    <?php							
                                            }//fecha o while($registo=mysqli_fetch_assoc($resultado))
                                        } //fecha o if($resultado)
                                        else{
                                                print ("<br><br>** NÃO HÁ REGISTO NA BD!! **<br>");
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
    </body>
    </html>

<?php
	mysqli_free_result ($resultado); //Liberta a memória
	mysqli_close($cn); //Fecha ligação à BD

}
?>