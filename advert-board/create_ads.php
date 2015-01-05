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
				var div = document.createElement("div");
				div.className = "field";
				div.innerHTML = "<label for=\"title\">Titre&nbsp;</label><input type=\"text\" name=\"title[]\" />"+
								"<label for=\"price\">Prix&nbsp;</label><input type=\"number\" name=\"price[]\" />";
				document.getElementById("fields").appendChild(div);
			}
		</script>
	</body>
</html>
