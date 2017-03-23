<?php
require_once "includes/functions.php";
session_start();

if (!empty($_POST['name']) and !empty($_POST['surname']) and !empty($_POST['type']) and !empty($_POST['mail']) and !empty($_POST['pass'])){
    /*
	$login = $_POST['login'];
    $password = $_POST['password'];
    $stmt = getDb()->prepare('select * from user where usr_login=? and usr_password=?');
    $stmt->execute(array($login, $password));
	
    if ($stmt->rowCount() == 1) {
        // Authentication successful
        $_SESSION['login'] = $login;
        redirect("index.php");
    }
    else {
        $error = "Utilisateur non reconnu";
    }
	*/
	
	$stmt = getDb()->prepare('INSERT INTO person(type_person, mail_person, name_person, surname_person, password_person) VALUES(:type, :mail, :name, :surname, :password)');
	$stmt->execute([
		'type' => $_POST['type'],
		'mail' => $_POST['mail'],
		'name' => $_POST['name'],
		'surname' => $_POST['surname'],
		'password' => $_POST['pass']
	]);
	$_SESSION['subscribe']="done";
	$_SESSION['mail'] = $_POST['mail'];
	$_SESSION['pass'] = $_POST['pass'];
	redirect("login.php");
}
?>

<!doctype html>
<html>

<?php 
$pageTitle = "Inscription";
require_once "includes/head.php";
?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

        <h2 class="text-center"><?= $pageTitle ?></h2>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger">
                <strong>Erreur !</strong> <?= $error ?>
            </div>
        <?php } ?>
        <div class="well">
            <form class="form-signin form-horizontal" role="form" action="register.php" method="post">            
				<div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<label for="surname">Prenom</label>
                    <input type="text" name="surname" id="surname" class="form-control" placeholder="Entrez votre prenom" required>
                    </div>
                </div>	
				<div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<label for="name">Nom</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Entrez votre nom" required autofocus>
                    </div>
                </div>				
				<div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-5 col-md-offset-4">
                    <input type="radio" name="type" id="etudiant" value="etudiant" required>
					<label for="etudiant">Etudiant de l'ENSC</label><br>
					<input type="radio" name="type" id="ancien_ad" value="ancien_ad"  >
					<label for="ancienAd">Ancien étudiant de l'ENSC adherent à l'ADCOG</label><br>
					<input type="radio" name="type" id="ancien_non_ad" value="ancien_non_ad" >
					<label for="ancienNonAd">Ancien étudiant de l'ENSC non-adherent à l'ADCOG</label><br>
					<input type="radio" name="type" id="pro" value="pro" >
					<label for="pro">Professionnel</label><br>
                    </div>
                </div>			
				<div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<label for="mail">E-mail</label>
                    <input type="email" name="mail" id="mail" class="form-control" placeholder="Entrez votre e-mail" required>
                    </div>
                </div>
				<div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<label for="pass">Mot de passe</label>
                    <input type="password" name="pass" id="pass" class="form-control" placeholder="Entrez votre mot de passe" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> S'enregister</button>
                    </div>
                </div>
            </form>
        </div>

        <?php require_once "includes/footer.php"; ?>
    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>