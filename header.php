<?php
	$clear_url = explode('?', $_SERVER['REQUEST_URI']);
	$clear_url = RESET($clear_url);
?><header class="header_area">
	<div class="main_menu">
		<nav class="navbar navbar-expand-lg navbar-light">
			<div class="container box_1620">
				<a class="navbar-brand logo_h" href="/"><img src="/img/logo.png" alt=""></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
					<ul class="nav navbar-nav menu_nav justify-content-end">
						<li class="nav-item<?= '/' === $clear_url ? ' active' : '' ?>"><a class="nav-link" href="/">Главная</a></li> 
						<li class="nav-item"><a class="nav-link" href="/#price">Цены</a></li> 
						<li class="nav-item<?= '/discount/' === $clear_url ? ' active' : '' ?>"><a class="nav-link" href="/discount/">Скидки</a></li> 
						<li class="nav-item<?= '/delivery/' === $clear_url ? ' active' : '' ?>"><a class="nav-link" href="/delivery/">Доставка</a></li> 
						<li class="nav-item<?= '/contact/' === $clear_url ? ' active' : '' ?>"><a class="nav-link" href="/contact/">Контакты</a>
					</ul>
				</div> 
			</div>
		</nav>
	</div>
</header>