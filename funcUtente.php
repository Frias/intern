<?php
function tipoCartUt($tipoCartUt_tmp){
	if($tipoCartUt_tmp=="SS"){
	   echo'
		   <option value="SS" selected="selected">Segurança Social</option>
			<option value="ADSE">ADSE</option>
			<option value="MEDIS">MEDIS</option>';
	 }elseif($tipoCartUt_tmp=="ADSE"){
		  echo '<option value="SS">Segurança Social</option>
			<option value="ADSE" selected="selected">ADSE</option>
			<option value="MEDIS">MEDIS</option>';
	 }else{
		  echo '<option value="SS">Segurança Social</option>
			<option value="ADSE">ADSE</option>
			<option value="MEDIS" selected="selected">MEDIS</option>';						 
	 }
}


function tipoSangue($tipoSangue_tmp){
if($tipoSangue_tmp==""){
   echo'
   <option value="naoSabe" selected="selected"></option>
   <option value="O-">O-</option>    
   <option value="O+">O+</option>
   <option value="A-">A-</option>
   <option value="A+">A+</option>
   <option value="B-">B-</option>
   <option value="B+">B+</option>
   <option value="AB-">AB-</option>
   <option value="AB+">AB+</option>';
  }elseif($tipoSangue_tmp=="O-"){
   echo'
   <option value="naoSabe"></option>
   <option value="O-" selected="selected">O-</option>    
   <option value="O+">O+</option>
   <option value="A-">A-</option>
   <option value="A+">A+</option>
   <option value="B-">B-</option>
   <option value="B+">B+</option>
   <option value="AB-">AB-</option>
   <option value="AB+">AB+</option>';	
  }elseif($tipoSangue_tmp=="O+"){
   echo'
   <option value="naoSabe"></option>
   <option value="O-">O-</option>    
   <option value="O+" selected="selected">O+</option>
   <option value="A-">A-</option>
   <option value="A+">A+</option>
   <option value="B-">B-</option>
   <option value="B+">B+</option>
   <option value="AB-">AB-</option>
   <option value="AB+">AB+</option>';	
  }elseif($tipoSangue_tmp=="A-"){
   echo'
   <option value="naoSabe"></option>
   <option value="O-">O-</option>    
   <option value="O+">O+</option>
   <option value="A-" selected="selected">A-</option>
   <option value="A+">A+</option>
   <option value="B-">B-</option>
   <option value="B+">B+</option>
   <option value="AB-">AB-</option>
   <option value="AB+">AB+</option>';	
  }elseif($tipoSangue_tmp=="A+"){
   echo'
   <option value="naoSabe"></option>
   <option value="O-">O-</option>    
   <option value="O+">O+</option>
   <option value="A-">A-</option>
   <option value="A+" selected="selected">A+</option>
   <option value="B-">B-</option>
   <option value="B+">B+</option>
   <option value="AB-">AB-</option>
   <option value="AB+">AB+</option>';	
  }elseif($tipoSangue_tmp=="B-"){
   echo'
   <option value="naoSabe"></option>
   <option value="O-">O-</option>    
   <option value="O+">O+</option>
   <option value="A-">A-</option>
   <option value="A+">A+</option>
   <option value="B-" selected="selected">B-</option>
   <option value="B+">B+</option>
   <option value="AB-">AB-</option>
   <option value="AB+">AB+</option>';						   					   					   					   					  					  }elseif($tipoSangue_tmp=="B+"){
   echo'
   <option value="naoSabe"></option>
   <option value="O-">O-</option>    
   <option value="O+">O+</option>
   <option value="A-">A-</option>
   <option value="A+">A+</option>
   <option value="B-">B-</option>
   <option value="B+" selected="selected">B+</option>
   <option value="AB-">AB-</option>
   <option value="AB+">AB+</option>';	
  }elseif($tipoSangue_tmp=="AB-"){
   echo'
   <option value="naoSabe"></option>
   <option value="O-">O-</option>    
   <option value="O+">O+</option>
   <option value="A-">A-</option>
   <option value="A+">A+</option>
   <option value="B-">B-</option>
   <option value="B+">B+</option>
   <option value="AB-" selected="selected">AB-</option>
   <option value="AB+">AB+</option>';	
  }else{
   echo'
   <option value="naoSabe"></option>
   <option value="O-">O-</option>    
   <option value="O+">O+</option>
   <option value="A-">A-</option>
   <option value="A+">A+</option>
   <option value="B-">B-</option>
   <option value="B+">B+</option>
   <option value="AB-">AB-</option>
   <option value="AB+" selected="selected">AB+</option>';
  }	
}
?>