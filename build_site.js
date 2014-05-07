jQuery(document).ready(function() {
	jQuery('.permalink-structure input:radio').change(function() {
		if ( 'custom' == this.value )
			return;
		jQuery('#permalink_structure').val( this.value );
	});
	jQuery('#permalink_structure').focus(function() {
		jQuery("#custom_selection").attr('checked', 'checked');
	});
});
(function($) {
    $(document).ready(function() {
    	$('#asc_site_settings').accordion({
    		collapsible: true,
    		heightStyle: "content"
    	});
    	$('#theme-id-multi, #plugins-multiselect').select2({width: '100%'});

    	//handle site cloning
        //toggle
        $('#create-site-from-template').click(function(){
            if(!$('#create-site-from-template').is(':checked')){
                //show the default
                $('#build-site-frm').attr('action', 'http://' + window.location.host + '/wp-admin/network/site-new.php?action=add-site&build_site=true');
            }else{
                $('#build-site-frm').attr('action',window.location.href);
            }
        });

        $('#build-site').click(function(e){
        var self = this;
        //check if option to clone is enabled
        if($('#create-site-from-template').is(':checked')){
            //the ajax call
            var action = 'clone_site_ajax';
            var nonce = $('#_wpnonce_clone-site').val();
            $(this).hide();
            $('.preloader').show(); 
            $('#clone-log').html('');
            $('#clone-log').html('Cloning site... \n');

            //the values
            var values = {}
            values['domain'] = $('input[name=blog\\[domain\\]]').val();
            values['title'] = $('input[name=blog\\[title\\]]').val();
            values['domain_name'] = $('input[name=blog\\[domain_name\\]]').val();
            values['site_template'] = $('#clone-site-template').val();
            values['site_user'] = $('#clone-site-user').val();
            values['include_uploads'] = $('#clone-site-uploads-import').is(':checked')?true:false;
            values['overwrite-clone-site-settings'] = $('#overwrite-clone-site-settings').is(':checked')?true:false;
            values['has_user_settings'] = $('#has_user_settings').val();
           	values['user_settings'] = $('#build-site-frm').serialize();
           	
            $.ajax({
                type : "post",
                url : build_site_ajax.ajaxurl,
                data : {
                    action: action,
                    values : values,
                    nonce   : nonce
                },
                success: function(response) {
                    if(response.success==true){
                        $('#clone-log').html($('#clone-log').html()+response.message);
                        $(self).show();
                        $('.preloader').hide();
                        //add notice
                        var notice = $('<div id="message" class="updated"><p>'+response.notice+'</p></div>');
                        if($('#message').length){
                            $('#message').html('<p>'+response.notice+'</p>');
                        }else{
                            notice.insertAfter($('#add-new-site'));
                        }
                    }else{
                        $('#clone-log').html($('#clone-log').html()+response.message);
                        $(self).show();
                        $('.preloader').hide();
                    }
                }
            });
			//console.log(values, action);
            e.preventDefault();    
        }
    });
        
    });
})(jQuery);