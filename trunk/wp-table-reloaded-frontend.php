<?php
/*
File Name: WP-Table Reloaded - Frontend Class (see main file wp-table-reloaded.php)
Plugin URI: http://tobias.baethge.com/wordpress-plugins/wp-table-reloaded/
Description: This plugin allows you to create and manage tables in the admin-area of WordPress. You can then show them in your posts or on your pages by using a shortcode. The plugin is greatly influenced by the plugin "WP-Table" by Alex Rabe, but was completely rewritten and uses the state-of-the-art WordPress techniques which makes it faster and lighter than the original plugin.
Version: 0.9
Author: Tobias B&auml;thge
Author URI: http://tobias.baethge.com/
*/

class WP_Table_Reloaded_Frontend {

    // ###################################################################################################################
    // plugin variables
    var $options = array();
    var $tables = array();

    var $optionname = array(
        'tables' => 'tb_wp_table_tables',
        'options' => 'tb_wp_table_options',
        'table' => 'tb_wp_table_data'
    );
    var $shortcode = 'table';

    // ###################################################################################################################
    function WP_Table_Reloaded_Frontend() {
		// front-end function
		add_shortcode( $this->shortcode, array( &$this, 'handle_shortcode' ) );
    }

    // ###################################################################################################################
    // handle [table id=<the_table_id> /]
    function handle_shortcode( $attr ) {
        $table_id = $attr['id'];

        if ( !is_numeric( $table_id ) || 1 > $table_id)
            return '';

        // load options and table information from database, if not available: default
		$this->options = get_option( $this->optionname['options'], false );
		$this->tables = get_option( $this->optionname['tables'], false );
		
		if ( false === $this->options || false === $this->tables )
            return '';

        $table = $this->load_table( $table_id );

        $output = $this->render_table( $table['data'] );

        return $output;
    }

    // ###################################################################################################################
    function load_table( $table_id ) {
        $this->tables[ $table_id ] = ( isset( $this->tables[ $table_id ] ) ) ? $this->tables[ $table_id ] : $this->optionname['table'] . '_' . $table_id;
        $table = get_option( $this->tables[ $table_id ], $this->default_table);
        return $table;
    }

    // ###################################################################################################################
    // echo content of array
    function render_table( $data ) {
        $table_before = "<table>\n";
        $table_after  = "</table>\n";
        $row_before   = "\t<tr>\n";
        $row_after    = "\t</tr>\n";
        $cell_before  = "\t\t<td>";
        $cell_after  = "</td>\n";

        $rows = count( $data );
        $cols = (0 < $rows) ? count( $data[0] ) : 0;

        $output = '';

        if ( 0 < $rows && 0 < $cols) {
            $output .= $table_before;

            foreach( $data as $row_idx => $row ) {
                $output .= $row_before;
                foreach( $row as $col_idx => $cell_content ) {
                    $cell_content = $this->safe_output( $cell_content );
                    $output .= $cell_before . "{$cell_content}" . $cell_after;
                }
                $output .= $row_after;
            }
            $output .= $table_after;
        }

        return $output;
    }

    // ###################################################################################################################
    function safe_output( $string ) {
        return stripslashes( $string );
    }

} // class WP_Table_Reloaded_Frontend

?>