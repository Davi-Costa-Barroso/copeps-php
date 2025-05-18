<?php 
@session_start();

if (@$_SESSION['id'] == ""){
	echo '<script>window.location="../"</script>'; //redirecionamento via JS p/a o index.php tela de login.
	exit();
}



?>