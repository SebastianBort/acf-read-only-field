<?php    
/*
Plugin Name: Advanced Custom Fields: Read only field
Description: Dodaje możliwość oznaczenia pola ACF jako tylko do odczytu w panelu administratora.
Version: 1.0.0
Author: Sebastian Bort
*/

class ACF_Read_Only_Field {
     
	public function __construct() {

          add_action('admin_head',  [$this, 'join_assets']);           
          add_action('acf/render_field', [$this, 'insert_before_field'], 9, 1);
          add_action('acf/render_field', [$this, 'insert_after_field'], 11, 1);            
          add_action('acf/render_field_settings', [$this, 'render_field_settings']);   
          add_filter('acf/prepare_field', [$this, 'prepare_field']);
	}      
    
    public function join_assets() {
    ?>                                     
          <style>
               span.acf-read-only-field .acf-actions > a { /* add row in repeater */
                  display:none; 
               }
               
               span.acf-read-only-field td.acf-row-handle.remove  { /* add / remove buttons on the right of table */
                  display:none;  
               }       
               
               span.acf-read-only-field input,
               span.acf-read-only-field select,
               span.acf-read-only-field label,
               span.acf-read-only-field textarea {   
                    opacity:0.8;  
               }
               
               span.acf-read-only-field input,
               span.acf-read-only-field select,
               span.acf-read-only-field textarea { 
                    background-color: #f7f7f7;    
               }        
          </style>  
          
          <script>
                jQuery(function($) {                      
                    $('.acf-read-only-field input, .acf-read-only-field textarea, .acf-read-only-field select')
                        .attr('readonly', true)
                        .attr('disabled', true);                 
                });          
          </script>
    <?php  
    }     

    public function render_field_settings($field) {  	
          
          acf_render_field_setting($field, [
            	'label' => 'Pole tylko do odczytu?',
            	'instructions'	=> 'Po włączeniu tej opcji wybrane pole będzie niemożliwe do edycji.',
            	'name' => 'read_only',
            	'type' => 'true_false',
            	'ui' => 1,
          ], true); 	
    }    
    
    public function prepare_field($field) {
          
          if(!empty($field['read_only'])) {
                $field['disabled'] = 1;  
          }
          return $field;
    }
    
    public function insert_before_field($field) { 
          
          if(!empty($field['read_only'])) {      
                echo '<span class="acf-read-only-field">';    
          }  
    }
    
    public function insert_after_field($field) { 
          
          if(!empty($field['read_only'])) {      
                echo '</span>';    
          }  
    }
}
new ACF_Read_Only_Field();

?>