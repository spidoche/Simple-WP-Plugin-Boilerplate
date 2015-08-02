<?php $options = get_option('prefix_'); // get plugin options store in the DB ?>

<div class="wrap">
    
    <div id="icon-options-general" class="icon32">&nbsp;</div>
    
    <h2>Options</h2>
    
    <?php if(!empty($_GET['settings-updated'])){ ?>
        <div id="setting-error-settings_updated" class="updated settings-error"> 
             <p><strong>Settings saved.</strong></p>
        </div>
    <?php } ?>
    
    <form method="post" action="options.php">
    
    	<?php settings_fields('prefix_options'); ?>
    
        <table class="form-table">            
            
            <tr>
                <th scope="row"><label for="text01">Text 01</label></th> 
                <td>
                    <input id="text01" name="prefix_[text01]" type="text" value="<?php if(isset($options['text01'])){ echo $options['text01'];} ?>" />                  
                </td>
            </tr>
            
            <tr>
                <th scope="row"><label for="checkbox01">Checkbox 01</label></th> 
                <td>
                    <input id="checkbox01" name="prefix_[checkbox01]" type="checkbox" <?php if(isset($options['checkbox01'])){ echo 'checked="checked"';} ?> />
                    <span class="description">Options checkbox 01</span>                   
                </td>
            </tr>
                    
            <tr>
                <th scope="row"><label for="checkbox02">Options checkbox 02</label></th> 
                <td>
                    <input id="checkbox02" name="prefix_[checkbox02]" type="checkbox" <?php if(isset($options['checkbox02'])){ echo 'checked="checked"';} ?> />
                    <span class="description">Options checkbox 02</span>            
                </td>
            </tr>
                    
            <tr>
                <th scope="row">Options radio</th> 
                <td>
                    <input type="radio" name="prefix_[radio01]" id="radio_a" <?php if($options['radio01']=='radio_a'){ echo'checked="checked"';}?> value="radio_a" />
                    <label for="radio_a">radio option A</label>
                                
                    <input type="radio" name="prefix_[radio01]" id="radio_b" <?php if($options['radio01']=='radio_b'){ echo'checked="checked"';}?> value="radio_b" />
                    <label for="radio_b">radio option B</label> 
                </td>
            </tr>
                    
            <tr>
                <th scope="row"><label for="upload_url">Upload photo</label></th> 
                <td>
                    <input type="hidden" name="prefix_[upload]" id="prefix_upload_url" value="<?php if(isset($options['upload'])){ echo $options['upload'];} ?>" />
                    <a href="#" id="prefix_images_upload" class="button-secondary">Upload</a>
                    
                    <div id="prefix_images_upload_container">
                    	<?php if(!empty($options['upload'])){ ?>
							<?php 
							$image_id  = $options['upload'];
							$image_url = wp_get_attachment_image_src( $image_id, 'medium');
							$image_url = $image_url[0];
							?>
                            <img src="<?php echo $image_url; ?>" alt="upload image" />
                            <span>X</span>
						<?php } ?>
                    </div>
                </td>
            </tr>
            
            <?php wp_enqueue_media(); // add wp.media scripts ?>
            
            <script>
				jQuery(function($){
					
					// OPEN THE MODAL UPLOAD WINDOW
					$('#prefix_images_upload').click(function(e) {
						e.preventDefault();
					
						var custom_uploader = wp.media({
							
							title    : 'Select image',
							library  : { type : 'image'},
							button   : { text : 'Select image' },
							multiple : false  // Set this to true to allow multiple files to be selected
							
						}).on('select', function() {
													
							var attachments = custom_uploader.state().get('selection').toJSON();
							var html = "";
							
							console.log(attachments); 
				
							$.each(attachments, function (key, attachment) {
							    html += '<img data-id="'+attachment.id+'" src="'+attachment.sizes.medium.url+'" alt="" /><span>X</span>'; 				  
							    $('#prefix_upload_url').val(attachment.id);
							});
							
							$('#prefix_images_upload_container').html(html);
							
							$('#prefix_images_upload_container span').on('click',function(){
								$('#prefix_upload_url').val('');
								$('#prefix_images_upload_container img, #prefix_images_upload_container span').remove();
							});
											
						}).open();
					});
					
					$('#prefix_images_upload_container span').on('click',function(){
						$('#prefix_upload_url').val('');
						$('#prefix_images_upload_container img, #prefix_images_upload_container span').remove();
					});
					
				}); // END jQuery
			</script>
        
        </table>        
    
    	<p class="submit">
        	<input type="submit" name="submit" id="submit" class="button-primary" value="Save" />
        </p>
        
    </form>

</div><!-- .wrap -->