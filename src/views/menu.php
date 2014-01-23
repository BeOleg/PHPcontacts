<ul class="nav nav-tabs">
	<li class="<?=Router::isActivePath('main')?>">
		<a href="<?=Router::getLink('main')?>">
			Users
		</a>
	</li>
	<li class="<?=Router::isActivePath('contacts')?>">
		<a href="<?=Router::getLink('contacts')?>">
			Contacts
		</a>
	</li>
	<li class="<?=Router::isActivePath('bdays')?>">
		<a href="<?=Router::getLink('bdays')?>">
			Upcoming birthdays
		</a>
	</li>
</ul>
