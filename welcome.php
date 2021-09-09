<?php
	session_start();

	// Si la requête arrive avec un autre type que GET
	// ou que le client n'est pas considéré comme connecté,
    // renvoi vers le formulaire de connexion

	// sinon, on affiche la page de bienvenue
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>My account</title>
    </head>
    <body>
        <p>
			Hello UTILISATEUR !<br>
			Welcome on your account.
		</p>
    </body>
</html>
