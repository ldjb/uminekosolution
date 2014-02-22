<?php
$title = "Episode 0: Prequel of the Golden Witch";
$topic = 999999999;
$urlPrefix = "";
echo <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>$title | GabeZhul's solution to Umineko no Naku Koro ni</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="{$urlPrefix}normalize.css" type="text/css">
<link rel="stylesheet" href="{$urlPrefix}style.css" type="text/css">
</head>
<body>
<div id="toc">
<h2>Table of contents</h2>
<ul>

EOT;

$output = <<<EOT
</ul>
</div>
<div id="content">
<p><a href=".">≪Back to index</a></p>
EOT;
$input = file_get_contents("ep0.txt");
$input = str_replace("\n\n", "\n", $input);
$input = str_replace("[red]", '<span style="color: red;">', $input);
$input = str_replace("[/red]", '</span>', $input);
$input = explode("\n", $input);
$listMode = false;
foreach ($input as $value) {
	if (strpos($value, "[*]") === 0) {
		if ($listMode == false) {
			$output = $output . "<" . ($listMode = "ul") . ">\n";
		}
		$output = $output . "\t<li>" . substr($value, 3) . "</li>";
	}
	elseif (strpos($value, "[#]") === 0) {
		if ($listMode == false) {
			$output = $output . "<" . ($listMode = "ol") . ">\n";
		}
		$output = $output . "\t<li>" . substr($value, 3) . "</li>";
	}
	else {
		if ($listMode) {
			$output = $output . "</" . $listMode . ">\n";
			$listMode = false;
		}
		if (strpos($value, "[h1]") === 0) {
			$output = $output . "<h1>" . substr($value, 4, strlen($value)-9) . "</h1>";
		}
		elseif (strpos($value, "[h2]") === 0) {
			$id = $base = str_replace(" ", "-", preg_replace('/[^\da-z ]/i', '', strtolower(substr($value, 4, strlen($value)-9))));
			$idNum = count($ids);
			$idFound = 0;
			$suffix = 2;
			while ($idFound >= 0) {
				foreach ($ids as $value2) {
					if ($value2['name'] == $id) {
						$idFound++;
					}
				}
				if ($idFound == 0) {
					$idFound = -1;
					$ids[$idNum]['name'] = $id;
					$ids[$idNum]['level'] = 2;
				}
				else {
					$idFound = 0;
					$id = $base . "-" . $suffix;
					$suffix++;
				}
			}
			$text = substr($value, 4, strlen($value)-9);
			$ids[$idNum]['text'] = $text;
			$output = $output . '<h2 id="' . $id . '"><a href="#' . $id . '">' . $text . "</a></h2>";
		}
		elseif (strpos($value, "[h3]") === 0) {
			$id = $base = str_replace(" ", "-", preg_replace('/[^\da-z ]/i', '', strtolower(substr($value, 4, strlen($value)-9))));
			$idNum = count($ids);
			$idFound = 0;
			$suffix = 2;
			while ($idFound >= 0) {
				foreach ($ids as $value2) {
					if ($value2['name'] == $id) {
						$idFound++;
					}
				}
				if ($idFound == 0) {
					$idFound = -1;
					$ids[$idNum]['name'] = $id;
					$ids[$idNum]['level'] = 3;
				}
				else {
					$idFound = 0;
					$id = $base . "-" . $suffix;
					$suffix++;
				}
			}
			$text = substr($value, 4, strlen($value)-9);
			$ids[$idNum]['text'] = $text;
			$output = $output . '<h3 id="' . $id . '"><a href="#' . $id . '">' . $text . "</a></h3>";
		}
		elseif ($value == "[blockquote]") {
			$output = $output . "<blockquote>";
		}
		elseif ($value == "[/blockquote]") {
			$output = $output . "</blockquote>";
		}
		elseif ($value == "") {
		}
		else {
			$output = $output . "<p>" . $value . "</p>";
		}
	}
	$output = $output . "\n";
}

$toc = "";
foreach ($ids as $value) {
	if ($value['level'] == 2) {
		$toc = $toc . "\t" . '<li><a href="#' . $value['name'] . '">' . $value['text'] . "</a></li>\n";
	}
}
$output = $toc . $output;

echo $output;
echo <<<EOT
<hr>
<p class="disclaimer">All text &copy;2013-2014 <a href="http://vndb.org/u293" target="_blank">GabeZhul</a>. <a href="http://vndb.org/t$topic" target="_blank">Originally posted on VNDB.</a> Distributed with permission. Hosted by <a href="http://y.gdn0.com" target="_blank">Yirba</a>.</p>
<p><a href=".">≪Back to index</a></p>
</div>
<script type="text/javascript" src="{$urlPrefix}script.js"></script>
</body>
</html>
EOT;
?>
