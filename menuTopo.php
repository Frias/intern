<?php
function menuTopo($pagAtiva){
	switch ($pagAtiva) {
		case "indexLogin":
			echo '
				<div id="menu">
				<ul>
					<li class="active"><a href="index.php" accesskey="1" title=""><span>Inicio</span></a></li>
					<li><a href="utentes.php" accesskey="2" title=""><span> Utentes</span></a></li>
					<li><a href="visitantes.php" accesskey="3" title=""><span> Visitantes</span></a></li>
					<li><a href="internamentos.php" accesskey="3" title=""><span> Internamento</span></a></li>									
					<li><a href="sair.php" accesskey="7" title=""><span>Sair</span></a></li>                                       
				</ul>
				</div>
				';
			break;
		case "utentes":
			echo '
				<div id="menu">
				<ul>
					<li><a href="index.php" accesskey="1" title=""><span>Inicio</span></a></li>
					<li class="active"><a href="utentes.php" accesskey="2" title=""><span> Utentes</span></a></li>
					<li><a href="visitantes.php" accesskey="3" title=""><span> Visitantes</span></a></li>	
					<li><a href="internamentos.php" accesskey="3" title=""><span> Internamento</span></a></li>								
					<li><a href="sair.php" accesskey="7" title=""><span>Sair</span></a></li>                                    
				</ul>
				</div>
				';
			break;
		case "visitantes":
			echo '
				<div id="menu">
				<ul>
					<li><a href="index.php" accesskey="1" title=""><span>Inicio</span></a></li>
					<li><a href="utentes.php" accesskey="2" title=""><span> Utentes</span></a></li>
					<li class="active"><a href="visitantes.php" accesskey="3" title=""><span> Visitantes</span></a></li>
					<li><a href="internamentos.php" accesskey="3" title=""><span> Internamento</span></a></li>									
					<li><a href="sair.php" accesskey="7" title=""><span>Sair</span></a></li>                                    
				</ul>
				</div>
				';
			break;	
		case "internamento":
			echo '
				<div id="menu">
				<ul>
					<li><a href="index.php" accesskey="1" title=""><span>Inicio</span></a></li>
					<li><a href="utentes.php" accesskey="2" title=""><span> Utentes</span></a></li>
					<li><a href="visitantes.php" accesskey="3" title=""><span> Visitantes</span></a></li>
					<li class="active"><a href="internamentos.php" accesskey="3" title=""><span> Internamento</span></a></li>									
					<li><a href="sair.php" accesskey="7" title=""><span>Sair</span></a></li>                                    
				</ul>
				</div>
				';
			break;											
													
	}
}
?>
