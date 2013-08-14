<?php
/*
    Section: Button Array
	Author: opportunex - Thomas Butler
	Author URI: http://opportunex.com
	Description: Create a button array with multiple display options.
	Class Name: PLbutton_array
	Filter: component
	Loading: active
*/

class PLbutton_array extends PageLinesSection {

	var $btn = 'pl_button_array';
	var $button_style = 'btn-large';
    var $default_limit = 3;
    
	// Button Options
	function section_opts(){

		$options = array();

		$options[] = array(
			'title'                   => __( 'Button Array Configuration', 'button-array' ),
			'type'	                  => 'multi',
			'opts'	                  => array(
				array(
					'key'			  => $this->btn.'count',
					'type' 			  => 'count_select',
					'count_start'	  => 1,
					'count_number'	  => 12,
					'default'		  => 3,
					'label' 	      => __( 'Number of Buttons to Configure', 'button-array' ),
				),
				array(
                        'key'         => $this->btn.'layout',
                        'type'        => 'select',
                        'default'     => '12',
                        'title'		  => __( 'Layout', 'button-array' ),
                        'opts'        => array(
                        '12'          => array('name' => __('1 Column', 'button-array')),
                        '6'           => array('name' => __('2 Column', 'button-array')),
                        '4'           => array('name' => __('3 Column', 'button-array')),
                        '3'           => array('name' => __('4 Column', 'button-array')),
                    ),
				),
				array(
					'key'             => $this->btn.'button_style',
					'type'            => 'select',
					'default'         => 'btn-large',
					'title'		      => __( 'Button Size', 'button-array' ),
					'opts'            => array(
                    	'btn-large'   => array('name' => __('Large', 'button-array')),
                    	'btn-default'   => array('name' => __('Normal', 'button-array')),
						'btn-small'    => array('name' => __('Small', 'button-array')),
						'btn-mini'    => array('name' => __('Mini', 'button-array')),
					),
				),
                array(
					'key'		      => $this->btn.'button_height',
					'label'		      => __( 'Specify Height', 'button-array' ),
					'type'		      => 'text'
				),
                
                
                //future enhancement will handel padding/margins
                //array(
					//'key'		      => $this->btn.'button_margin',
					//'label'		      => __( 'Button Margin (default is 8px)', 'button-array' ),
					//'type'		      => 'text'
				//),
				
			)

		);

		$items = ($this->opt($this->btn.'count')) ? $this->opt($this->btn.'count') : $this->default_limit;
        
		for($i = 1; $i <= $items; $i++){

			$opts = array(

				array(
					'key'		      => $this->btn.'button_val_'.$i,
					'label'		      => __( 'Button Text', 'button-array' ),
					'type'		      => 'text'
				),
				array(
					'key'		      => $this->btn.'button_link_'.$i,
					'label'		      => __( 'Button Link', 'button-array' ),
					'type'		      => 'text'
				),
				array(
					'key'		      => $this->btn.'button_link_target_'.$i,
					'label'		      => __( 'Link Target', 'button-array' ),
					'type'		      => 'select',
					'default'         => '_self',
					'opts'            => array(
                    	'_blank'      => array('name' => __('New Window', 'button-array')),
                    	'_self'       => array('name' => __('Same Window', 'button-array')),
					),
				),
                array(
					'key'		      => $this->btn.'button_class_'.$i,
					'label'		      => __( 'Class Selector', 'button-array' ),
					'type'		      => 'text'
				),
                array(
					'key'			=> $this->btn.'button_theme_'.$i,
					'type' 			=> 'select_button',
					'label'			=> __( 'Button Color', 'button-array' ),
				),
                array(
					'key'		      => $this->btn.'button_icon_align_'.$i,
					'label'		      => __( 'Align Icon', 'button-array' ),
					'type'		      => 'select',
					'default'         => 'pull-left',
					'opts'            => array(
                    	'pull-left'   => array('name' => __('Left (default)', 'button-array')),
                    	'pull-right'  => array('name' => __('Align Left', 'button-array')),
					),
				),

			);
            
            $opts[] = array(
				'key'		=> $this->btn.'button_icon_'.$i,
				'label'		=> __( 'Button Icon', 'button-array' ),
				'type'		=> 'select_icon',
			);

			$options[] = array(
				'title' 	          => __( 'Button ', 'button-array' ) . $i,
				'type' 		          => 'multi',
				'opts' 		          => $opts
			);

		}

		return $options;
	}
       
