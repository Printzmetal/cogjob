<?php
require_once "includes/functions.php";
session_start();

$id_offer = $_GET['id'];
$stmt = getDb()->prepare('SELECT * FROM offer WHERE id_offer=?');
$stmt->execute(array($id_offer));
$offer = $stmt->fetch(); // Access first (and only) result line


if(isset($_POST['apply']))
{
	$apply_ok="Vous avez bien postulé à cette offre";
}
?>

<!doctype html>
<html>

<?php 
$pageTitle = $offer['title_offer'];
require_once "includes/head.php"; 
?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>
		
		
		<?php if (isset($apply_ok)) { ?>
            <div class="alert alert-info">
                <h3 class="text-center"><?= $apply_ok ?></h3>
            </div>
        <?php } ?>
		
		
        <div class="row">
            <div class="col-md-7 col-sm-5">
                <h2><?= $offer['title_offer'] ?></h2>
                <p>Secteur: <?= $offer['sector'] ?></p>
				<p>Rémunération:  <?= $offer['remuneration'] ?>€</p>
				<p>Type de contrat:  <?= $offer['type_offer'] ?></p>
				<p>Durée: <?= $offer['duration_offer'] ?> mois</p>
				<br/>
				<p>Pays:  <?= $offer['country'] ?></p>
				<p>Région:  <?= $offer['region'] ?></p>
				<p>Ville: <?= $offer['city'] ?></p>
				<br/>
				<p>Nombre de candidature actuel: <?= $offer['nb_candidacy'] ?></p>
				<p>Date de mise en ligne: <?= $offer['posting_date'] ?></p>
				<br/>
                <p id="one_offer"> <?= $offer['desc_long'] ?></p>
                <br/>
				<form method="post" action="offer.php">
					<button type="submit" name="save" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Sauvegarder cette offre</button>
				</form>
				<form method="post" action="offer.php?id=<?= $offer['id_offer'] ?>">
					<button type="submit" name="apply" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-paste"></span> Postuler à cette offre</button>
				</form>
				<br/>
				<form method="post" action="modify_offer.php">
					<button type="submit" name="modify" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-cog"></span> Modifier cette offre</button>
				</form>
            </div>
        </div>


    <?php require_once "includes/footer.php"; ?>
</div>

<?php require_once "includes/scripts.php"; ?>
</body>

</html>