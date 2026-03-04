<?php
    const DIM_PAR_DEFAUT = 10;

    function tabMultiplication(int $nb = DIM_PAR_DEFAUT) : string {
        $resultat= "<table><caption> Tableau de multiplication</caption><thead><tr><th>X</th>";
        for($i = 1; $i <= $nb; $i++){
            $resultat .= "<th>" . $i . "</th>";
        }
        $resultat .= "</tr></thead><tbody>";
        for($i = 1; $i <= $nb; $i++){
            $resultat .= "<tr><td>" . $i . "</td>";
            for($p = 1; $p <= $nb; $p++){
                $resultat .= "<td>" . $p*$i . "</td>";
            }
            $resultat .= "</tr>";
        }
        $resultat .= "</tbody></table>";
        return $resultat;
    }

    function rgbHexa(int $r, int $g, int $b) : string {
        return "#" . strtoupper(sprintf("%02x%02x%02x", $r, $g, $b));
    }

    function hexaRgb(string $hex, int &$r, int &$g, int &$b) : bool {
        $hex = ltrim($hex, "#");

        if(strlen($hex) == 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if(strlen($hex) != 6 || !ctype_xdigit($hex)) {
            return false;
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return true;
    }

  function romainVersDecimal(string $romain) : int {
        $liste = ["I","IV","V","IX","X","XL","L","XC","C","CD","D","CM","M"];
        $valeurs = [ 1 ,  4 ,  5 ,  9 , 10 , 40 , 50 , 90 ,100 ,400 ,500 ,900 ,1000];
        $resultat = 0;
        $i = 0;
        while ($i < strlen($romain)) {
            // On essaye d'abord de matcher 2 caractères (IV, IX, XL, ...)
            if ($i + 1 < strlen($romain)) {
                $deux = substr($romain, $i, 2);
                $pos = array_search($deux, $liste, true);
                if ($pos !== false) {
                    $resultat += $valeurs[$pos];
                    $i += 2;
                    continue;
                }
            }
            // Sinon 1 caractère (I, V, X, L, C, D, M)
            $un = substr($romain, $i, 1);
            $pos = array_search($un, $liste, true);
            // (si jamais tu veux être strict, tu peux gérer erreur ici)
            $resultat += $valeurs[$pos];
            $i += 1;
        }

        return $resultat;
    }

    function tableASCII() : string {
        $resultat = "<table>\n";

        for($i = 32; $i <= 127; $i++) {
            
            if(($i % 16) == 0) {
                $resultat .= "\t<tr>\n";
            }
            
            if($i >= 48 && $i <= 57) {
                $classe = "chiffre";       
            } elseif($i >= 65 && $i <= 90) {
                $classe = "majuscule";     
            } elseif($i >= 97 && $i <= 122) {
                $classe = "minuscule";     
            } else {
                $classe = "";
            }
            
            if($i == 60){
                $char = "&lt;";
            } elseif($i == 62) {
                $char = "&gt;";
            } elseif($i == 38) {
                $char = "&amp;";
            } elseif($i == 127) {
                $char = "&#x00A0;";
            } else {
                $char = chr($i);
            }

            if($classe != "") {
                $resultat .= "\t\t<td class=\"$classe\">$char</td>\n";
            } else {
                $resultat .= "\t\t<td>$char</td>\n";
            }

            if(($i % 16) == 15) {
                $resultat .= "\t</tr>\n";
            }
        }
        $resultat .= "</table>\n";
        return $resultat;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TD6 Developpement Web</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/icon-cergy.png">
</head>
<body>
    <header>
        <section class="haut-page">
            <img src="images/logo-cy.png" width = "150px">
            <h1>TD6 :  XHTML5 & PHP (tests,boucles et fonctions)</h1>
            <section class="haut-5w">
                <p>Lanouni Rayan | Zine Abidine Anis</p>
                <p>L2-Informatique</p>
                <p>UE Developpement Web</p>
            </section>
        </section>
        <nav class="mini-nav">
            <span>Aller à :</span>
            <a href="#exo1">Table</a>
            <a href="#exo2">Couleurs</a>
            <a href="#exo3">Romain</a>
            <a href="#exo4">ASCII</a>
        </nav>
        <hr>
    <header>
    <main>
        <section id="exo1">
            <h2>Exercice 1 : Fonctions PHP et tableaux</h2>
            <?php
                echo tabMultiplication(10);
            ?>
        </section>
        <section id="exo2">
            <h2>Exercice 2 : Couleurs, passage de paramètre par valeur et par adresse</h2>
            <?php
            echo rgbHexa(255, 0, 128);

            $r = 0; $g = 0; $b = 0;
            $ok = hexaRgb("#FF0080", $r, $g, $b);
            if($ok) {
                echo "r=$r, g=$g, b=$b";
            }

            $ok = hexaRgb("#F08", $r, $g, $b);
            if($ok) {
                echo "r=$r, g=$g, b=$b";
            }

            $ok = hexaRgb("invalide", $r, $g, $b);
            var_dump($ok);
            ?>
        </section>
        <section id="exo3">
            <h2>Exercice 3 : Chiffres romains (M, D, C, L, X, V, I)</h2>
            <?php
                echo romainVersDecimal("IX");
            ?>
            <br>
            <?php
                echo romainVersDecimal("XIV");
            ?>
            <br>
            <?php
                echo romainVersDecimal("MCMXCIV"); 
            ?>
        </section>
        <section id="exo4">
            <h2>Exercice 4 : Boucles, tests et styles internes</h2>
            <?php
                echo tableASCII();
            ?>
        </section>
    </main>
    <footer>
        <section class="bas-5w">
            <p>Université de Cergy-Pontoise</p>
            <p>2025-2026</p>
        </section>
    </footer>
</body>
</html>