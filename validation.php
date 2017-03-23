<?php
require_once "includes/functions.php";
session_start();

$query="SELECT * FROM offer WHERE validation = 0";
$offers = getDb()->query($query); 
?>

<!doctype html>
<html>

<?php 
$pageTitle = "Validation offres";
require_once "includes/head.php"; 
?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>
		<p><h2>Validation des offres<h2></p>
		
		
        <?php foreach ($offers as $offer) { ?>
            <article id="one_offer">
                <h3><a class="title_offer" href="offer.php?id=<?= $offer['id_offer'] ?>"><?= $offer['title_offer'] ?></a></h3>
				<p class="detail_offer"><?= $offer['city'] ?></p>
				<p class="detail_offer"><?= $offer['type_offer'] ?></p>
				<p class="detail_offer"><?= $offer['posting_date'] ?></p>
                <p class="content_offer"><?= $offer['desc_short'] ?></p>
            </article>
			</br>
        <?php } ?>

        <?php require_once "includes/footer.php"; ?>
    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>