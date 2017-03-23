<?php require_once "includes/functions.php"; ?>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-target">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-briefcase"></span> CogJob</a> <!-- Home page-->
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse-target">
            <?php if (!isUserConnected()) { ?>
                <ul class="nav navbar-nav ">
                    <li><a href="deposit_offer.php">Déposer une offre</a></li> <!-- Link to deposit form -->
					<?php }
						if (isUserConnected()) {  // content of header if a user is connected
							$userType=$_SESSION['userType']; 
							switch ($userType){  // content of header depending on the type of current connected user
								case "admin":
									echo '<ul class="nav navbar-nav ">
                                    <li><a href="offers_list.php">Consulter les offres</a></li>'; // link to offers list
									echo '<li><a href="validation.php">Validation d\'offres</a></li>';
                                    echo '<li><a href="deposit_offer.php">Déposer une offre</a></li>
                                    </ul>';
									break;								
								case "pro":
									echo '<ul class="nav navbar-nav ">
									<li><a href="offers_list.php">Consulter les offres</a></li>'; // link to offers list
									echo '<li><a href="tableau_de_bord.php">tableau de bord</a></li> 
									</ul>'; 
									break;								
								case "ancien_ad":
									echo '<ul class="nav navbar-nav ">
									<li><a href="offers_list.php">Consulter les offres</a></li>
									</ul>';
									break;									
								case "ancien_non_ad":
									echo '<ul class="nav navbar-nav ">
									<li><a href="offers_list.php">Consulter les offres</a></li>
									</ul>';
									break;									
								case "etudiant":
									echo '<ul class="nav navbar-nav ">
									<li><a href="offers_list.php">Consulter les offres</a></li>
									</ul>';
									break;									
							}	
                    ?>
                </ul>
            <?php } ?>
            <ul class="nav navbar-nav navbar-right">
                <?php if (isUserConnected()) { // if a user is connected ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <!--affiche bienvenu et le nom de l'utilisateur -->
                            <span class="glyphicon glyphicon-user"></span> Bienvenue, <?= $_SESSION['currentName'] ?> <b class="caret"></b>
                        </a>
						
						<?php $userType=$_SESSION['userType'];					
						switch ($userType){   // Display a drop down menu with options depending on the type of current connected user
								case "admin": ?>
									<ul class="dropdown-menu">
										<li><a href="back_office.php">Back office</a></li>
										<li><a href="account.php">Mon compte</a></li>
										<li><a href="logout.php">Se déconnecter</a></li>
									</ul>
									<?php break;
								case "pro": ?>
									<ul class="dropdown-menu">
										<li><a href="account.php">Mon compte</a></li>
										<li><a href="logout.php">Se déconnecter</a></li>
									</ul>
									<?php break;								
								case "ancien_ad": ?>
									<ul class="dropdown-menu">
										<li><a href="account.php">Mon compte</a></li>
										<li><a href="logout.php">Se déconnecter</a></li>
									</ul>
									<?php break;									
								case "ancien_non_ad": ?>
									<ul class="dropdown-menu">
										<li><a href="account.php">Mon compte</a></li>
										<li><a href="logout.php">Se déconnecter</a></li>
									</ul>
									<?php break;									
								case "etudiant": ?>
									<ul class="dropdown-menu">
										<li><a href="account.php">Mon compte</a></li>
										<li><a href="logout.php">Se déconnecter</a></li>
									</ul>
									<?php break;									
							}
						?>     
                    </li>
                <?php } else { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span> Non connecté <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="login.php">Se connecter</a></li>
							<li><a href="register.php">S'inscrire</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div><!-- /.container -->
</nav>
