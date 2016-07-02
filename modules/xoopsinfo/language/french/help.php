<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2001 - 2006 <http://www.xoops.org/>
*
* Module: xoopsinfo 2.0
* Licence : GPL
* Authors :
*              - Jmorris
*              - Marco
*              - Christian
*              - DuGris (http://www.dugris.info)
*/
?>


<h2>Merci de lire ceci avant de faire une demande de support sur<a href="http://frxoops.org/" target="_blank">Xoops France</a></h2>
<p>Avant de poster, commencez par faire une recherche avec la <a href="http://frxoops.org/search.php" target="_blank">fonction recherche</a> de Xoops avec les mots-clés appropriés pour vérifier si le sujet n'a pas été déjà traité.</p>
<p><strong>Question :</strong> Je n'ai pas trouvé de réponse satisfaisante, comment faire ? </p>
<p><strong>Réponse :</strong> Utilisez un titre efficace pour votre message, cela aidera les autres utilisateurs qui rencontrent un problème similaire, et favorisera ceux qui connaissent la réponse à vous proposer des solutions. </p>
<p><strong>Bannissez les formules avec aide, urgent, etc... C'est un forum de support où tout le monde a besoin d'aide et ceux qui répondent sont bénévoles.</strong></p>
<p>Les messages du genre "j'ai une page blanche" seront généralement ignorés. Non parce que personne ne veut vous aider, mais parce que vous n'aurez pas assez fourni d'informations.</p>
<p>Le meilleur moyen de faire votre demande est d'utiliser un titre clair, et d'expliquer votre problème avec le maximum de détails en respectant la chonologie. Si vous avez des soucis avec un thème ou un module, indiquez précisément leur nom et leur version.</p>
<p><strong><i>Les informations suivantes seront utiles aux personnes susceptibles de vous aider. Merci de les inclure dans votre message.</i></strong></p>
<?php
OpenTable();
echo ('<li><strong>Url du site : </strong>'.XOOPS_URL.'</li>');
echo ('<li><strong>Version de Xoops : </strong>'.XOOPS_VERSION.'</li>');
echo ('<li><strong>Thème Xoops : </strong>'.$xoopsConfig['theme_set'].'</li>');
echo ('<li><strong>Jeu de templates : </strong>'.$xoopsConfig['template_set'].'</li>');
echo ('<li><strong>Version PHP : </strong>'.phpversion().'</li>');
echo ('<li><strong>Version MySQL : </strong>');
$result = mysql_query("SELECT VERSION()");
list($mysql_version) = mysql_fetch_row($result);
echo $mysql_version;
mysql_free_result($result);
echo ('</li>');
echo ('<li><strong>Logiciel serveur : </strong>'.$_SERVER['SERVER_SOFTWARE'].'</li>');
echo ('<li><strong>Navigateur : </strong>'.$_SERVER['HTTP_USER_AGENT'].'</li>');
CloseTable();
?>
<h3>Activation du mode debug :</h3>
<p>Pour l'activer aller dans admin system, préférences, paramètres généraux.</p>
<h4>Versions 2.0.x/2.2.x</h4>
<p>Sélectionner l'une des valeurs dans le champ "Mode de mise au point", en principe <em>Mise au point php</em>sera celle que vous utiliserez en premier. Vous pouvez faire un copier/coller des messages d'erreur dans votre message sur le forum si vous ne comprenez pas leur signification.</p>
<p>Le mode Templates Smarty sera utilisé pour la mise au point des modifications qui portent sur les templates de modules par exemple.</p>
<p>Attention : l'activation de ce mode s'affiche dans une fenêtre popup visible par tous les visiteurs de votre site. Si vous ne voyez pas cette fenêtre, vérifiez qu'un logiciel anti-popup ou votre naivgateur ne bloque pas l'ouverture de cette fenêtre.</p>
<h4>Versions 2.0.14</h4>
<p>Dans le champ "Mode de mise au point", sélectionner l'un des modes d'affichage proposés, sachant que le mode debug en ligne est particulièrement discret. <br />
Après avoir validé l'écran précédent, une ligne de cette nature s'affichera dans le pied de page de votre site : All errors (0) queries (6) blocks (0) extra (0) timers (3) </p>
<p>un clic sur <ul><li>all errors : affiche les messages php (les lignes préfixées de <em>Notice [PHP]:</em> ou Warning n'empêchent pas le site de fonctionner)</li><li>queries : affiche les requêtes sql utilisées</li><li>blocks : affichera le titre des blocs et leur état par rapport au cache</li><li>timers : des informations statistiques</li></ul>
<p>Dans cette version de Xoops l'activation de ce mode ne sera visible que par les membres du groupe webmestres.</p>


<p><b><i>XOOPS Info File version 1.2</i></b><br />
Dernière mise à jour: Samedi 11 septembre 2006<br />
par l'équipe de support XOOPS France</p>