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
                        require_once('menuAdmin.php');
                        menuAdmin("medicos");

					$codMed_tmp=$_GET['codEditar'];//Guarda o código de utilizador na variável $codUtil_tmp que vem por URL				
					$sql="SELECT * FROM t_medicos, t_especialidade WHERE codEsp=esp AND codMed=$codMed_tmp"; //variável com comando SQL que selecciona todos os dados do utilizador a ser alterado
				$verResEdit = mysqli_query ($cn,$sql); //guarda os dados vindos da tabela
				if ($verResEdit) { //verifica se a variável tem conteúdo
					while ($regEdit=mysqli_fetch_assoc($verResEdit)) { //Imprime o conteúdo do array
						$codM=$regEdit["codMed"]; //guarda os dados do utilizador 
						$nomeM=$regEdit["nome"];
						$tipoID=$regEdit["tipoID"];
						$numID=$regEdit["numID"];
						$moradaM=$regEdit["morada"];
						$contactoM=$regEdit["contacto"];
						$obsM=$regEdit["obs"];
						$espM=$regEdit["esp"];
						}
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
                                            <tr><td id="textoCabTabCorpo" colspan="9">Alterar Dados do Médico</td></tr>
											<tr><td colspan="9"><div class="adicReg" align="left"><a href="medicos.php">Voltar</a></div></td></tr>
                                            <form id="formEditMed" name="formEditMed" method="post" action="alterarMedConf.php">
                                            <tr>
                                              <td width="300" class="tabFormEsq">Código:</td>
                                              <td width="300">
                                              <input type="text" name="cod" id="cod" class="tabFormDir" value="<?php echo $codMed_tmp; ?>" readonly="readonly" /></td>
                                            </tr>
                                            <tr>
                                              <td width="300" class="tabFormEsq">Nome Completo:</td>
                                              <td width="300">
                                              <input type="text" name="nome" id="nome" class="tabFormDir" value="<?php echo $nomeM; ?>" /></td>
                                            </tr>
											<tr>
											<td class="tabFormEsq">Especialidade:</td>
											<td><select name="esp" id="esp" class="tabFormDir">
											<?php
											$sql="select * from t_especialidade";
											$getesp=mysqli_query ($cn,$sql);
											while ($resp=mysqli_fetch_assoc($getesp)){
												$pro_codEsp=$resp["codEsp"];
												$pro_esp=$resp["enome"];
												if ($pro_codEsp==$espM){
													echo '<option value="'.$pro_codEsp.'" selected="selected">'.$pro_esp.'</option>';
												}
												else {
													echo '<option value="'.$pro_codEsp.'">'.$pro_esp.'</option>';
												}
											}
											?>
											</select>
											</td>
											</tr>
                                            <tr>
                                              <td class="tabFormEsq">Tipo ID:</td>
                                              <td>
                                              	<select name="tipoID" id="tipoID" class="tabFormDir">';
                                              <?php
                                                 if($tipoID=="CC"){
                                                   echo'
                                                       <option value="CC" selected="selected">Cartão de Cidadão</option>
                                                       <option value="BI">BI</option>';
                                                 }else{
                                                    echo '
                                                        <option value="CC">Cartão de Cidadão</option>
                                                        <option value="BI" selected="selected">BI</option>';
                                                 }
												?>
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Num.º ID:</td>
                                              <td>
                                              <input type="text" name="numID" id="numID" class="tabFormDir" value="<?php echo $numID; ?>" /></td>
                                            </tr>
                                            <tr>
                                              <td class="tabFormEsq">Morada:</td>
                                              <td><textarea name="morada" cols="40" rows="10" class="tabFormDir" id="morada"><?php echo $moradaM; ?></textarea></td>
                                            </tr>
											<tr>
                                              <td class="tabFormEsq">Contactos:</td>
                                              <td><textarea name="contacto" cols="40" rows="10" class="tabFormDir" id="contacto"><?php echo $contactoM; ?></textarea></td>
                                            </tr>                                              
                                            <tr>
                                              <td class="tabFormEsq">Observações:</td>
                                              <td><textarea name="obs" cols="40" rows="10" class="tabFormDir" id="obs"><?php echo $obsM; ?></textarea>	
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td><input type="submit" name="editar" id="editar" value="Editar" class="tabFormDir" />
                                              <input type="reset" name="limpar" id="limpar" value="Limpar" class="tabFormDir" /></td>
                                            </tr>
                                        </form>                                              			
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
	}else{ //Se o utilizador não for adminsitrador, redireciona o mesmo para a página de entrada de utilizador registado
		header("location:index.php");	
	}
}
?>