<?php
require_once "includes/functions.php";
session_start();

if (!empty($_POST['mail']) and !empty($_POST['password'])) {
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $stmt = getDb()->prepare('SELECT * FROM person WHERE mail_person=? AND password_person=?');
    $stmt->execute(array($mail, $password));
    if ($stmt->rowCount() == 1) {
        // Authentication successful
        $_SESSION['mail'] = $mail;
		$currentUser = $stmt->fetch();
		$_SESSION['userType'] = $currentUser['type_person'];
		$_SESSION['currentName'] = $currentUser['surname_person'];
        redirect("index.php");
    }
    else {
        $error = "Utilisateur non reconnu";
    }
}
?>

<!doctype html>
<html>

<?php 
$pageTitle = "Connexion";
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
		
		<?php if (isset($_SESSION['subscribe'])) { ?> 
            <div class="alert alert-success"> 
                <strong>Felicitation !</strong> vous êtes desormais inscrit sur CogJob <br/>
				<p>Vous pouvez dès maintenant vous connecter avec votre adresse mail <br/>
				</p>Votre mot de passe est: <?php echo $_SESSION['pass']; ?>
            </div>
        <?php } ?>
		
        <div class="well">
            <form class="form-signin form-horizontal" role="form" action="login.php" method="post">
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <input type="text" name="mail" class="form-control" placeholder="Entrez votre adresse mail" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                    </div>
                </div>			
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Se connecter</button>
                    </div>
                </div>
            </form>
        </div>

        <?php require_once "includes/footer.php"; ?>
    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>