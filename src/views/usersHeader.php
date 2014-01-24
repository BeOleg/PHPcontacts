<div class="row">
	<div class="col col-lg-12">
		<h3>
			<?=Dictionary::dictLookup('TILTE_USERS')?>
		</h3>
	</div>
</div>
<?php if(isset($list) && sizeof($list) > 0): ?>
<div class="row">
	<div class="col col-lg-12 header">
		<div class="row header">
			<div class="col col-lg-2">
				First name
				<!-- <?=Dictionary::dictLookup('FIRST_NAME')?> -->
			</div>
			<div class="col col-lg-2">
				Last name
				<!-- <?=Dictionary::dictLookup('LAST_NAME')?> -->
			</div>
			<div class="col col-lg-3">
				Num of contacts
				<!-- <?=Dictionary::dictLookup('NUM_OF_CONTACTS')?> -->
			</div>
			<div class="col col-lg-3">
				Email
				<!-- <?=Dictionary::dictLookup('EMAIL')?> -->
			</div>
		</div>
	</div>
</div>
<?php endif ?>