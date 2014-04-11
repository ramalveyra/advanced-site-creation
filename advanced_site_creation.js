(function($) {
    $(document).ready(function() {
        
        //for multiselect plugin 
        $("#plugins-multiselect").select2({placeholder: "Select Plugins"});
        $("#theme-id-multi").select2({placeholder: "Select Theme",
        allowClear: true});

        var handleThemeClick = function(){
            //remove themes class active
            $('.theme').removeClass('active');

            //remove 'selected' as well
            $('.theme-name').find('span').remove();

            var id = this.id;
            $.each($('.theme'),function(key,elem){
                if(elem.id == id){
                    $(elem).addClass('active');
                    $(elem).find('.theme-name').prepend($('<span>Active: </span>'));
                    $('#theme-id').val(elem.id);
                }
            });
        };

        //the pagination handle
        var handlePaginationClicks = function(){
            var target = $(this).parent().attr('class').replace('pagination-links ','');
            var page_action = $(this).attr('class').replace(' disabled','');
            if(target=='paginate-themes'){
                var action = 'get_themes_ajax';
                var search_query = $('#theme-search-input').val();
                var nonce = $('#_wpnonce_theme-search').val();
            }else if (target=='paginate-plugins'){
                search_query = $('#plugins-search-input').val();
                nonce = $('#_wpnonce_plugins-search').val();
                action = 'get_plugins_ajax';
            }
            var current_page = $(this).parent().find('.paging-input').find('.current-page-count').val();
            var total_pages = $(this).parent().find('.paging-input').find('.total-pages').html();
            
            $.ajax({
                type : "post",
                url : asc_ajax.ajaxurl,
                data : {
                    action: action, 
                    current_page : current_page,
                    total_pages : total_pages,
                    page_action : page_action,
                    search_query : search_query,
                    nonce   : nonce
                },
                success: function(response) {
                    if(action == 'get_themes_ajax'){
                        $('.theme-browser').html(response);
                        bindEvents();
                    }else if(action == 'get_plugins_ajax'){
                        $('.plugins-browser').html(response);
                        bindEvents();

                    }
                }
            });
        };

        var handlePaginationInput = function(e){
            //prevent submission on enter
            if(e.keyCode == 13) {
                e.preventDefault();
                var target = $(this).parent().parent().attr('class').replace('pagination-links ','');
                if(target=='paginate-themes'){
                var action = 'get_themes_ajax';
                var search_query = $('#theme-search-input').val();
                var nonce = $('#_wpnonce_theme-search').val();
                }else if (target=='paginate-plugins'){
                    action = 'get_plugins_ajax';
                    search_query = $('#plugins-search-input').val();
                    nonce = $('#_wpnonce_plugins-search').val();
                }
                var current_page = $(this).val();
                var total_pages = $(this).parent().find('.total-pages').html();

                $.ajax({
                    type : "post",
                    url : asc_ajax.ajaxurl,
                    data : {
                        action: action, 
                        current_page : current_page,
                        total_pages : total_pages,
                        page_action : 'goto-page',
                        search_query : search_query,
                        nonce   : nonce
                    },
                    success: function(response) {
                        if(action == 'get_themes_ajax'){
                            $('.theme-browser').html(response);
                            bindEvents();
                        }else if(action == 'get_plugins_ajax'){
                            $('.plugins-browser').html(response);
                            bindEvents();
                        }
                    }
                });

                return false;
            }
            
        }
        var req = null;
        //search handle
        var handleSearch = function(e,target){
            if (req != null) req.abort();

            var that = this,
            value = $(this).val();

            var search_query = $(this).val();
            if($(this).attr('id')=='theme-search-input'){
               var action = 'get_themes_ajax';
               var nonce = $('#_wpnonce_theme-search').val(); 
            }else if($(this).attr('id')=='plugins-search-input'){
               var action = 'get_plugins_ajax';
               var nonce = $('#_wpnonce_plugins-search').val(); 
            }
            req = $.ajax({
                type : "post",
                url : asc_ajax.ajaxurl,
               data : {
                        action: action, 
                        current_page : 1,
                        total_pages : 1,
                        page_action : 'search',
                        search_query : search_query,
                        nonce   : nonce
                    },
                success: function(response) {
                    if (value==$(that).val()) {
                        if(action == 'get_themes_ajax'){
                            $('.theme-browser').html(response);
                            focusCampo('theme-search-input');
                            bindEvents();
                        }else if(action == 'get_plugins_ajax'){
                            $('.plugins-browser').html(response);
                            focusCampo('plugins-search-input');
                            bindEvents();
                        }
                    }
                }
            });
        }

        var preventSubmit = function(e, target){
            //prevent submission on enter
            if(e.keyCode == 13) {
                e.preventDefault();
                return false;    
            }
        }
        var bindEvents = function(){
            $('.theme').bind('click',handleThemeClick);
            $('#theme-search-input').bind('keyup',handleSearch);
            $('#plugins-search-input').bind('keyup',handleSearch);
            $('#theme-search-input').bind('keypress',preventSubmit);
            $('#plugins-search-input').bind('keypress',preventSubmit);
            $('.pagination-links a').bind('click',handlePaginationClicks);
            $('.pagination-links input.current-page').bind('keydown',handlePaginationInput);    
        }

        var focusCampo = function(id){
            var inputField = document.getElementById(id);
            if (inputField != null && inputField.value.length != 0){
                if (inputField.createTextRange){
                    var FieldRange = inputField.createTextRange();
                    FieldRange.moveStart('character',inputField.value.length);
                    FieldRange.collapse();
                    FieldRange.select();
                }else if (inputField.selectionStart || inputField.selectionStart == '0') {
                    var elemLen = inputField.value.length;
                    inputField.selectionStart = elemLen;
                    inputField.selectionEnd = elemLen;
                    inputField.focus();
                }
            }else{
                inputField.focus();
            }
        }

        //handle site cloning
        //var handleCloneSite = function()
        $('#add-site').click(function(e){
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
                values['site_user'] = $('#clone-site-user').val()

                $.ajax({
                    type : "post",
                    url : asc_ajax.ajaxurl,
                    data : {
                        action: action,
                        values : values,
                        //current_page : current_page,
                        //total_pages : total_pages,
                        //page_action : 'goto-page',
                        //search_query : search_query,
                        nonce   : nonce
                    },
                    success: function(response) {
                        if(response.success==true){
                            $('#clone-log').html($('#clone-log').html()+response.message);
                        }else{
                            $('#clone-log').html($('#clone-log').html()+response.message);
                            $(self).show();
                            $('.preloader').hide();
                        }
                    }
                });
                e.preventDefault();    
            }
        });

        bindEvents();
    });
})(jQuery);