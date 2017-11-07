<?php

function pagination($pages_amount, $page, $links_block){

	$get = "";
	foreach($_GET as $key => $value)
		if($key != 'page')
			$get .= $key.'='.$value.'&';

	echo '
		<div class="text-center">
		<ul class="pagination">
		<li class="page-item">';

	if($page != 1)
		echo '<a class="page-link" href="?'.$get.'page='.($page-1).'">';
	else
		echo '<a class="page-link" href="?'.$get.'page=1">';

	echo '<span aria-hidden="true">&laquo;</span>
	    <span class="sr-only">Previous</span>
		</a>';

	if($pages_amount < 2*$links_block)
	{
		for($i = 1; $i <= $pages_amount; ++$i)
		{
			if($page == $i)
				echo '<li class="page-item active">
			    	<a class="page-link" href="#">'.$i.'</a>
			    	</li>';
			else
				echo '<li class="page-item">
					<a class="page-link" href="?'.$get.'page='.$i.'">'.$i.'</a>
					</li>';
		}
	}
	else
	{
		if($page < 1+$links_block)
		{
			for($i = 1; $i <= 2+$links_block; ++$i)
			{
				if($page == $i)
					echo '<li class="page-item active">
				    	<a class="page-link" href="#">'.$i.'</a>
				    	</li>';
				else
					echo '<li class="page-item">
						<a class="page-link" href="?'.$get.'page='.$i.'">'.$i.'</a>
						</li>';
			}
			echo '<li class="page-item disabled">
		    	<span class="page-link">...</span>
				</li>';
			echo '<li class="page-item">
				<a class="page-link" href="?'.$get.'page='.$pages_amount.'">'.$pages_amount.'</a>
				</li>';
		}
		else if($page > $pages_amount-$links_block)
		{
			echo '<li class="page-item">
				<a class="page-link" href="?'.$get.'page=1">1</a>
				</li>';
			echo '<li class="page-item disabled">
		    	<span class="page-link">...</span>
				</li>';
			for($i = $pages_amount-$links_block-1; $i <= $pages_amount; ++$i)
			{
				if($page == $i)
					echo '<li class="page-item active">
				    	<a class="page-link" href="#">'.$i.'</a>
				    	</li>';
				else
					echo '<li class="page-item">
						<a class="page-link" href="?'.$get.'page='.$i.'">'.$i.'</a>
						</li>';
			}
		}
		else
		{
			echo '<li class="page-item">
				<a class="page-link" href="?'.$get.'page=1">1</a>
				</li>';
			echo '<li class="page-item disabled">
		    	<span class="page-link">...</span>
				</li>';

			$links_block_half = floor($links_block/2);
			for($i = $page-$links_block_half; $i <= $page+$links_block_half; ++$i)
			{
				if($page == $i)
					echo '<li class="page-item active">
				    	<a class="page-link" href="#">'.$i.'</a>
				    	</li>';
				else
					echo '<li class="page-item">
						<a class="page-link" href="?'.$get.'page='.$i.'">'.$i.'</a>
						</li>';
			}


			echo '<li class="page-item disabled">
		    	<span class="page-link">...</span>
				</li>';
			echo '<li class="page-item">
				<a class="page-link" href="?'.$get.'page='.$pages_amount.'">'.$pages_amount.'</a>
				</li>';
		}
	}

	echo '<li class="page-item">';

	if($page != $pages_amount)
		echo '<a class="page-link" href="?'.$get.'page='.($page+1).'">';
	else
		echo '<a class="page-link" href="?'.$get.'page='.$pages_amount.'">';

	echo '<span aria-hidden="true">&raquo;</span>
	    <span class="sr-only">Next</span>
	    </a>';

	echo '</li>
	  	</ul>
		</div>';

}


function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}


function mailStatus($mailto, $reservation, $status, $prev_status){

	$mailfrom    = 'rezerwacje@paula-car.pl';  //jeśli domena dla Joomla jola.pl to email np. info@jola.pl
	$fromname    = 'Rezerwacje - Paula Car';


	$subject = "PaulaRentCar - Zmiana statusu zamówienia numer: ".$reservation;
	$message = '
		<html>
		<head>
			<title>Zamówienie numer:"'.$reservation.'" zmieniło status na "'.$status.'"</title>
		</head>
		<body>
			<p>Zamówienie numer: <strong>'.$reservation.'</strong></p>
			<p>Zmieniono status zamówienia z <strong>'.$prev_status.'</strong> na <strong>'.$status.'</strong></p>
			<p>Obecny status zamówienia to: <strong>'.$status.'</strong></p>
			<br/><br/>
			Pozdrawiamy<br>
			<strong>Ekipa PaulaRentCar!</strong>
		</body>
		</html>';

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers  .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers  .= 'From: '.$fromname .'<'.$mailfrom.'>'. "\r\n";

	if(mail($mailto, $subject, $message, $headers, '-f '.$mailfrom)){
		echo "Wysłano";
	}else{
		echo "Nie Wysłano";
	}
}


?>
