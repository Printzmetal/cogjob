<?php
require_once "includes/functions.php";
session_start();

if (isset($_POST['title_offer'])) {
    // the offer form has been posted : retrieve offer parameters
    $title = escape($_POST['title_offer']);
    $shortDescription = escape($_POST['shortDescription']); 
    $longDescription = escape($_POST['longDescription']);
    $remuneration = escape($_POST['remuneration']);
    $city = escape($_POST['city']);
    $duration_offer=escape($_POST['duration_offer']);
    $nb_candidacy=0;
    $posting_date= date("Y-m-d");
    $validation=false;
    $password=createPassword(10);
    $name_company=escape($_POST['name_company']);
    $mail_company=escape($_POST['mail_company']);
    $adress_company=escape($_POST['address_company']);
    
    $companys = getDb()->query('SELECT * FROM offer ORDER BY id_offer DESC LIMIT 0, 1');
    foreach ($companys as $company)
    $id_company=$company['id_company']+1;
    
    
    $tmpFile = $_FILES['file']['tmp_name'];
    if (is_uploaded_file($tmpFile)) {
        // upload file fichier
        $fichier = basename($_FILES['file']['name']);
        $uploadedFile = "files/$fichier";
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFile);

    }  
    
    // insert offer into BD
    $stmt2 = getDb()->prepare('INSERT INTO company (name_company,mail_company,address_company) 
        values (?, ?, ?)');
    $stmt2->execute(array($name_company,$mail_company,$adress_company));
    
    $stmt = getDb()->prepare('INSERT INTO offer (type_offer, title_offer, desc_short, desc_long, remuneration, duration_offer, sector, country, region, city, posting_date,limit_date, nb_candidacy, validation, password, id_company) 
        values (?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?)');
    $stmt->execute(array($_POST['type_offer'],$title, $shortDescription, $longDescription,$remuneration,$duration_offer,$_POST['sector'],$_POST['country'],$_POST['region'],$city,$posting_date,$_POST['limit_date'],$nb_candidacy,$validation,$password,$id_company));
    
    
    
    
    redirect("index.php");
}
?>
<!doctype html>
<html>

    <?php 
    $pageTitle = "Ajout d'une offre";
    require_once "includes/head.php"; 
    ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?>          

            <h2 class="text-center">Ajout d'une offre d'emploi</h2>
            <div class="well">
                <form class="form-horizontal" role="form" enctype="multipart/form-data" action="deposit_offer.php" method="post">
                    <input type="hidden" name="id_offer" value="<?php $id_offer ?>">
                    <input type="hidden" name="id_company" value="<?php $id_company ?>">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Type de contrat</label>
                        <div class="col-sm-6">
                            <select name="type_offer" value="<?php $type_offer ?>">
                                <option value="CDI">CDI</option>
                                <option value="CDD ">CDD</option>
                                <option value="Stage">Stage</option>                            
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Intitulé de l'offre</label>
                        <div class="col-sm-5">
                            <input type="text" name="title_offer" value="<?php $title_offer ?>" class="form-control" placeholder="Entrez le titre de l'offre" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Secteur de travail</label>
                        <div class="col-sm-6">
                            <select name="sector" value="<?php $sector ?>">
                                <option value="Agriculture">Agriculture</option>
                                <option value="Agroalimentaire-Alimentation">Agroalimentaire - Alimentation</option>
                                <option value="Animaux">Animaux</option>
                                <option value="Architecture-Aménagement intérieur">Architecture - Aménagement intérieur</option>
                                <option value="Artisanat-Métiers d'art">Artisanat - Métiers d'art</option>
                                <option value="Banque-Finance-Assurance">Banque - Finance - Assurance</option>
                                <option value="Bâtiment-Travaux publics">Bâtiment - Travaux publics</option>
                                <option value="Biologie-Chimie">Biologie - Chimie</option>
                                <option value="Commerce-Immobilier">Commerce - Immobilier</option>
                                <option value="Communication-Information">Communication - Information</option>
                                <option value="Culture-Spectacle">Culture - Spectacle</option>
                                <option value="Défense-Sécurité-">Défense - Sécurité</option>
                                <option value="Droit">Droit</option>
                                <option value="Edition-Imprimerie-Livre">Edition - Imprimerie - Livre</option>
                                <option value="Electronique">Electronique</option>
                                <option value="Informatique">Informatique</option>                   
                                <option value="Enseignement-Formation">Enseignement - Formation</option>
                                <option value="Environnement-Nature-Nettoyage">Environnement - Nature - Nettoyage</option>
                                <option value="Gestion-Audit-Ressources humaines">Gestion - Audit - Ressources humaines</option>
                                <option value="Hôtellerie-Restauration-Tourisme">Hôtellerie - Restauration - Tourisme</option>
                                <option value="Humanitaire">Humanitaire</option>
                                <option value="Industrie-Matériaux">Industrie - Matériaux</option>
                                <option value="Lettres-Sciences humaines">Lettres - Sciences humaines</option>
                                <option value="Mécanique-Maintenance">Mécanique - Maintenance</option>
                                <option value="Numérique-Multimédia-Audiovisuel">Numérique - Multimédia - Audiovisuel</option>
                                <option value="Santé">Santé</option>
                                <option value="Sciences-Maths-Physique">Sciences - Maths - Physique</option>
                                <option value="Secours">Secours</option>
                                <option value="Secrétariat-Accueil">Secrétariat - Accueil</option>
                                <option value="Social-Services à la personne">Social - Services à la personne</option>
                                <option value="Soins-Esthétique-Coiffure">Soins - Esthétique - Coiffure</option>
                                <option value="Sport-Animation">Sport - Animation</option>
                                <option value="Transport-Logistique">Transport - Logistique</option>                  
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Description courte</label>
                        <div class="col-sm-5">
                            <textarea name="shortDescription" class="form-control" placeholder="Entrez sa description courte" required><?php $shortDescription ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Description longue</label>
                        <div class="col-sm-5">
                            <textarea name="longDescription" class="form-control" rows="6" placeholder="Entrez sa description longue" required><?php $longDescription ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Mail</label>
                        <div class="col-sm-8">
                            <input type="text" name="mail_company" value="<?php $mail_company ?>" class="form-control" placeholder="Entrez le mail sous lequel les candidats vous contacteront" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Entreprise</label>
                        <div class="col-sm-5">
                            <input type="text" name="name_company" value="<?php $name_company ?>" class="form-control" placeholder="Entrez le nom de l'entreprise" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Adresse de l'entreprise</label>
                        <div class="col-sm-5">
                            <input type="text" name="address_company" value="<?php $address_company ?>" class="form-control" placeholder="Entrez l'adresse de l'entreprise" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Rémunération</label>
                        <div class="col-sm-5">
                            <input type="number" name="remuneration" value="<?php $remuneration ?>" class="form-control" placeholder="Entrez le salaire à l'embauche" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Durée du contrat</label>
                        <div class="col-sm-7">
                            <input type="text" name="duration_offer" value="<?php $duration_offer ?>" //class="form-control" placeholder="Entrez la durée du contrat de type x mois ou x années" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Envoyez votre CV ci-joint</label>
                        <div class="col-sm-4">
                            <input type="file" name="file"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Pays d'embauche</label>
                        <div class="col-sm-6">
                            <select name="country" value="<?php $country ?>">
                                <optgroup label="Afrique">
                                    <option value="afriqueDuSud">Afrique Du Sud</option>
                                    <option value="algerie">Algérie</option>
                                    <option value="angola">Angola</option>
                                    <option value="benin">Bénin</option>
                                    <option value="botswana">Botswana</option>
                                    <option value="burkina">Burkina</option>
                                    <option value="burundi">Burundi</option>
                                    <option value="cameroun">Cameroun</option>
                                    <option value="capVert">Cap-Vert</option>
                                    <option value="republiqueCentre-Africaine">République Centre-Africaine</option>
                                    <option value="comores">Comores</option>
                                    <option value="republiqueDemocratiqueDuCongo">République Démocratique Du Congo</option>
                                    <option value="congo">Congo</option>
                                    <option value="coteIvoire">Côte d'Ivoire</option>
                                    <option value="djibouti">Djibouti</option>
                                    <option value="egypte">Égypte</option>
                                    <option value="ethiopie">Éthiopie</option>
                                    <option value="erythrée">Érythrée</option>
                                    <option value="gabon">Gabon</option>
                                    <option value="gambie">Gambie</option>
                                    <option value="ghana">Ghana</option>
                                    <option value="guinee">Guinée</option>
                                    <option value="guinee-Bisseau">Guinée-Bisseau</option>
                                    <option value="guineeEquatoriale">Guinée Équatoriale</option>
                                    <option value="kenya">Kenya</option>
                                    <option value="lesotho">Lesotho</option>
                                    <option value="liberia">Liberia</option>
                                    <option value="libye">Libye</option>
                                    <option value="madagascar">Madagascar</option>
                                    <option value="malawi">Malawi</option>
                                    <option value="mali">Mali</option>
                                    <option value="maroc">Maroc</option>
                                    <option value="maurice">Maurice</option>
                                    <option value="mauritanie">Mauritanie</option>
                                    <option value="mozambique">Mozambique</option>
                                    <option value="namibie">Namibie</option>
                                    <option value="niger">Niger</option>
                                    <option value="nigeria">Nigeria</option>
                                    <option value="ouganda">Ouganda</option>
                                    <option value="rwanda">Rwanda</option>
                                    <option value="saoTomeEtPrincipe">Sao Tomé-et-Principe</option>
                                    <option value="senegal">Séngal</option>
                                    <option value="seychelles">Seychelles</option>
                                    <option value="sierra">Sierra</option>
                                    <option value="somalie">Somalie</option>
                                    <option value="soudan">Soudan</option>
                                    <option value="swaziland">Swaziland</option>
                                    <option value="tanzanie">Tanzanie</option>
                                    <option value="tchad">Tchad</option>
                                    <option value="togo">Togo</option>
                                    <option value="tunisie">Tunisie</option>
                                    <option value="zambie">Zambie</option>
                                    <option value="zimbabwe">Zimbabwe</option>
                                </optgroup>
                                <optgroup label="Amérique">
                                    <option value="antiguaEtBarbuda">Antigua-et-Barbuda</option>
                                    <option value="argentine">Argentine</option>
                                    <option value="bahamas">Bahamas</option>
                                    <option value="barbade">Barbade</option>
                                    <option value="belize">Belize</option>
                                    <option value="bolivie">Bolivie</option>
                                    <option value="bresil">Brésil</option>
                                    <option value="canada">Canada</option>
                                    <option value="chili">Chili</option>
                                    <option value="colombie">Colombie</option>
                                    <option value="costaRica">Costa Rica</option>
                                    <option value="cuba">Cuba</option>
                                    <option value="republiqueDominicaine">République Dominicaine</option>
                                    <option value="dominique">Dominique</option>
                                    <option value="equateur">Équateur</option>
                                    <option value="etatsUnis">États Unis</option>
                                    <option value="grenade">Grenade</option>
                                    <option value="guatemala">Guatemala</option>
                                    <option value="guyana">Guyana</option>
                                    <option value="haiti">Haïti</option>
                                    <option value="honduras">Honduras</option>
                                    <option value="jamaique">Jamaïque</option>
                                    <option value="mexique">Mexique</option>
                                    <option value="nicaragua">Nicaragua</option>
                                    <option value="panama">Panama</option>
                                    <option value="paraguay">Paraguay</option>
                                    <option value="perou">Pérou</option>
                                    <option value="saintCristopheEtNieves">Saint-Cristophe-et-Niévès</option>
                                    <option value="sainteLucie">Sainte-Lucie</option>
                                    <option value="saintVincentEtLesGrenadines">Saint-Vincent-et-les-Grenadines</option>
                                    <option value="salvador">Salvador</option>
                                    <option value="suriname">Suriname</option>
                                    <option value="triniteEtTobago">Trinité-et-Tobago</option>
                                    <option value="uruguay">Uruguay</option>
                                    <option value="venezuela">Venezuela</option>
                                </optgroup>
                                <optgroup label="Asie">
                                    <option value="afghanistan">Afghanistan</option>
                                    <option value="arabieSaoudite">Arabie Saoudite</option>
                                    <option value="armenie">Arménie</option>
                                    <option value="azerbaidjan">Azerbaïdjan</option>
                                    <option value="bahrein">Bahreïn</option>
                                    <option value="bangladesh">Bangladesh</option>
                                    <option value="bhoutan">Bhoutan</option>
                                    <option value="birmanie">Birmanie</option>
                                    <option value="brunei">Brunéi</option>
                                    <option value="cambodge">Cambodge</option>
                                    <option value="chine">Chine</option>
                                    <option value="coreeDuSud">Corée Du Sud</option>
                                    <option value="coreeDuNord">Corée Du Nord</option>
                                    <option value="emiratsArabeUnis">Émirats Arabe Unis</option>
                                    <option value="georgie">Géorgie</option>
                                    <option value="inde">Inde</option>
                                    <option value="indonesie">Indonésie</option>
                                    <option value="iraq">Iraq</option>
                                    <option value="iran">Iran</option>
                                    <option value="israel">Israël</option>
                                    <option value="japon">Japon</option>
                                    <option value="jordanie">Jordanie</option>
                                    <option value="kazakhstan">Kazakhstan</option>
                                    <option value="kirghistan">Kirghistan</option>
                                    <option value="koweit">Koweït</option>
                                    <option value="laos">Laos</option>
                                    <option value="liban">Liban</option>
                                    <option value="malaisie">Malaisie</option>
                                    <option value="maldives">Maldives</option>
                                    <option value="mongolie">Mongolie</option>
                                    <option value="nepal">Népal</option>
                                    <option value="oman">Oman</option>
                                    <option value="ouzbekistan">Ouzbékistan</option>
                                    <option value="pakistan">Pakistan</option>
                                    <option value="philippines">Philippines</option>
                                    <option value="qatar">Qatar</option>
                                    <option value="singapour">Singapour</option>
                                    <option value="sriLanka">Sri Lanka</option>
                                    <option value="syrie">Syrie</option>
                                    <option value="tadjikistan">Tadjikistan</option>
                                    <option value="taiwan">Taïwan</option>
                                    <option value="thailande">Thaïlande</option>
                                    <option value="timorOriental">Timor oriental</option>
                                    <option value="turkmenistan">Turkménistan</option>
                                    <option value="turquie">Turquie</option>
                                    <option value="vietNam">Viêt Nam</option>
                                    <option value="yemen">Yemen</option>
                                </optgroup>
                                <optgroup label="Europe">
                                    <option value="allemagne">Allemagne</option>
                                    <option value="albanie">Albanie</option>
                                    <option value="andorre">Andorre</option>
                                    <option value="autriche">Autriche</option>
                                    <option value="bielorussie">Biélorussie</option>
                                    <option value="belgique">Belgique</option>
                                    <option value="bosnieHerzegovine">Bosnie-Herzégovine</option>
                                    <option value="bulgarie">Bulgarie</option>
                                    <option value="croatie">Croatie</option>
                                    <option value="danemark">Danemark</option>
                                    <option value="espagne">Espagne</option>
                                    <option value="estonie">Estonie</option>
                                    <option value="finlande">Finlande</option>
                                    <option value="france">France</option>
                                    <option value="grece">Grèce</option>
                                    <option value="hongrie">Hongrie</option>
                                    <option value="irlande">Irlande</option>
                                    <option value="islande">Islande</option>
                                    <option value="italie">Italie</option>
                                    <option value="lettonie">Lettonie</option>
                                    <option value="liechtenstein">Liechtenstein</option>
                                    <option value="lituanie">Lituanie</option>
                                    <option value="luxembourg">Luxembourg</option>
                                    <option value="exRepubliqueYougoslaveDeMacedoine">Ex-République Yougoslave de Macédoine</option>
                                    <option value="malte">Malte</option>
                                    <option value="moldavie">Moldavie</option>
                                    <option value="monaco">Monaco</option>
                                    <option value="norvege">Norvège</option>
                                    <option value="paysBas">Pays-Bas</option>
                                    <option value="pologne">Pologne</option>
                                    <option value="portugal">Portugal</option>
                                    <option value="roumanie">Roumanie</option>
                                    <option value="royaumeUni">Royaume-Uni</option>
                                    <option value="russie">Russie</option>
                                    <option value="saintMarin">Saint-Marin</option>
                                    <option value="serbieEtMontenegro">Serbie-et-Monténégro</option>
                                    <option value="slovaquie">Slovaquie</option>
                                    <option value="slovenie">Slovénie</option>
                                    <option value="suede">Suède</option>
                                    <option value="suisse">Suisse</option>
                                    <option value="republiqueTcheque">République Tchèque</option>
                                    <option value="ukraine">Ukraine</option>
                                    <option value="vatican">Vatican</option>
                                </optgroup>
                                <optgroup label="Océanie">
                                    <option value="australie">Australie</option>
                                    <option value="fidji">Fidji</option>
                                    <option value="kiribati">Kiribati</option>
                                    <option value="marshall">Marshall</option>
                                    <option value="micronesie">Micronésie</option>
                                    <option value="nauru">Nauru</option>
                                    <option value="nouvelleZelande">Nouvelle-Zélande</option>
                                    <option value="palaos">Palaos</option>
                                    <option value="papouasieNouvelleGuinee">Papouasie-Nouvelle-Guinée</option>
                                    <option value="salomon">Salomon</option>
                                    <option value="samoa">Samoa</option>
                                    <option value="tonga">Tonga</option>
                                    <option value="tuvalu">Tuvalu</option>
                                    <option value="vanuatu">Vanuatu</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Région d'embauche</label>
                        <div class="col-sm-6">
                            <select name="region" value="<?php region ?>">
                                <option value="00">00 - Etranger</option>
                                <option value="01">01 - Ain</option>
                                <option value="02">02 - Aisne</option>
                                <option value="03">03 - Allier</option>
                                <option value="04">04 - Alpes-de-Haute-Provence</option>
                                <option value="05">05 - Hautes-Alpes</option>
                                <option value="06">06 - Alpes-Maritimes</option>
                                <option value="07">07 - Ardeche</option>
                                <option value="08">08 - Ardennes</option>
                                <option value="09">09 - Ariege</option>
                                <option value="10">10 - Aube</option>
                                <option value="11">11 - Aude</option>
                                <option value="12">12 - Aveyron</option>
                                <option value="13">13 - Bouches-du-Rhone</option>
                                <option value="14">14 - Calvados</option>
                                <option value="15">15 - Cantal</option>
                                <option value="16">16 - Charente</option>
                                <option value="17">17 - Charente-Maritime</option>
                                <option value="18">18 - Cher</option>
                                <option value="19">19 - Correze</option>
                                <option value="2A">2A - Corse-du-Sud</option>
                                <option value="2B">2B - Haute-Corse</option>
                                <option value="21">21 - Cote-d'Or</option>
                                <option value="22">22 - Cotes-d'Armor</option>
                                <option value="23">23 - Creuse</option>
                                <option value="24">24 - Dordogne</option>
                                <option value="25">25 - Doubs</option>
                                <option value="26">26 - Drome</option>
                                <option value="27">27 - Eure</option>
                                <option value="28">28 - Eure-et-Loir</option>
                                <option value="29">29 - Finistere</option>
                                <option value="30">30 - Gard</option>
                                <option value="31">31 - Haute-Garonne</option>
                                <option value="32">32 - Gers</option>
                                <option value="33">33 - Gironde</option>
                                <option value="34">34 - Herault</option>
                                <option value="35">35 - Ille-et-Vilaine</option>
                                <option value="36">36 - Indre</option>
                                <option value="37">37 - Indre-et-Loire</option>
                                <option value="38">38 - Isere</option>
                                <option value="39">39 - Jura</option>
                                <option value="40">40 - Landes</option>
                                <option value="41">41 - Loir-et-Cher</option>
                                <option value="42">42 - Loire</option>
                                <option value="43">43 - Haute-Loire</option>
                                <option value="44">44 - Loire-Atlantique</option>
                                <option value="45">45 - Loiret</option>
                                <option value="46">46 - Lot</option>
                                <option value="47">47 - Lot-et-Garonne</option>
                                <option value="48">48 - Lozere</option>
                                <option value="49">49 - Maine-et-Loire</option>
                                <option value="50">50 - Manche</option>
                                <option value="51">51 - Marne</option>
                                <option value="52">52 - Haute-Marne</option>
                                <option value="53">53 - Mayenne</option>
                                <option value="54">54 - Meurthe-et-Moselle</option>
                                <option value="55">55 - Meuse</option>
                                <option value="56">56 - Morbihan</option>
                                <option value="57">57 - Moselle</option>
                                <option value="58">58 - Nievre</option>
                                <option value="59">59 - Nord</option>
                                <option value="60">60 - Oise</option>
                                <option value="61">61 - Orne</option>
                                <option value="62">62 - Pas-de-Calais</option>
                                <option value="63">63 - Puy-de-Dome</option>
                                <option value="64">64 - Pyrenees-Atlantiques</option>
                                <option value="35">65 - Hautes-Pyrenees</option>
                                <option value="66">66 - Pyrenees-Orientales</option>
                                <option value="67">67 - Bas-Rhin</option>
                                <option value="68">68 - Haut-Rhin</option>
                                <option value="69">69 - Rhone</option>
                                <option value="70">70 - Haute-Saone</option>
                                <option value="71">71 - Saone-et-Loire</option>
                                <option value="72">72 - Sarthe</option>
                                <option value="73">73 - Savoie</option>
                                <option value="74">74 - Haute-Savoie</option>
                                <option value="75">75 - Paris</option>
                                <option value="76">76 - Seine-Maritime</option>
                                <option value="77">77 - Seine-et-Marne</option>
                                <option value="78">78 - Yvelines</option>
                                <option value="79">79 - Deux-Sevres</option>
                                <option value="80">80 - Somme</option>
                                <option value="81">81 - Tarn</option>
                                <option value="82">82 - Tarn-et-Garonne</option>
                                <option value="83">83 - Var</option>
                                <option value="84">84 - Vaucluse</option>
                                <option value="85">85 - Vendee</option>
                                <option value="86">86 - Vienne</option>
                                <option value="87">87 - Haute-Vienne</option>
                                <option value="88">88 - Vosges</option>
                                <option value="89">89 - Yonne</option>
                                <option value="90">90 - Territoire de Belfort</option>
                                <option value="91">91 - Essonne</option>
                                <option value="92">92 - Hauts-de-Seine</option>
                                <option value="93">93 - Seine-Saint-Denis</option>
                                <option value="94">94 - Val-de-Marne</option>
                                <option value="95">95 - Val-d'Oise</option>
                                <option value="971">971 - Guadeloupe</option>
                                <option value="972">972 - Martinique</option>
                                <option value="973">973 - Guyane</option>
                                <option value="974">974 - Réunion</option>
                                <option value="975">975 - Saint-Pierre-et-Miquelon</option>
                                <option value="984">984 - Terres-australes-et-antarctiques-françaises</option>
                                <option value="985">985 - Mayotte</option>
                                <option value="986">986 - Wallis-et-Futuna</option>
                                <option value="987">987 - Polynesie-franeaise</option>
                                <option value="988">988 - Nouvelle-Caledonie</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Ville d'embauche</label>
                        <div class="col-sm-5">
                            <input type="text" name="city" value="<?php $city ?>" class="form-control" placeholder="Entrez la ville d'embauche" required autofocus>
                        </div>
                    </div>
                     
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Date limite au bout de laquelle l'offre sera supprimée</label>
                        <div class="col-sm-4">
                            <input type="date" name="limit_date" value="<?php $limit_date ?>" class="form-control" placeholder="Entrez la date limite" required>
                        </div>
                    </div>                            
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4">
                            <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
                        </div>
                    </div>
                </form> 
            </div>

            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>