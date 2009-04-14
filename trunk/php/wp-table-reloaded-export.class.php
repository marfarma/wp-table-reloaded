<?php
/*
File Name: WP-Table Reloaded - Export Class (see main file wp-table-reloaded.php)
Plugin URI: http://tobias.baethge.com/wordpress-plugins/wp-table-reloaded/
Description: This plugin allows you to create and manage tables in the admin-area of WordPress. You can then show them in your posts or on your pages by using a shortcode. The plugin is greatly influenced by the plugin "WP-Table" by Alex Rabe, but was completely rewritten and uses the state-of-the-art WordPress techniques which makes it faster and lighter than the original plugin.
Version: 1.0
Author: Tobias B&auml;thge
Author URI: http://tobias.baethge.com/
*/

// should be included by WP_Table_Reloaded_Admin!
class WP_Table_Reloaded_Export {

    // ###################################################################################################################
    var $export_class_version = '1.0';

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
            'html' => __( 'HTML - Hypertext Markup Language', TB_WP_TABLE_TEXTDOMAIN ),
            'xml' => __( 'XML - eXtended Markup Language', TB_WP_TABLE_TEXTDOMAIN )
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
                        $row = array_map( array( &$this, 'csv_wrap_and_escape' ), $row );
                        $output .= implode( $this->delimiter, $row ) . "\n";
                    }
                }
                }
                break;
            case 'xml':
                if ( 0 < $rows && 0 < $cols) {
                    $output .= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
                    $output .= "<table>\n";
                    foreach ( $data as $row_idx => $row ) {
                        $output .= "\t<row>\n";
                        $row = array_map( array( &$this, 'xml_wrap_and_escape' ), $row );
                        $output .= implode( '', $row );
                        $output .= "\t</row>\n";
                    }
                    $output .= '</table>';
                }
                break;
            case 'html':
                if ( 0 < $rows && 0 < $cols) {
                    $output .= "<table>\n";
                    foreach ( $data as $row_idx => $row ) {
                        $output .= "\t<tr>\n";
                        $row = array_map( array( &$this, 'html_wrap_and_escape' ), $row );
                        $output .= implode( '', $row );
                        $output .= "\t</tr>\n";
                    }
                    $output .= '</table>';
                }
                break;
            default:
        }
        $this->exported_table = $output;
    }

    // ###################################################################################################################
    function csv_wrap_and_escape( $string ) {
        $string = stripslashes( $string );
        $string = str_replace( '"', '""', $string );
        return ( false !== strpos( $string, $this->delimiter ) || false !== strpos( $string, '""' ) ) ? ( '"' . $string . '"' ) : $string;
    }

    // ###################################################################################################################
    function xml_wrap_and_escape( $string ) {
        $string = stripslashes( $string );
        if ( $string != htmlspecialchars( $string ) )
            $string = "<![CDATA[{$string}]]>";
        return "\t\t<col>" . $string . "</col>\n";
    }

    // ###################################################################################################################
    function html_wrap_and_escape( $string ) {
        $string = stripslashes( $string );
        return "\t\t<td>" . $string . "</td>\n";
    }
    
} // class WP_Table_Reloaded_Export

?>