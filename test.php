<?php
	include 'setup.php';

	$objBD	=	 new db(array('host'=>'192.168.1.107','user'=>'root','pass'=>'root'));

	echo $objBD->getHost().'<br>';
	echo $objBD->getUser().'<br>';
	echo $objBD->getPass().'<br>';
	
	if($objBD->connect('dbremota'))
		echo "Conectado a ".$objBD->getDB().'<br>';

	
	$objBD->close();
	if($objBD->connect())
		echo "Conectado a ".$objBD->getDB().'<br>';
	
	$query	=	"SELECT * From table";
	if ($rsQuery =	$objBD->executeQuery($query)) {
		echo $objBD->getNumRows($rsQuery)." registros obtenidos<br>";
		while ($fila = $objBD->getDataArray($rsQuery,0)) {
			echo $fila['campo1'].'-';
			echo $fila['campo2'].'-';
			echo $fila['campo3'].'<br>';
		}
	}

	/*Conexión a multiples BD*/
	$objBD2	=	 new db(array('host'=>'localhost','user'=>'root','pass'=>''));
	echo $objBD2->getHost().'<br>';
	echo $objBD2->getUser().'<br>';
	echo $objBD2->getPass().'<br>';
	
	if($objBD2->connect('bdlocal'))
		echo "Conectado a ".$objBD2->getDB().'<br>';