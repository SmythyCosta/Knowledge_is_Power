<?php

// This file is the home page. 
require('./includes/config.inc.php');

// check session
require('./includes/check_session.inc.php');

// Require the database connection:
require('./includes/mysql.inc.php');

// If it's a POST request, handle the login attempt:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	include('./includes/login.inc.php');
}

// Include the header file:
include('./includes/header.php');

/* PAGE CONTENT STARTS HERE! */
?>
<h1>Welcome</h1>

<p class="lead">Integre-se, faça amizades, siga pessoas, troque mensagens.</p>

<p>Somos uma rede social gratuita composta por pessoas com o interesse de serem aprovadas em concursos públicos voltados para área de TI. Com uma série de ferramentas que aplicam o princípio pedagógico.</p>

<h1>Nossos conteudos:</h1>

<ul>
  <li>Disciplinas</li>
  <li>Artigos</li>
  <li>Desafios</li>
  <li>Discursão sobre provas</li>
</ul>

<p>“É praticando que você aprende!”.</p>


<?php /* PAGE CONTENT ENDS HERE! */

// Include the footer file to complete the template:
include('./includes/footer.php');
?>