    function section_template() {

        $id = $this->get_the_id();
        $layout = $this->opt($this->btn.'layout') ? $this->opt($this->btn.'layout') : '12';

        if($layout == 12) {
            
            printf('<div id="button-array-%s" class="button-array row zmt zmb"><div class="zmt zmb span%s">',$id,$layout);
        
        }else {

        	printf('<div id="button-array-%s" class="button-array"><div class="row zmt zmb">',$id);

        }
            
            $count = 0;
            $itemsct = 0;
            $output = '';
            $margin = 8;
            $items  = ($this->opt($this->btn.'count')) ? $this->opt($this->btn.'count') : $this->default_limit;
            $style  = $this->opt($this->btn.'button_style') ? $this->opt($this->btn.'button_style') : 'btn-large';
            $height  = $this->opt($this->btn.'button_height') ? $this->opt($this->btn.'button_height') : 'auto';
            
            for($i = 1; $i <= $items; $i++):
                
                $count++;
                $itemsct++;
                $rowcount = 12/$layout;
                
                if($layout != 12) { $output = $output.= sprintf('<div class="zmt zmb span%s">',$layout); }

                    $btntext    = $this->opt($this->btn.'button_val_'.$i);
                    $btnlink   = $this->opt($this->btn.'button_link_'.$i);
                    $target = $this->opt($this->btn.'button_link_target_'.$i) ? $this->opt($this->btn.'button_link_target_'.$i) : '_self';
                    $btnclass    = $this->opt($this->btn.'button_class_'.$i);
                    $btntheme = ($this->opt($this->btn.'button_theme_'.$i));
                    $btnicon = ($this->opt($this->btn.'button_icon_'.$i)) ? $this->opt($this->btn.'button_icon_'.$i) : false;
                    $iconalign = ($this->opt($this->btn.'button_icon_align_'.$i)) ? $this->opt($this->btn.'button_icon_align_'.$i) : 'pull-left';
                    
                    if($height != "auto") { $height = $height."px !important;"; }
                    
                    if($btnicon) {
    
                    	$output = $output .= sprintf('<div class="button-array-button"><a style="margin:%spx !important; min-height:%s" class="btn %s %s input-block-level pull-left %s" href="%s" target="%s" ><i class="icon-%s %s"></i>%s</a></div>',$margin,$height,$style,$btntheme,$btnclass,$btnlink,$target,$btnicon,$iconalign,$btntext,$i);
    
                    } else {
    
                    	$output = $output .= sprintf('<div class="button-array-button""><a style="margin:%spx !important; min-height:%s" class="btn %s %s input-block-level pull-left %s" href="%s" target="%s" >%s</a></div>',$margin,$height,$style,$btntheme,$btnclass,$btnlink,$target,$btntext,$i);
                    }
       
                if($layout != 12) { 
                    
                    $output = $output.= sprintf('</div>');        
                
                    if($count == $rowcount && $itemsct != $items) { 
                        
                        $output = $output.= sprintf('</div><div class="row zmt zmb">'); $count = 0; 
                    
                    }
                    
                }
                
            endfor;

            if($output == '') {

                $this->defaults();

            } else {

                echo $output;

            }

        printf('</div></div>');
	}

	function defaults(){
		for($i=1;$i<=3;$i++) {
			//printf('<div class="button-array-button"><button class="btn btn-large" href="http://google.com" type="button">Add Your Link Here!</button></div>',$i);
		  	printf('<div class="button-array-button"><a class="btn btn-large input-block-level pull-left" href="#">Add Your Link Here!</a></div>',$i);
        }
	}

}