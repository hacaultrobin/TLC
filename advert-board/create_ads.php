<!DOCTYPE html>
<html>
	<head>
		<title>Cr&eacute;ation d'annonces</title>
		<link rel="stylesheet" type="text/css" href="css/create_ads.css">
	</head>
	<body>
		<section>
			<form action="save_ads" method="POST">
				<div id="fields">
					<div class="field">
						<label for="title">Titre&nbsp;</label><input type="text" name="title[]" />
						<label for="price">Prix&nbsp;</label><input type="number" name="price[]" />
					</div>
				</div>
				<div id="buttons">
					<input type="button" onclick="javascript:addField()" value="+" />
					<input type="submit" value="Enregistrer" />
				</div>
			</form>
		</section>
		<script>
			function addField() {
				document.getElementById("fields").innerHTML = document.getElementById("fields").innerHTML+
				"<div class=\"field\">"+
				"\t<label for=\"title\">Titre&nbsp;</label><input type=\"text\" name=\"title[]\" />"+
				"\t<label for=\"price\">Prix&nbsp;</label><input type=\"number\" name=\"price[]\" />"+
				"</div>";
			}
		</script>
	</body>
</html>
