<?php
/*
File Name: WP-Table Reloaded - Export Class (see main file wp-table-reloaded.php)
Plugin URI: http://tobias.baethge.com/wordpress-plugins/wp-table-reloaded/
Description: This plugin allows you to create and manage tables in the admin-area of WordPress. You can then show them in your posts or on your pages by using a shortcode. The plugin is greatly influenced by the plugin "WP-Table" by Alex Rabe, but was completely rewritten and uses the state-of-the-art WordPress techniques which makes it faster and lighter than the original plugin.
Version: 0.9
Author: Tobias B&auml;thge
Author URI: http://tobias.baethge.com/
*/

// should be included by WP_Table_Reloaded_Admin!
class WP_Table_Reloaded_Export {

    // ###################################################################################################################
    var $export_class_version = '0.9';

    var $export_formats = array();
    var $delimiters = array();
    
    var $export_format = '';
    var $delimiter = ';';
    var $table_to_export = array();
    var $exported_table = '';

    // ###################################################################################################################
    // constructor class
    function WP_Table_Reloaded_Export() {
        // initiate here, because function call __() not allowed outside function
        $this->export_formats = array(
            'csv' => __( 'CSV - Character-Separated Values', TB_WP_TABLE_TEXTDOMAIN ),
            //'xml' => __( 'XML - eXtended Markup Language', TB_WP_TABLE_TEXTDOMAIN ),
        );
        $this->delimiters = array(
            ';' => __( '; (semicolon)', TB_WP_TABLE_TEXTDOMAIN ),
            ',' => __( ', (comma)', TB_WP_TABLE_TEXTDOMAIN ),
            ':' => __( ': (colon)', TB_WP_TABLE_TEXTDOMAIN )
        );
    }

    // ###################################################################################################################
    function export_table() {
        $output = '';
        
        $data = $this->table_to_export['data'];
        
        $rows = count( $data );
        $cols = (0 < $rows) ? count( $data[0] ) : 0;
        
        switch( $this->export_format ) {
            case 'csv':
                if ( 0 < $rows && 0 < $cols) {
                if ( function_exists( 'fputcsv' ) ) { // introduced in PHP 5.1.0
                    if ( function_exists( 'sys_get_temp_dir' ) ) { // introduced in PHP 5.2.1
                        $temp_file = tempnam( sys_get_temp_dir(), 'export_table_' . $this->table_to_export['id'] . '_' );
                        $handle = fopen( $temp_file, 'w' );
                        foreach ( $data as $row_idx => $row ) {
                            $row = array_map( 'stripslashes', $row );
                            fputcsv( $handle, $row, $this->delimiter, '"' );
                        }
                        fclose( $handle );
                        $output = file_get_contents( $temp_file );
                    } else {
                        $handle = tmpfile();
                        foreach ( $data as $row_idx => $row ) {
                            $row = array_map( 'stripslashes', $row );
                            fputcsv( $handle, $row, $this->delimiter, '"' );
                        }
                        fseek($handle, 0);
                        while ( !feof( $handle ) ) {
                            $output .= fread( $handle, 1024);
                        }
                        fclose( $handle );
                    }
                } else { // should word for all PHP versions
                    foreach( $data as $row_idx => $row ) {
                        $row = array_map( array( &$this, 'wrap_and_escape' ), $row );
                        $output .= implode( $this->delimiter, $row ) . "\n";
                    }
                }
                }
                break;
            // case 'xml':
            default:
                $output = __( 'The Table could not be exported due to a wrong export format.', TB_WP_TABLE_TEXTDOMAIN );
        }
        $this->exported_table = $output;
    }

    // ###################################################################################################################
    function wrap_and_escape( $string ) {
        $string = stripslashes( $string );
        $string = str_replace( '"', '""', $string );
        return ( false !== strpos( $string, $this->delimiter ) || false !== strpos( $string, '""' ) ) ? ( '"' . $string . '"' ) : $string;
    }
    
} // class WP_Table_Reloaded_Export

?>