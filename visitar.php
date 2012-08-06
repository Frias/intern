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
									$codInt_tmp=$_GET['codint'];
									if ($codInt_tmp == NULL) {
										echo "<br>** Especifique um internamento **<br>";
									}
									else{
										$sql="select * from t_internamentos where codInt=$codInt_tmp";
										$int=mysqli_query($cn,$sql);
										$count = mysqli_num_rows($int);
										if ($count == 0) {
											echo "<br>** Internamento inexistente **<br>";
										}
										else{
											while ($dad=mysqli_fetch_assoc($int)) {
											$saida=$dad["datahorasaida"];
											$vis=$dad['vis'];
											}
											if ($saida!="0000-00-00 00:00:00"){
												echo "<br>** Utente já teve alta **<br>";
											}
											else{
												if ($vis==0){
													echo "<br>** Não pode ter visitas **<br>";
												}
												else {
													$sql="select t_internamentos.obs as obs, t_cama.codCama as codCama, ncama, codQ, codInt, t_utentes.codUt as codUt, t_medicos.codMed as codMed, datahoraentrada, datahorasaida, vis,  t_medicos.nome as mnome, t_utentes.nome as unome, inome from t_cama, t_internamentos, t_medicos, t_utentes, t_quartos, t_serv_int where t_internamentos.codUt=t_utentes.codUt and t_internamentos.codMed=t_medicos.codMed and t_internamentos.codCama=t_cama.codCama and t_quartos.codQuar=t_cama.codQ and codS=codServInt and codInt=$codInt_tmp";
													$inti=mysqli_query($cn,$sql);
													while ($dadi=mysqli_fetch_assoc($inti)){
														$codcama=$dadi["codCama"];
														$cama=$dadi["ncama"];
														$quarto=$dadi["codQ"];
														$int=$dadi["codInt"];
														$codut=$dadi["codUt"];
														$codmed=$dadi["codMed"];
														$mnome=$dadi["mnome"];
														$unome=$dadi["unome"];
														$inome=$dadi["inome"];
													}
													$sql="select * from t_cartao where occ=0 and codCama=$codcama";
													$cart=mysqli_query($cn,$sql);
													$count = mysqli_num_rows($cart);
													if ($count==0){
														echo "<br>** O utente não pode ter mais visitas de momento **<br>";
													}
													else{
													
									?>
                                        <table width="600" border="0" cellspacing="1" cellpadding="1" align="center">
                                            <tr><td id="textoCabTabCorpo" colspan="9">Adicionar Novo Visitante</td></tr>
											<tr><td colspan="9"><div class="adicReg" align="left"><a href="internamentos.php">Voltar</a></div></td></tr>
                                            <form id="formgVis" name="formVis" method="post" action="visitarConf.php">        
                                            <tr>
                                              <td width="300" class="tabFormEsq">Codigo de Internamento:</td>
                                              <td width="300">
                                              <input type="text" name="codint" id="codint" class="tabFormDir" value="<?php echo $codInt_tmp; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Nome do Utente:</td>
                                              <td width="300">
                                              <input type="text" name="unome" id="unome" class="tabFormDir" value="<?php echo $unome; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Serviço:</td>
                                              <td width="300">
                                              <input type="text" name="inome" id="inome" class="tabFormDir" value="<?php echo $inome; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Codigo da Cama:</td>
                                              <td width="300">
                                              <input type="text" name="cnome" id="cnome" class="tabFormDir" value="<?php echo $codcama; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Cama:</td>
                                              <td width="300">
                                              <input type="text" name="nomecama" id="nomecama" class="tabFormDir" value="<?php echo "Cama $cama quarto $quarto"; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Nome Visitante:</td>
                                              <td width="300">
                                              <input type="text" name="vnome" id="vnome" class="tabFormDir" /></td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Tipo ID:</td>
                                              <td>
                                                 <select name="tipoID" id="tipoID" class="tabFormDir">
                                                   <option value="CC" selected="selected">Cartão de Cidadão</option>
                                                   <option value="BI">BI</option>
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Num.º ID:</td>
                                              <td>
                                              <input type="text" name="numID" id="numID" class="tabFormDir" /></td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Cartão:</td>
                                              <td><select name="cart" id="cart" class="tabFormDir">
                                              <?php
                                              while ($resc=mysqli_fetch_assoc($cart)){
                                              	$cartao=$resc["codCartao"];
                                              	echo '<option value="'.$cartao.'">'.$cartao.'</option>';
                                              }
                                              ?>
                                              
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td><input type="submit" name="visitar" id="visitar" value="Visitar" class="tabFormDir" />
                                              <input type="reset" name="limpar" id="limpar" value="Limpar" class="tabFormDir" /></td>
                                            </tr>
                                        </form>                                              			
                                      </table>                                            
                                      <?php
													}
												}
											
											}
										}
									}
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
}
?>