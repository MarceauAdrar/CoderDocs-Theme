<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
$db = NULL;

// TODO: Créer des entités avec fixtures pour ça
if (isset($db)) {
	$req_derniers_incidents = $db->prepare('SELECT downtime.id, downtime.service, downtime_kpi.kpi_date, downtime_kpi.kpi_counter, downtime_kpi.kpi_type 
											FROM downtime_kpi 
											INNER JOIN downtime ON (downtime.id = downtime_id) 
											GROUP BY downtime_kpi.kpi_date, downtime.id 
											ORDER BY downtime_kpi.kpi_date DESC;');
	$req_derniers_incidents->execute();
	$derniers_incidents = $req_derniers_incidents->fetchAll(PDO::FETCH_ASSOC);

	// var_dump($derniers_incidents);
	// die;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>FormaDocs - L'entièreté des requêtes est disponible ici.</title>
	<?php include __DIR__ . '/assets/html/head.html'; ?>
</head>

<body class="docs-page">
	<?php include __DIR__ . '/assets/html/header.html'; ?>

	<div class="docs-wrapper">
		<div id="docs-sidebar" class="docs-sidebar">
			<div class="top-search-box d-lg-none p-3">
				<form class="search-form">
					<input type="text" placeholder="Search the docs..." name="search" class="form-control search-input">
					<button type="submit" class="btn search-btn" value="Search"><i class="fas fa-search"></i></button>
				</form>
			</div>
			<nav id="docs-nav" class="docs-nav navbar">
				<ul class="section-items list-unstyled nav flex-column pb-3">
					<li class="nav-item section-title"><a class="nav-link scrollto" href="#section-missions"><span class="theme-icon-holder me-2"><i class="fas fa-bullseye"></i></span>Vos missions</a></li>
					<li class="nav-item section-title"><a class="nav-link scrollto" href="#section-introduction"><span class="theme-icon-holder me-2"><i class="fas fa-map-signs"></i></span>Introduction</a></li>
					<li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-api"><span class="theme-icon-holder me-2"><i class="fas fa-box"></i></span>APIs</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#recuperation-candidats">Récupération des candidats</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#recuperation-candidat">Récupération des informations d'un candidat</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#ajout-candidat">Ajout d'un candidat</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#maj-candidat">Modification d'un candidat</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#suppression-candidat">Suppression d'un candidat</a></li>
					<li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-postman"><span class="theme-icon-holder me-2"><i class="fas fa-tools"></i></span>Postman</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#postman-configuration">Configuration</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#postman-retour">Retour d'informations</a></li>
					<li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-status"><span class="theme-icon-holder me-2"><i class="fas fa-laptop-code"></i></span>État des services</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#status-explications">Explications</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#status-kpi">KPI</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#status-derniers-incidents">Listing des derniers incidents</a></li>
					<li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-faq"><span class="theme-icon-holder me-2"><i class="fas fa-lightbulb"></i></span>FAQs</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#faq-methodes">Méthodes autorisées</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#faq-limites">Limites d'une API</a></li>
					<li class="nav-item"><a class="nav-link scrollto" href="#faq-aide">Aide pour l'exercice...</a></li>
				</ul>

			</nav><!--//docs-nav-->
		</div><!--//docs-sidebar-->
		<div class="docs-content">
			<div class="container">
				<article class="docs-article" id="section-missions">
					<header class=" docs-header">
						<h1 class="docs-heading">Missions <span class="docs-time">Date de dernière mise à jour: <?= date('d/m/Y') ?></span></h1>
						<section class="docs-intro">
							<p>Pour réussir l'exercice dans le secteur Numérique vous allez devoir:</p>
							<ul>
								<li>utiliser l'outil Postman pour enregistrer un candidat (<strong>vous</strong>)</li>
								<li>insérer le candidat dans la base de données avec <strong>VOTRE</strong> email (pour recevoir le lien)</li>
								<li>ouvrir votre boîte mail pour <strong>cliquer sur le lien</strong> à l'intérieur</li>
								<li>vérifier que votre donnée a bien été mise à jour en <strong>affichant la liste</strong> de tous les candidats</li>
								<li><strong>consulter le dernier mail</strong> reçu pour donner <strong>le mot de passe</strong> au formateur et sortir de la salle...</li>
							</ul>
						</section>
					</header>
				</article>

				<article class="docs-article" id="section-introduction">
					<div class="row">
						<h1 class="docs-heading">Introduction</h1>
						<div class="col-6">
							<section class="docs-intro">
								<p>FormaDocs utilise les API de type REST (type d'architecture) et retourne des réponses HTTP encodées en JSON.</p>
								<div>
									<h5>Qu'est-ce qu'une API ?</h5>
									<p>API signifie <i>Application Programming Interface</i>. Comprendre par là qu'il s'agit d'une application qui permet d'interagir et de faire la passerelle entre différents langages !</p>
								</div>
								<div>
									<h5>A quoi servent les APIs ?</h5>
									<p>Les API sont très utiles pour faire communiquer des applications entre elles ! Elle permettent d'être utilisées avec plusieurs langages à la fois.</p>
								</div>
								<div>
									<h5>Comment faire pour utiliser une API ?</h5>
									<p>Se référer à l'article concernant l'<a href="https://<?= $_SERVER['SERVER_NAME'] ?>/docs-page.php#postman-configuration">utilisation de Postman</a>. Tout y est expliqué de A à Z.</p>
								</div>
							</section><!--//docs-intro-->
						</div>
						<div class="col-6">
							<header class="docs-header">
								<h5>A quoi ça ressemble ?</h5>
								<p>C'est une demande que l'on formule sur le logiciel Postman qui permet d'entrer ou récupérer des informations depuis la base de données.</p>
								<p>C'est très simple et plutôt accessible !<br>Il suffit de visiter la documentation <a href="https://docs.<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>/docs-page.php#section-api">ci-après</a>: une cible (<i>endpoint</i>) vous est donnée, pour que l'<i>URL</i> vous conduise au bon endroit et réponde à votre demande.</p>
								<p>Par exemple:</p>
								<h6><i>Endpoint</i></h6>
								<p>Il s'agit de l'URI sur laquelle doit pointer la requête.</p>
								<div class="box">
									<span class="methode get">GET</span>&nbsp;/v1/centers/
								</div>
								<small class="box mt-2 d-inline-flex">https://<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>/v1/centers</small>
								<p>Cette commande va permettre de lister l'ensemble des centre d'ABC Formation.</p>
								<h6>Résultat</h6>
								<div class="docs-code-block">
									<pre class="shadow-lg rounded"><code class="json hljs">{
    "success": true,
    "message": "Récupération de la liste des centres d'ABC Formation",
    "centers": [
        {
            "id": 1,
            "locationCenter": "Aude"
        },
        {
            "id": 2,
            "locationCenter": "Carcassonne"
        },
        {
            "id": 3,
            "locationCenter": "Mauguio"
        },
        {
            "id": 4,
            "locationCenter": "Montpellier"
        },
	// ...
    ]
}
</code></pre>
								</div><!--//docs-code-block-->

							</header>
						</div>
					</div>
					<!-- <section class="docs-section" id="item-1-1">
						<h2 class="section-heading">Section Item 1.1</h2>
						<p>Vivamus efficitur fringilla ullamcorper. Cras condimentum condimentum mauris, vitae facilisis leo. Aliquam sagittis purus nisi, at commodo augue convallis id. </p>
						<p>Code Example: <code>npm install &lt;package&gt;</code></p>
						<h5>Unordered List Examples:</h5>
						<ul>
							<li><strong class="me-1">HTML5:</strong> <code>&lt;div id="foo"&gt;</code></li>
							<li><strong class="me-1">CSS:</strong> <code>#foo { color: red }</code></li>
							<li><strong class="me-1">JavaScript:</strong> <code>console.log(&#x27;#foo\bar&#x27;);</code></li>
						</ul>
						<h5>Ordered List Examples:</h5>
						<ol>
							<li>Download lorem ipsum dolor sit amet.</li>
							<li>Click ipsum faucibus venenatis.</li>
							<li>Configure fermentum malesuada nunc.</li>
							<li>Deploy donec non ante libero.</li>
						</ol>
						<h5>Callout Examples:</h5>
						<div class="callout-block callout-block-info">

							<div class="content">
								<h4 class="callout-title">
									<span class="callout-icon-holder me-1">
										<i class="fas fa-info-circle"></i>
									</span>
									Note
								</h4>
								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium <code>&lt;code&gt;</code> , Nemo enim ipsam voluptatem quia voluptas <a href="#">link example</a> sit aspernatur aut odit aut fugit.</p>
							</div>
						</div>

						<div class="callout-block callout-block-warning">
							<div class="content">
								<h4 class="callout-title">
									<span class="callout-icon-holder me-1">
										<i class="fas fa-bullhorn"></i>
									</span>
									Warning
								</h4>
								<p>Nunc hendrerit odio quis dignissim efficitur. Proin ut finibus libero. Morbi posuere fringilla felis eget sagittis. Fusce sem orci, cursus in tortor <a href="#">link example</a> tellus vel diam viverra elementum.</p>
							</div>
						</div>

						<div class="callout-block callout-block-success">
							<div class="content">
								<h4 class="callout-title">
									<span class="callout-icon-holder me-1">
										<i class="fas fa-thumbs-up"></i>
									</span>
					Tip
					</h4>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <a href="#">Link example</a> aenean commodo ligula eget dolor.</p>
			</div>
		</div>

		<div class="callout-block callout-block-danger me-1">
			<div class="content">
				<h4 class="callout-title">
					<span class="callout-icon-holder">
						<i class="fas fa-exclamation-triangle"></i>
					</span>
					Danger
					</h4>
					<p>Morbi eget interdum sapien. Donec sed turpis sed nulla lacinia accumsan vitae ut tellus. Aenean vestibulum <a href="#">Link example</a> maximus ipsum vel dignissim. Morbi ornare elit sit amet massa feugiat, viverra dictum ipsum pellentesque. </p>
			</div>
		</div>

		<h5 class="mt-5">Alert Examples:</h5>
		<div class="alert alert-primary" role="alert">
			This is a primary alert—check it out!
		</div>
		<div class="alert alert-secondary" role="alert">
			This is a secondary alert—check it out!
		</div>
		<div class="alert alert-success" role="alert">
			This is a success alert—check it out!
		</div>
		<div class="alert alert-danger" role="alert">
			This is a danger alert—check it out!
		</div>
		<div class="alert alert-warning" role="alert">
			This is a warning alert—check it out!
		</div>
		<div class="alert alert-info" role="alert">
			This is a info alert—check it out!
		</div>
		<div class="alert alert-light" role="alert">
			This is a light alert—check it out!
		</div>
		<div class="alert alert-dark" role="alert">
			This is a dark alert—check it out!
		</div>


		</section>

		<section class="docs-section" id="item-1-2">
			<h2 class="section-heading">Section Item 1.2</h2>
			<p>Vivamus efficitur fringilla ullamcorper. Cras condimentum condimentum mauris, vitae facilisis leo. Aliquam sagittis purus nisi, at commodo augue convallis id. Sed interdum turpis quis felis bibendum imperdiet. Mauris pellentesque urna eu leo gravida iaculis. In fringilla odio in felis ultricies porttitor. Donec at purus libero. Vestibulum libero orci, commodo nec arcu sit amet, commodo sollicitudin est. Vestibulum ultricies malesuada tempor.</p>
			<h5 class="mt-5">Lightbox Example:</h5>

			<p>The example below uses the <i class="fas fa-external-link-alt"></i> <a class="theme-link" href="https://github.com/andreknieriem/simplelightbox" target="_blank">simplelightbox plugin</a>. </p>

			<div class="simplelightbox-gallery row mb-3">
				<div class="col-12 col-md-4 mb-3">
					<a href="assets/images/coderpro-home.png"><img class="figure-img img-fluid shadow rounded" src="assets/images/coderpro-home-thumb.png" alt="" title="CoderPro Home Page" /></a>
				</div>
				<div class="col-12 col-md-4 mb-3">
					<a href="assets/images/coderpro-features.png"><img class="figure-img img-fluid shadow rounded" src="assets/images/coderpro-features-thumb.png" alt="" title="CoderPro Features Page" /></a>
				</div>
				<div class="col-12 col-md-4 mb-3">
					<a href="assets/images/coderpro-pricing.png"><img class="figure-img img-fluid shadow rounded" src="assets/images/coderpro-pricing-thumb.png" alt="" title="CoderPro Pricing Page" /></a>
				</div>

			</div>

			<h5>Custom Table:</h5>
			<div class="table-responsive my-4">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th class="theme-bg-light"><a class="theme-link" href="#">Option 1</a></th>
							<td>Option 1 desc lorem ipsum dolor sit amet, consectetur adipiscing elit. </td>
						</tr>
						<tr>
							<th class="theme-bg-light"><a class="theme-link" href="#">Option 2</a></th>
							<td>Option 2 desc lorem ipsum dolor sit amet, consectetur adipiscing elit. </td>
						</tr>

						<tr>
							<th class="theme-bg-light"><a class="theme-link" href="#">Option 3</a></th>
							<td>Option 3 desc lorem ipsum dolor sit amet, consectetur adipiscing elit. </td>
						</tr>

						<tr>
							<th class="theme-bg-light"><a class="theme-link" href="#">Option 4</a></th>
							<td>Option 4 desc lorem ipsum dolor sit amet, consectetur adipiscing elit. </td>
						</tr>
					</tbody>
				</table>
			</div>
			<h5>Stripped Table:</h5>
			<div class="table-responsive my-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">First</th>
							<th scope="col">Last</th>
							<th scope="col">Handle</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">1</th>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
						</tr>
						<tr>
							<th scope="row">2</th>
							<td>Jacob</td>
							<td>Thornton</td>
							<td>@fat</td>
						</tr>
						<tr>
							<th scope="row">3</th>
							<td>Larry</td>
							<td>the Bird</td>
							<td>@twitter</td>
						</tr>
					</tbody>
				</table>
			</div>
			<h5>Bordered Dark Table:</h5>
			<div class="table-responsive my-4">
				<table class="table table-bordered table-dark">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">First</th>
							<th scope="col">Last</th>
							<th scope="col">Handle</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">1</th>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
						</tr>
						<tr>
							<th scope="row">2</th>
							<td>Jacob</td>
							<td>Thornton</td>
							<td>@fat</td>
						</tr>
						<tr>
							<th scope="row">3</th>
							<td>Larry</td>
							<td>the Bird</td>
							<td>@twitter</td>
						</tr>
					</tbody>
				</table>
			</div>


		</section>

		<section class="docs-section" id="item-1-3">
			<h2 class="section-heading">Section Item 1.3</h2>
			<p>Vivamus efficitur fringilla ullamcorper. Cras condimentum condimentum mauris, vitae facilisis leo. Aliquam sagittis purus nisi, at commodo augue convallis id. Sed interdum turpis quis felis bibendum imperdiet. Mauris pellentesque urna eu leo gravida iaculis. In fringilla odio in felis ultricies porttitor. Donec at purus libero. Vestibulum libero orci, commodo nec arcu sit amet, commodo sollicitudin est. Vestibulum ultricies malesuada tempor.</p>
			<h5>Badges Examples:</h5>
			<div class="my-4">
				<span class="badge badge-primary">Primary</span>
				<span class="badge badge-secondary">Secondary</span>
				<span class="badge badge-success">Success</span>
				<span class="badge badge-danger">Danger</span>
				<span class="badge badge-warning">Warning</span>
				<span class="badge badge-info">Info</span>
				<span class="badge badge-light">Light</span>
				<span class="badge badge-dark">Dark</span>
			</div>
			<h5>Button Examples:</h5>
			<div class="row my-3">
				<div class="col-md-6 col-12">
					<ul class="list list-unstyled pl-0">
						<li><a href="#" class="btn btn-primary">Primary Button</a></li>
						<li><a href="#" class="btn btn-secondary">Secondary Button</a></li>
						<li><a href="#" class="btn btn-light">Light Button</a></li>
						<li><a href="#" class="btn btn-success">Succcess Button</a></li>
						<li><a href="#" class="btn btn-info">Info Button</a></li>
						<li><a href="#" class="btn btn-warning">Warning Button</a></li>
						<li><a href="#" class="btn btn-danger">Danger Button</a></li>
					</ul>
				</div>
				<div class="col-md-6 col-12">
					<ul class="list list-unstyled pl-0">
						<li><a href="#" class="btn btn-primary"><i class="fas fa-download me-2"></i> Download Now</a></li>
						<li><a href="#" class="btn btn-secondary"><i class="fas fa-book me-2"></i> View Docs</a></li>
						<li><a href="#" class="btn btn-light"><i class="fas fa-arrow-alt-circle-right me-2"></i> View Features</a></li>
						<li><a href="#" class="btn btn-success"><i class="fas fa-code-branch me-2"></i> Fork Now</a></li>
						<li><a href="#" class="btn btn-info"><i class="fas fa-play-circle me-2"></i> Find Out Now</a></li>
						<li><a href="#" class="btn btn-warning"><i class="fas fa-bug me-2"></i> Report Bugs</a></li>
						<li><a href="#" class="btn btn-danger"><i class="fas fa-exclamation-circle me-2"></i> Submit Issues</a></li>
					</ul>
				</div>
			</div>

			<h5>Progress Examples:</h5>
			<div class="my-4">
				<div class="progress my-4">
					<div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<div class="progress my-4">
					<div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<div class="progress my-4">
					<div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<div class="progress my-4">
					<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
		</section> -->

				</article>

				<article class="docs-article" id="section-api">
					<header class="docs-header">
						<h1 class="docs-heading">APIs</h1>
						<section class="docs-intro">
							<p>Vous voici donc dans la partie de l'API concrète ! Ici les actions que vous allez faire vont permettre d'effectuer diverses actions (listage, ajout, modification, suppression) sur des éléments de la Base de Données.</p>
						</section><!--//docs-intro-->
						<p>Découvrez les différents accès qui vont sont laissés sur la table concernant les candidats (<strong>vous</strong>).</p>
					</header>
					<section class="docs-section" id="recuperation-candidats">
						<h3 class="section-heading">Récupération des candidats</h3>
						<div>
							<h6><i>Endpoint</i></h6>
							<div class="box">
								<span class="methode get">GET</span>&nbsp;/v1/candidates/
							</div>
							<small class="box mt-2 d-inline-flex">https://<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>/v1/candidates</small>
							<p>Cette commande va permettre de lister l'ensemble des personnes qui ont réussis la première partie de l'exercice.</p>
							<h6>Résultat</h6>
							<div class="docs-code-block">
								<pre class="shadow-lg rounded"><code class="json hljs">{
	"success": true,
	"message": "Récupération de la liste des candidats actuellement en Base de Données",
	"candidates": [
		{
			"id": 1,
			"dobCandidate": "2023-12-15T00:00:00+00:00",
			"emailCandidate": "contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>",
			"uuidCandidate": "00000000-0000-0000-0000-000000000000",
			"isEnabledCandidate": true
		},
		// ...
	]
}</code></pre>
							</div><!--//docs-code-block-->
						</div>
					</section><!--//section-->
					<section class="docs-section" id="recuperation-candidat">
						<h3 class="section-heading">Récupération des informations d'un candidat</h3>

						<div>
							<h6><i>Endpoint</i></h6>
							<div class="box">
								<span class="methode get">GET</span>&nbsp;/v1/candidates/{email}
							</div>
							<small class="box mt-2 d-inline-flex">https://<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>/v1/candidates/contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?></small>
							<p>Cette commande va permettre de lister l'ensemble des valeurs pour un candidat.</p>
							<h6>Résultat</h6>
							<div class="docs-code-block">
								<pre class="shadow-lg rounded"><code class="json hljs">{
	"success": true,
	"message": "Récupération des éléments du candidat `contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>`",
	"candidate": {
		"id": 1,
		"dobCandidate": "2023-12-15T00:00:00+00:00",
		"emailCandidate": "contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>",
		"uuidCandidate": "00000000-0000-0000-0000-000000000000",
		"isEnabledCandidate": true
	}
}</code></pre>
							</div><!--//docs-code-block-->
						</div>
					</section><!--//section-->

					<section class="docs-section" id="ajout-candidat">
						<h3 class="section-heading">Ajouter un candidat</h3>
						<div>
							<h6><i>Endpoint</i></h6>
							<div class="box">
								<span class="methode post">POST</span>&nbsp;/v1/candidates/
							</div>
							<small class="box mt-2 d-inline-flex">https://<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>/v1/candidates</small>
							<p>Cette commande va permettre d'insérer une donnée dans la Base de Données.</p>
							<h6>Paramètres</h6>
							<div class="table-responsive mb-4">
								<table class="table table-dark table-striped">
									<thead>
										<tr>
											<th scope="col">CLÉS</th>
											<th scope="col">TYPE</th>
											<th scope="col">DESCRIPTION</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th scope="row">candidate_email</th>
											<td>string</td>
											<td>7-255 caractères maximum, représente l'email du candidat, pour recevoir le lien</td>
										</tr>
										<tr>
											<th scope="row">candidate_dob?</th>
											<td>Date</td>
											<td>Élément optionnel, il concerne l'âge du candidat (format libre)</td>
										</tr>
									</tbody>
								</table>
							</div>
							<h6>Résultat</h6>
							<div class="docs-code-block">
								<pre class="shadow-lg rounded"><code class="json hljs">{
	"success": true,
	"message": "Récupération de la liste des candidats actuellement en Base de Données",
	"candidates": [
		{
			"id": 1,
			"dobCandidate": "2023-12-15T00:00:00+00:00",
			"emailCandidate": "contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>",
			"uuidCandidate": "00000000-0000-0000-0000-000000000000",
			"isEnabledCandidate": true
		},
		// ...
	]
}</code></pre>
							</div><!--//docs-code-block-->
						</div>
					</section><!--//section-->

					<section class="docs-section" id="maj-candidat">
						<h3 class="section-heading">Mettre à jour un candidat</h3>
						<div>
							<h6><i>Endpoint</i></h6>
							<div class="box">
								<span class="methode put">PUT</span><span class="methode put">PATCH</span>&nbsp;/v1/candidates/{email}
							</div>
							<small class="box mt-2 d-inline-flex">https://<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>/v1/candidates/contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?></small>
							<p>Cette commande va permettre de mettre à jour une ou plusieurs données dans la Base de Données pour un <strong>candidat</strong> donné.</p>
							<h6>Paramètres</h6>
							<div class="table-responsive mb-4">
								<table class="table table-dark table-striped">
									<thead>
										<tr>
											<th scope="col">CLÉS</th>
											<th scope="col">TYPE</th>
											<th scope="col">DESCRIPTION</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th scope="row">candidate_email?</th>
											<td>string</td>
											<td>Élément optionnel, 7-255 caractères maximum, représente l'email du candidat, pour recevoir le lien</td>
										</tr>
										<tr>
											<th scope="row">candidate_dob?</th>
											<td>Date</td>
											<td>Élément optionnel, il concerne l'âge du candidat (format libre)</td>
										</tr>
									</tbody>
								</table>
							</div>
							<h6>Résultat</h6>
							<div class="docs-code-block">
								<pre class="shadow-lg rounded"><code class="json hljs">{
	"success": true,
	"message": "Mise à jour du candidat `contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>` effectuée",
	"candidate": {
		"id": 1,
		"dobCandidate": "2023-12-15T00:00:00+00:00",
		"emailCandidate": "contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>",
		"uuidCandidate": "00000000-0000-0000-0000-000000000000",
		"isEnabledCandidate": true
	}
}</code></pre>
							</div><!--//docs-code-block-->
						</div>
					</section><!--//section-->

					<section class="docs-section" id="suppression-candidat">
						<h3 class="section-heading">Supprimer un candidat</h3>
						<div>
							<h6><i>Endpoint</i></h6>
							<div class="box">
								<span class="methode delete">DELETE</span>&nbsp;/v1/candidates/{email}
							</div>
							<small class="box mt-2 d-inline-flex">https://<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>/v1/candidates/contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?></small>
							<p>Cette commande va permettre de supprimer un <strong>candidat</strong> donné dans la Base de Données.</p>
							<h6>Résultat</h6>
							<div class="docs-code-block">
								<pre class="shadow-lg rounded"><code class="json hljs">{
	"success": true,
	"message": "Suppression du candidat `contact@<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>` effectuée"
}</code></pre>
							</div><!--//docs-code-block-->
						</div>
					</section><!--//section-->
				</article><!--//docs-article-->

				<article class="docs-article" id="section-postman">
					<header class="docs-header">
						<h1 class="docs-heading">Postman</h1>
						<section class="docs-intro">
							<p>Postman est une application permettant de tester des APIs, créée en 2012 par Abhinav Asthana, Ankit Sobti et Abhijit Kane à Bangalore pour répondre à une problématique de test d'APIs partageable.</p>
						</section><!--//docs-intro-->
					</header>
					<section class="docs-section" id="postman-configuration">
						<h2 class="section-heading">Configuration de Postman</h2>
						<p>Vous n'avez que quelques informations à renseigner pour effectuer un test auprès d'une </p>
						<div class="container">
							<div class="row">
								<div class="col-4">
									<ul>
										<li>(1) La méthode à utiliser: GET, POST, PUT, DELETE ;</li>
										<li>(2) L'<i>URL</i> à saisir ;</li>
										<li>(3) Les paramètres de la requête <strong>si demandés</strong> (ex: email, nom, date de naissance, ...).</li>
										<li>Cliquer sur Envoyer (<i>Send</i>) pour réaliser votre tentative</li>
									</ul>
								</div>
								<div class="col-8">
									<img src="./assets/images/screenshots/capture-01.png" class="img-fluid" alt="">
								</div>
							</div>
						</div>
					</section><!--//section-->

					<section class="docs-section" id="postman-retour">
						<h2 class="section-heading">Comprendre et traiter le retour d'une API avec Postman</h2>
						<div class="container">
							<div class="row">
								<div class="col-5">
									<img src="./assets/images/screenshots/capture-02.png" class="img-fluid" alt="">
								</div>
								<div class="col-7">
									<p>Le retour est au format JSON, c'est-à-dire un langage qui permet d'associer un identifiant à une donnée appellée «valeur».</p>
									<p>L'identifiant «<i>success</i>» permet de voir que cela a fonctionné.</p>
									<p>L'identifiant «<i>message</i>» permet de comprendre l'action réalisée.</p>
									<p>L'identifiant «<i>centers</i>» qui correspond à ce qui a été saisi, permet de les lister.</p>
								</div>
							</div>
						</div>
					</section><!--//section-->
				</article><!--//docs-article-->


				<article class="docs-article" id="section-status">
					<header class="docs-header">
						<h1 class="docs-heading">État des services</h1>
						<section class="docs-intro">
							<p>L'état des services permet de voir si un ou plusieurs services sont opérationnels ou s'ils rencontrent des problèmes à un moment donné.</p>
						</section><!--//docs-intro-->
					</header>
					<section class="docs-section" id="status-explications">
						<h2 class="section-heading">Explications</h2>
						<p>Les états de services permettent de voir en temps réel quel est l'état de nos différents services. Ils ont pour but d'indiquer aux utilisateurs/trices qu'un service semble être défaillant, à quel moment, etc.</p>
					</section><!--//section-->

					<section class="docs-section" id="status-kpi">
						<h2 class="section-heading">Key Performance Indicator (KPI - Indicateur clé de performance)</h2>
						<p>Les indicateurs clés de performance sont des mesures utilisées pour évaluer le succès ou l'efficacité d'une activité, d'un processus, d'un projet ou d'une organisation. Ils sont essentiels pour aider à comprendre si des objectifs spécifiques ont été atteints et pour suivre les progrès vers ces objectifs.</p>
						<canvas id="line-chart" width="800" height="250"></canvas>
					</section><!--//section-->

					<section class="docs-section" id="status-derniers-incidents">
						<h2 class="section-heading">Listing des derniers incidents</h2>
						<p>Derniers incidents</p>
						<?php
						$jour = new DateTime();
						$jour = $jour->format('d');
						$dateActuelle = new DateTime();
						$listeIncidents = array();
						$listeDates = array();

						// Boucle pour remonter de la date actuelle jusqu'à 90 jours en arrière
						for ($i = 0; $i < $jour; $i++) {
							$message = "";
							foreach ($derniers_incidents as $incident) {
								if ($incident['kpi_date'] == $dateActuelle->format('Y-m-d')) {
									$message .= "<b>" . $incident['service'] . "</b>:&nbsp;" . $incident['kpi_type'] . "<br>";
									$message .= "\n";
									$listeIncidents[$incident['service']]['compteur'] = $incident['kpi_counter'];
									$listeIncidents[$incident['service']]['incident'] = $incident['kpi_type'];
									$listeIncidents[$incident['service']]['date'] = $incident['kpi_date'];
								}
							}
							$listeDates[] = $dateActuelle->format('d/m/Y');
							echo "<div style='font-weight:600;'>" . $dateActuelle->format('d/m/Y') . "</div>\n<hr style='margin-top:0;'><div style='padding-bottom: 50px;'>" . (empty($message) ? "Aucune donnée renseignée..." : $message) . "</div>";
							$dateActuelle->modify('-1 day');
						}
						// sort($listeDates);
						// echo "<pre>";
						// var_dump($listeIncidents);
						// echo "</pre>";
						// die; 
						?>
					</section><!--//section-->
				</article><!--//docs-article-->

				<article class="docs-article" id="section-faq">
					<header class="docs-header">
						<h1 class="docs-heading">FAQs</h1>
						<section class="docs-intro">
							<p>Retrouvez toutes les réponses à vos questions dans cette section.</p>
						</section><!--//docs-intro-->
					</header>
					<section class="docs-section" id="faq-methodes">
						<h2 class="section-heading">Méthodes autorisées</h2>
						<h5 class="pt-3"><i class="fas fa-question-circle me-1"></i>Quelles sont les méthodes autorisées par l'API ?</h5>
						<p>L'API autorise les méthodes suivantes:
						<ul>
							<li>GET pour la récupération d'informations</li>
							<li>POST pour l'insertion d'informations</li>
							<li>PUT/PATCH pour la modification d'informations</li>
							<li>DELETE pour la suppression d'informations</li>
						</ul>
						</p>
						<h5 class="pt-3"><i class="fas fa-question-circle me-1"></i>Pourquoi certaines méthodes ne sont pas autorisées ?</h5>
						<p>Le modèle de l'API est de type RESTful. Ce même modèle se base sur le modèle de Richardson qui n'autorise que les méthodes précisées ci-dessus.</p>
					</section><!--//section-->

					<section class="docs-section" id="faq-limites">
						<h2 class="section-heading">Limites d'une API</h2>
						<h5 class="pt-3"><i class="fas fa-question-circle me-1"></i>Quelles sont les limites d'une API ?</h5>
						<p>L'API a une limite de débit. Ainsi, elle peut subir des ralentissements voire des dysfonctionnements lors de fortes demandes.</p>
						<h5 class="pt-3"><i class="fas fa-question-circle me-1"></i>Comment contraindre une API à l'utilisation d'utilisateurs spécifiques ?</h5>
						<p>Il suffit de demander à ces mêmes utilisateurs de créer un accès sur notre plateforme. Dès lors, nous pourrons leur générer un <i>token</i> unique afin de les identifier et qui leur sera demandé à chaque tentative !</p>
					</section><!--//section-->

					<section class="docs-section" id="faq-aide">
						<h2 class="section-heading">Aide pour l'exercice...</h2>
						<h5 class="pt-3"><i class="fas fa-question-circle me-1"></i>Vous êtes bloqué·e ? Vous ne savez plus comment avancer ? (fiche de guide)</h5>
						<p>Vous pouvez retrouver une fiche d'aide avec une aide pas à pas pour réussir l'exercice <a target="_blank" href=" https://docs.<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>/018c8255-9260-7569-ad4c-3a082b8ea5f6.pdf">ici</a>. Vous n'êtes pas obligé·e de la lire entièrement pour garder du challenge !</p>
						<h5 class="pt-3"><i class="fas fa-question-circle me-1"></i>Vous êtes VRAIMENT bloqué·e ? (solution pas à pas)</h5>
						<p>Vous pouvez retrouver la fiche réponse avec les explications détaillées <a target="_blank" href=" https://docs.<?= str_replace('docs', 'api', $_SERVER['SERVER_NAME']) ?>/018c827e-37ac-73ce-b096-d41467a9ba0b.pdf">ici</a>.</p>
					</section><!--//section-->
				</article><!--//docs-article-->

				<footer class="footer">
					<div class="container text-center py-5">
						<!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
						<small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="theme-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>
						<ul class="social-list list-unstyled pt-4 mb-0">
							<li class="list-inline-item"><a href="https://github.com/MarceauAdrar?tab=repositories"><i class="fab fa-github fa-fw"></i></a></li>
							<li class="list-inline-item"><a href="https://www.linkedin.com/school/adrarnumerique/posts/?feedView=all"><svg class="svg-inline--fa fa-linkedin fa-fw" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
										<path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path>
									</svg></a></li>
						</ul><!--//social-list-->
					</div>
				</footer>
			</div>
		</div>
	</div><!--//docs-wrapper-->
	<?php include __DIR__ . '/assets/html/footer.html'; ?>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		// const ctx = document.querySelector("#line-chart").getContext("2d");
		// ctx.font = "48px serif";
		// ctx.fillText("KPI incoming...", 10, 50);

		var listeJours = [];
		var listeDataAPI = [];
		var listeDataDocumentation = [];
		var listeDataTiers = [];
		var listeIncidents = "[";
		<?php foreach ($listeDates as $key => $date) { ?>
			listeJours[<?= $key ?>] = "<?= $date ?>";
		<?php } ?>

		listeIncidents += "{label: 'Nombre d\'incidents survenus sur l\'API', data: " + [37, null, null, null, null, null, null] + ", borderWidth: 1},";
		listeIncidents += "{label: 'Nombre d\'incidents survenus sur la documentation', data: " + [null, null, null, null, null, null, null] + ", borderWidth: 1},";
		listeIncidents += "{label: 'Nombre d\'incidents survenus sur les Tierces Parties', data: " + [null, null, null, null, 7, null, null] + ", borderWidth: 1},";
		listeIncidents += "]";
		const ctx = document.querySelector("#line-chart");
		new Chart(ctx, {
			type: 'bar',
			data: {
				labels: listeJours,
				datasets: [{
						label: 'Nombre d\'incidents survenus sur l\'API',
						data: [37, null, null, null, null, null, null],
						borderWidth: 1
					},
					{
						label: 'Nombre d\'incidents survenus sur la documentation',
						data: [null, null, null, null, null, null, null],
						borderWidth: 1
					},
					{
						label: 'Nombre d\'incidents survenus les Tierces Parties',
						data: [null, null, null, null, 7, null, null],
						borderWidth: 1
					},
				]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	</script>
</body>

</html>