<?php
/*
File Name: WP-Table Reloaded - Import Class (see main file wp-table-reloaded.php)
Plugin URI: http://tobias.baethge.com/wordpress-plugins/wp-table-reloaded/
Description: This plugin allows you to create and manage tables in the admin-area of WordPress. You can then show them in your posts or on your pages by using a shortcode. The plugin is greatly influenced by the plugin "WP-Table" by Alex Rabe, but was completely rewritten and uses the state-of-the-art WordPress techniques which makes it faster and lighter than the original plugin.
Version: 0.9
Author: Tobias B&auml;thge
Author URI: http://tobias.baethge.com/
*/

// should be included by WP_Table_Reloaded_Admin!
class WP_Table_Reloaded_Import {

    // ###################################################################################################################
    var $import_class_version = '0.9';

    var $delimiters = array();

    var $filename = '';
    var $tempname = '';
    var $mimetype = '';
    var $delimiter = ';';
    var $imported_table = array();
    

    // ###################################################################################################################
    // constructor class
    function WP_Table_Reloaded_Import() {
        // initiate here, because function call __() not allowed outside function
        $this->delimiters = array(
            ';' => __( '; (semicolon)', TB_WP_TABLE_TEXTDOMAIN ),
            ',' => __( ', (comma)', TB_WP_TABLE_TEXTDOMAIN ),
            ':' => __( ': (colon)', TB_WP_TABLE_TEXTDOMAIN )
        );
    }

    // ###################################################################################################################
    function import_table() {
        $table['name'] = $this->filename;
        $table['description'] = $this->filename . ' (' . $this->mimetype . ')';

        $temp_data = $this->csv_file_to_array( $this->tempname, $this->delimiter, '"' );
        $table['data'] = $this->pad_array_to_max_cols( $temp_data );
        $this->imported_table = $table;
    }

    // ###################################################################################################################
    function unlink_csv_file() {
        unlink( $this->tempname );
    }

    // ###################################################################################################################
    function csv_file_to_array( $filename, $delimiter = ';', $enclosure = '"' ) {
        $data = array();
        $handle = fopen( $filename, 'r' );
            while ( false !== ( $read_line = fgetcsv( $handle, 1024, $delimiter, $enclosure ) ) ) {
                $data[] = $this->add_slashes( $read_line );
            }
        fclose($handle);
        return $data;
    }

    // ###################################################################################################################
    // make sure array is rectangular with $max_cols columns in every row
    function pad_array_to_max_cols( $array_to_pad ){
        $rows = count( $array_to_pad );
        $max_columns = $this->count_max_columns( $array_to_pad );
        // array_map wants arrays as additional parameters (so we create one with the max_cols to pad to and one with the value to use (empty string)
        $max_columns_array = array_fill( 1, $rows, $max_columns );
        $pad_values_array =  array_fill( 1, $rows, '' );
        return array_map( 'array_pad', $array_to_pad, $max_columns_array, $pad_values_array );
    }

    // ###################################################################################################################
    // find out how many cols the longest row has
    function count_max_columns( $array ){
        $max_cols = 0 ;
        if ( is_array( $array ) && 0 < count( $array ) ) {
                foreach ( $array as $row_idx => $row ) {
                    $cols  = count( $row );
                    $max_cols = ( $cols > $max_cols ) ? $cols : $max_cols;
                }
        }
        return 	$max_cols;
    }

    // ###################################################################################################################
    function add_slashes( $array ) {
        return array_map( 'addslashes', $array );
    }

} // class WP_Table_Reloaded_Import

?>