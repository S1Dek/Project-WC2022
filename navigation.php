<?php
$name=$_SESSION['name'];
echo "<div id='navigation_komputer'>
		<ol>
			<li id='flashdown'><a class='nav'><img class='icon' src='images/navigation-image.jpg' alt='logo'></a>
			<ul class='dropdown'>
			<li class='li_drop'><a id='icon' href='index.php'><img class='icon' src='images/logo.jpg' alt='logo'></a></li>	
			<li class='li_drop'><a class='nav'>$name</a>
				<ul class='dropdown2'>
					<li><a class='unav' href='list_accounts.php'>Tabela uczestników</a></li>
					<li><a class='unav' href='principles.php'>Zasady</a></li>
				</ul>
			</li>
			<li class='li_drop'><a class='nav' >MŚ 2022</a>
				<ul class='dropdown2'>
					<li><a class='unav' href='match_done.php'>MŚ 2022 - Mecze ukończone</a></li> 
					<li><a class='unav' href='winner_bestplayers.php'>MŚ 2022 - Król Strzelców i zwycięzca</a></li>
					<li><a class='unav' href='group.php'>MŚ 2022 - Tabele</a></li>
				</ul>
			</li>
			<li class='li_drop'><a class='nav' href='contact.php'>Kontakt</a></li>		
			<li class='li_drop'><a class='nav' href='logout.php'>Wyloguj się</a></li>	
			</ul>
			</li> 
		</ol>		
	</div>
	<div id='navigation_telefon'>
		<ol>
			<li><a id='icon' href='index.php'><img class='icon' src='images/logo.jpg' alt='logo'></a></li>	
			<li><a class='nav'>$name</a>
				<ul class='dropdown2'>
					<li><a class='unav' href='list_accounts.php'>Tabela uczestników</a></li>
					<li><a class='unav' href='principles.php'>Zasady</a></li>
				</ul>
			</li>
			<li><a class='nav' >MŚ 2022</a>
				<ul class='dropdown2'>
					<li><a class='unav' href='match_done.php'>MŚ 2022 - Mecze ukończone</a></li> 
					<li><a class='unav' href='winner_bestplayers.php'>MŚ 2022 - Król Strzelców i zwycięzca</a></li>
					<li><a class='unav' href='group.php'>MŚ 2022 - Tabele</a></li>
				</ul>
			</li>
			<li><a class='nav' href='contact.php'>Kontakt</a></li>		
			<li><a class='nav' href='logout.php'>Wyloguj się</a></li>	
		</ol>		
	</div>";?>