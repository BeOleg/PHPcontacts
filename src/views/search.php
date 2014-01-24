<fieldset>
    <div class="header">
        <div class="col col-lg-4 filter">
                <label for="query">Filter</label>
               <input type="text" name="query" id="query_string" class="form-control input-medium search-query" data-type="<?global $viewValue; echo $viewValue == '' ? 'main' : $viewValue;?>" data-user-id="<?=isset($_GET['uid']) ? $_GET['uid'] : 0 ?>">
               <!-- short echo ( < ?= ) tag is deprecated -->
        </div>
        <?php if($viewValue == 'bdays'): ?>
	        <div class="col col-lg-4 filter">
	        	<label for="query">Days range</label> 
            <select id="daysRange"  class='form-control input-medium search-query'>
              <?php
                for($i=1; $i<365; $i++){
                  if($i == Config::$DEFAULT_BDAY_RANGE){
                    echo "<option value='{$i}' selected='selected'>{$i} days</option>";
                    continue;
                  }
                  echo "<option value='{$i}'>{$i} days</option>";
                }
              ?>
            </select>
	        </div>
    	<?php endif ?>
    </div>
</fieldset>