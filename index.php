<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/reset.css">		
		<link rel="stylesheet" href="css/style.css">
		<?php include('meta.html') ?>		
	</head>
	<body>
		<?php include('header.html') ?>


<?php
			function assain($argument){
				$argument = strip_tags(trim($argument));
				return $argument;
			};

			function isValidMail($argument){
				return filter_var($argument, FILTER_VALIDATE_EMAIL);
			};

			$mois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");


			$configErrors = array(
				'prenom' => "Tu as oublié d'indiqué ton prénom",
				'nom' => "Tu as oublié d'indiqué ton nom",
				'mail' => "Tu as oublié d'indiqué ton mail",
				'invalidMail' => "Adresse mail invalide",
				'naissance' => "Tu as oublié d'indiqué ta date de naissance",
				'day' => 'jour',
				'month' => 'mois',
				'year' => 'année'
			);

			$errors = array();

			$prenom = assain($_POST['prenom']);
			$nom = assain($_POST['nom']);
			$mail = assain($_POST['mail']);
			$day = assain($_POST['day']);
			$month = assain($_POST['month']);
			$year = assain($_POST['year']);
			$adresse = assain($_POST['adresse']);
			$question = assain($_POST['question']);

			$antispam = assain($_POST['antispam']);

			$monMail = 'dubrom1@hotmail.com';
			$sujet = "Formulaire d'inscription";
			$naissance = $day.'/'.$month."/".$year;

			$message = $prenom." ".$nom."".$email." ".$naissance." ".$adresse." ".$question;

			if (strlen($antispam) < 1) {
				
				if( count($_POST) > 0 ){

					if (strlen($prenom) == 0) {
						$errors['prenom'] = 'error';
					}

					if (strlen($nom) == 0) {
						$errors['nom'] = 'error';
					}

					if (strlen($mail) == 0) {
						$errors['mail'] = 'error';
					}else if (isValidMail($mail) == false) {
						$errors['mail'] = 'error';
					}

					if($day == '-'){
						$errors['day'] = 'error';
					}
					if($month == '-'){
						$errors['month'] = 'error';
					}
					if($year == '-'){
						$errors['year'] = 'error';
					}

					if( count($errors) == 0){
						$resultatMail = mail($monMail,$sujet,$message);
					}

				}
			}

			function affichErrors($argument){
				if(strlen($argument) > 0){
					echo 'class="input errors"';
				}else{
					echo 'class="input"';
				}
			}

			function affichErrorsBirth($argument){
				if(strlen($argument) > 0){
					echo 'class="select errors"';
				}else{
					echo 'class="select"';
				}
			}
?>

		<div class="formulaire">
			<h1 class="titre">Le CEAJ recrute!</h1>

			<p class="paragraph">Les raisons d'entrer dans le cercle sont nombreuses: s'amuser lors des nombreuses activités organisées, payer moins cher son entrée en soirée ou encore obtenir de nombreux tuyaux pour les cours.</p>

			<p class="paragraph">Si toi aussi tu veux faire partie du Cercle, remplis ce formulaire.</p>


			<h1 <?php 
				if( count($_POST) > 0 ){
					if(count($errors) == 0){
						echo 'class="titre"';
					}else{
						echo 'class="titre disparition"';
					}		
			}else{
				echo 'class="titre disparition"';
			}?>>Merci, ton inscription a été envoyée!</h1>


			<form <?php 
				if( count($_POST) > 0 ){
					if(count($errors) == 0){
						echo 'class="form disparition"';
					}else{
						echo 'class="form"';
					}		
			}else{
				echo 'class="form"';
			}?> method=post>

				<fieldset class="fieldset">

					<label class="label" for="prenom">Prénom</label>
					<input <?php affichErrors($errors['prenom']); ?> type="text" name="prenom" placeholder="Entre ton prenom" id="prenom">

					<label class="label" for="nom">Nom</label>
					<input <?php affichErrors($errors['nom']); ?> type="text" name="nom" placeholder="Entre ton nom" id="nom">

					<label class="label" for="mail">Adresse mail</label>
					<input <?php affichErrors($errors['mail']); ?> type="text" name="mail" placeholder="Entre ton adresse mail" id="mail">
				</fieldset>
				<fieldset class="fieldset">
					<legend class="label">Date de naissance</legend>

					<select id="day" name="day" <?php affichErrorsBirth($errors['day']); ?>>
						<option value="-" >-</option> 
	    				<?php
	    					for($i = 1; $i <= 31; $i++) {	
	    						echo '<option value="'.$i.'">'.$i.'</option> ';
							}
						?>
	    			</select>

	    			<select id="month" name="month" <?php affichErrorsBirth($errors['month']); ?>>
	    				<option value="-">-</option> 
	    				<?php
	    					foreach($mois as $value){
	    						echo '<option value="'.$value.'">'.$value.'</option> ';
	    					}
						?>
	    			</select>

	    			<select id="year" name="year" <?php affichErrorsBirth($errors['year']); ?>>
	    				<option value="-">-</option> 
	    				<?php
	    					for($i = date("Y"); $i >= 1900; $i--) {	
	    						echo '<option value="'.$i.'">'.$i.'</option> ';
							}
						?>
	    			</select>

	    		</fieldset>
	    		<fieldset class="fieldset">

					<label for="adresse" class="label">Adresse</label>
					<textarea class="input" name="adresse" placeholder="Entre ton adresse" id="adresse"></textarea>

				</fieldset>

				<fieldset>

	    			<legend class="label">Pourquoi veux-tu entrer au cercle?</legend>

	    			<select class="select select--question" id="question">
	    				<option value="-">-</option>
	    				<option value="potes">Pour mes faire pleins de potes</option>
	    				<option value="boire">Pour boire tous les soirs</option>
	    				<option value="bleu">Pour faire chier les prochains bleus</option>
	    			</select>

	    		</fieldset>


				<label for="antispam" class="antispams">Antispam</label>
				<input type="text" name="antispam" placeholder="Entrez votre nom" id="antispam" class="antispams">

				<input class="btn" type="submit">
			</form>
		</div>


		


	</body>

<html>








