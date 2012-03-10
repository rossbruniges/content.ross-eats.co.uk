var ross_eats = document.ross_eats || {};

ross_eats.photo_gallery = function() {
    var API_KEY = '1aed66c45873432ce73afdc8a56720cb',
        $container = $('#images'),
        current_image_num = 0,
        current_image_node,
        current_legend,
        all_nodes,
        gallery_length,
        move_gallery = function(move_to) {
            
            if (move_to === gallery_length) {
                current_image_num = 0;
            } else if (move_to === -1) {
                current_image_num = gallery_length - 1;
            } else {
                current_image_num = move_to;
            }
                        
            current_image_node.css('display','none');
            current_image_node = all_nodes.filter("[data-index='" + current_image_num + "']").css('display','block');
            current_legend.text(current_image_num + 1);
                        
        },
        set_up_gallery = function() {
            
            all_nodes = $container.find('li');
            current_legend = $('#food_legend').find('span:first');
            
            current_image_node = all_nodes.filter(':first').css('display','block');
            
            $('#prev').bind('click',function() {
                move_gallery(current_image_num - 1);
            });
            
            $('#next').bind('click',function() {
                move_gallery(current_image_num + 1);
            });
        },
        create = function(data, original_href) {
            
            gallery_length = data.photoset.photo.length;
            
            var images = [],
			    gallery_string = '<h2>In photos</h2><ul id="food_gallery">',
				flickr = "<a href='" + original_href + "'>View original images on <span class='f'>flick<span>r</span></span></a>",
			    legend = '<div id="food_legend">Showing <span>1</span> of ' + gallery_length + ' ' + flickr + '</div>',
			    prev_button = "<button id='prev'>&#9668;<span>Previous photo</span></button>",
			    next_button = "<button id='next'>&#9658;<span>Next photo</span></button>";
			    			    
            $.each(data.photoset.photo, function(i, item) {
				var img_src = 'http://farm' + item.farm + '.static.flickr.com/' + item.server + '/' + item.id + '_' + item.secret + '_m.jpg';
				images.push('<li data-index=' + i + '><img src=' + img_src + ' alt="#" />' + item.title + '</li>');
			});
			
			gallery_string +=  images.join('');

			gallery_string += '</ul>' + legend + prev_button + next_button;

			$container.html(gallery_string);
			
			set_up_gallery();
			
        },
        fail = function(data) { console.log(data, 'error called'); },
        create_rest_url = function(set_id) {
            return rest_url = 'http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' + API_KEY  + '&photoset_id=' + set_id + '&format=json&jsoncallback=?';
        },
        load_api_images = function(trigger) {
            
            var href = trigger.attr('href'),
				set_id = href.split('sets/')[1],
                rest = create_rest_url(set_id);
                            
            $container.addClass('active');
            trigger.text('Loading images from Flickr');
            
            $.ajax({
                url: rest,
                dataType: 'json',
                timeout: 3000,
                success: function(data) {
                    create(data, href);
                },
                error: function(data) {
                    fail(data);
                }
            });
            
        },
        init = function() {
            if ($container.length) {
                anchor = $container.find('a').bind('click', function() {
                    load_api_images($(this));
                    return false; 
                });
            }
        };
    
    return {
        init:init
    };
    
}();

$(function() {
    ross_eats.photo_gallery.init();
});