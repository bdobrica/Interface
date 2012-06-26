jQuery(document).ready(function(){
	jQuery('.uadd').click(function(e){
		jQuery(e.target).attr('src', '/images/loading.gif');
		jQuery.post('/ajax/aaa.php', jQuery(e.target).closest('tr').find('input').serialize() + '&uadd=1', function (d) {
			alert (d);
			jQuery(e.target).attr('src', '/images/add.png');
			});
		});
	jQuery('.udelete').click(function(e){
		jQuery(e.target).attr('src', '/images/loading.gif');
		jQuery.post('/ajax/aaa.php', jQuery(e.target).closest('tr').find('input').serialize() + '&udelete=1', function (d) {
			alert (d);
			jQuery(e.target).attr('src', '/images/delete.png');
			});
		});
	jQuery('.uedit').click(function(e){
		jQuery(e.target).attr('src', '/images/loading.gif');
		jQuery.post('/ajax/aaa.php', jQuery(e.target).closest('tr').find('input').serialize() + '&uedit=1', function (d) {
			alert (d);
			jQuery(e.target).attr('src', '/images/delete.png');
			});
		});
	jQuery ('.utoggle').click(function(e){
		if (jQuery(e.target).is(':checked')) alert (':)'); else alert(':(');
		
		});
	});
