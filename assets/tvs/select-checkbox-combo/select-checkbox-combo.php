<?php 
	
if (IN_MANAGER_MODE != 'true') {
	die('<h1>ERROR:</h1><p>Please use the Content Manager instead of accessing this file directly.</p>');
}

require_once(MODX_BASE_PATH . 'assets/tvs/select-checkbox-combo/config.inc.php');

$result = $modx->getActiveChildren($start_id, 'pagetitle', 'ASC', 'id, pagetitle');

//id to children
$children = array();

$selectOptions = '<option value="">'.$select_text.'</option>';
foreach($result as $c){
	
	$selectOptions .= '<option value="'.$c['id'].'">'.$c['pagetitle'].'</option>';
	$children[$c['id']] = $modx->getActiveChildren($c['id'], 'pagetitle', 'ASC', 'id, pagetitle');
	
}
?>

<textarea name="tv<?php echo $row['id'] ?>" id="tv<?php echo $row['id'] ?>" cols="30" rows="1" style="display: none"><?php echo $row['value'] ?></textarea>

<select name="tv<?php echo $row['id'] ?>select" id="tv<?php echo $row['id'] ?>select">
	<?php echo $selectOptions ?>
</select>

<div id="tv<?php echo $row ['id'] ?>checkboxes">
	
</div>


<script>
	
(function($) {

	$(document).ready(function () {
	
		var checkboxesWrpId = 'tv<?php echo $row['id'] ?>checkboxes';
		var dependencies = <?php echo json_encode($children) ?>;
		
		var comboHolder = $('#tv<?php echo $row ['id'] ?>');
		var comboValue = new Object();
		//var checkboxValue = new Object();
		
		//on load - get existing combo value
		var eComboValue = comboHolder.val() ? $.parseJSON(comboHolder.val()) : '';

		//on select and initial load
		$('select[name="tv<?php echo $row['id'] ?>select"]').change(function(e){
			
			//detect initial load change. see .change() at the bottom of this
			if(e.originalEvent == undefined){
				
				// in initial trigger - the one on load set the value of the select if something
				if(eComboValue.select){//init select
					$(this).val(eComboValue.select);
				}
				
			}else{
				
				//ntd
			
			}
			
			//set values
			comboValue.select = $(this).val();
			comboValue.checkbox = eComboValue.checkbox ? eComboValue.checkbox : '';
				
			if(comboValue.select){//generate (new) checkboxes
				
				$('#'+checkboxesWrpId).empty();
				
				$.each(dependencies[comboValue.select], function(id, val){
					
					var checked = '';
					
					if(jQuery.inArray(String(val.id), eComboValue.checkbox) >= 0){

						checked = 'checked="checked"';
						
					}
					
					$('#'+checkboxesWrpId).append('<input type="checkbox" '+checked+' onchange="documentDirty=true;" name="tv<?php echo $row ['id'] ?>checkbox[]" id="tv_<?php echo $row ['id'] ?>checkbox_'+val.id+'" value="'+val.id+'"><label for="tv_<?php echo $row ['id'] ?>checkbox_'+val.id+'">'+val.pagetitle+'</label><br/>');
				
				
				});
				
			}else{//remove checkboxes and clear field
				
				$('#'+checkboxesWrpId).empty();
				comboValue.checkbox = '';
			
			}

			//clear
			comboHolder.val();
			//set value
			comboHolder.val(JSON.stringify(comboValue));
			
		}).change();
		
		//on check 
		$('input[name="tv<?php echo $row ['id'] ?>checkbox[]"]').live('click', function(){

			//get checked
			var checkedValues = $('input[name="tv<?php echo $row ['id'] ?>checkbox[]"]:checked').map(function(){
			    return this.value;
			}).get();
			
			//get selected
			comboValue.select = $('select[name="tv<?php echo $row ['id'] ?>select"]').val();
			comboValue.checkbox = checkedValues;
			
			//clear
			comboHolder.val();
			//set value
			comboHolder.val(JSON.stringify(comboValue));
			
		});

	});


}) (jQuery);
	
	
</script>