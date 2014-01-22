<div class="row">
	<div class="col col-lg-3">
		<?=$__item['first_name']?>
	</div>
	<div class="col col-lg-3">
		<?=$__item['last_name']?>
	</div>
	<div class="col col-lg-1">
		<a href="/contacts?uid=<?=$__item['id']?>" class="btn btn link">
			<?=$__item['contact_count']?>
		</a>
	</div>
	<div class="col col-lg-3">
		<?=$__item['email']?>
	</div>
</div>