<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	require_once("adminPanelFunctions.php");

	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';
	echo '<div class="page-header">
			<h3>Strona główna</h3>
			</div>';

	echo '<h4>Dzisiejsze odbiory</h4>';

	displayTodayPickups();

	echo '<h4><br/><br/>Dzisiejsze zwroty</h4>';

	displayTodayReturns();

	echo '</div>
		</div>
		</div>
		</div>';

?>