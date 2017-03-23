<?php
require_once "includes/functions.php";
session_start();

$query="SELECT * FROM offer WHERE validation = 1";
$sorting="posting_date DESC";


if(isset($_GET['reset']))
{
	$_SESSION['sorting']=NULL;
	
	foreach($_SESSION as $key => $element)  
	{
		if(substr($key,0,6)=='filter') // takes all SESSION values which are filters, and store them into a new array
		{
			$element = null ;
			
		}
	}
}

if(!empty($_GET['sorting']))
{
	$_SESSION['sorting']=$_GET['sorting']; // if a custom sorting criteria is selected, it is stored in SESSION
}
if(isset($_SESSION['sorting']))$sorting=$_SESSION['sorting']; // and then in an intermediate value


if(!empty($_GET['filter_type'])) //  type restriction criteria
{
	$_SESSION['filter_type']=$_GET['filter_type'];
}

foreach($_SESSION as $key => $element)  
{
	if(substr($key,0,6)=='filter') // takes all SESSION values which are filters, and store them into a new array
	{
		$filters[$key]=$element;
	}
}


if(isset($filters))  // if the array containing filters criterias exists
{
	foreach($filters as $key => $element)  
	{
		$query.=$filters[$key];
	}
}

$query.=" ORDER BY ".$sorting;
$offers = getDb()->query($query); 
?>

<!doctype html>
<html>

<?php 
$pageTitle = "Liste offres";
require_once "includes/head.php"; 
?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>
		<p><h2>Liste des offres<h2></p>
		
		<section>
			<pre>
			<?php print_r($_SESSION); ?>
			</pre>
		</section>
		
		<form method="get" action="offers_list.php" onchange="this.submit();">	
			<p>
				<label for="filter_type">type de contrat</label><br/>
				<select class="selectpicker" name="filter_type" id="filter_type">
					<option value="none">Contrat</option>
					<option value=" ">Tous les types</option>					
					<option value=" AND type_offer = 'CDI'">CDI</option>
					<option value=" AND type_offer = 'CDD'">CDD</option>
					<option value=" AND type_offer = 'stage'">Stage</option>
				</select>
			</p>	
		</form>
		
		<form method="get" action="offers_list.php" onchange="this.submit();">	
			<p>
				<label for="sorting">Selectionnez un ordre de tri</label><br/>
				<select class="selectpicker" name="sorting" id="sorting">
					<option value="none"><?php echo $sorting ?></option>
					<option value="posting_date DESC">Date d'ajout: du plus au moins récent</option>
					<option value="posting_date">Date d'ajout : du moins au plus récent</option>
					<option value="title_offer">Nom offre: A-Z</option>
					<option value="title_offer DESC">Nom offre: Z-A</option>
					<option value="duration_offer">Durée de l'offre: ordre croissant</option>
					<option value="duration_offer DESC">Durée de l'offre: ordre décroissant</option>
					<option value="remuneration">Remuneration: ordre croissant</option>
					<option value="remuneration DESC">Remuneration: ordre decroissant</option>
					<option value="type_offer">Type d'offre: A-Z</option>
					<option value="type_offer DESC">Type d'offre: Z-A</option>
					<option value="country">Pays: A-Z</option>
					<option value="country DESC">Pays: Z-A</option>
					<option value="city">Ville: A-Z</option>
					<option value="city DESC">Ville: Z-A</option>
					<option value="sector">Secteur: A-Z</option>
					<option value="sector DESC">Secteur: Z-A</option>
					<option value="nb_candidacy">Nombre de candidature: ordre croissant</option>
					<option value="nb_candidacy DESC">Nombre de candidature: ordre décroissant</option>
				</select>
			</p>	
		</form>
		
		<form method="get" action="offers_list.php">
                <button type="submit" name="reset" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-refresh"></span> Reinitialiser les tris et filtres</button>
		</form>
		
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