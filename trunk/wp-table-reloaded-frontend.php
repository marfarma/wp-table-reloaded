<?php
/*
File Name: WP-Table Reloaded - Frontend Class (see main file wp-table-reloaded.php)
Plugin URI: http://tobias.baethge.com/wordpress-plugins/wp-table-reloaded/
Description: This plugin allows you to create and manage tables in the admin-area of WordPress. You can then show them in your posts, on your pages or in text widgets by using a shortcode. The plugin is a completely rewritten and extended version of Alex Rabe's "WP-Table" and uses the state-of-the-art WordPress techniques which makes it faster and lighter than the original plugin.
Version: 0.9.3-beta2
Author: Tobias B&auml;thge
Author URI: http://tobias.baethge.com/
*/

class WP_Table_Reloaded_Frontend {

    // ###################################################################################################################
    // plugin variables
    var $options = array();
    var $tables = array();

    var $optionname = array(
        'tables' => 'wp_table_reloaded_tables',
        'options' => 'wp_table_reloaded_options',
        'table' => 'wp_table_reloaded_data'
    );
    var $shortcode = 'table';

    // ###################################################################################################################
    function WP_Table_Reloaded_Frontend() {
        // load options and table information from database, if not available: default
		$this->options = get_option( $this->optionname['options'], false );
		$this->tables = get_option( $this->optionname['tables'], false );

		if ( false === $this->options || false === $this->tables )
            return '';

		// front-end function, shortcode for the_content, manual filter for widget_text
		add_shortcode( $this->shortcode, array( &$this, 'handle_content_shortcode' ) );
        add_filter('widget_text', array( &$this, 'handle_widget_filter' ) );

        // if tablesorter enabled (globally) include javascript
		if ( true == $this->options['enable_tablesorter'] )
    		$this->add_head_tablesorter_js();

        // if global css shall be used
		if ( true == $this->options['use_global_css'] )
    		$this->add_head_global_css();
    }

    // ###################################################################################################################
    // handle [table id=<the_table_id> /] in the_content()
    function handle_content_shortcode( $attr ) {
        $table_id = $attr['id'];

        if ( !is_numeric( $table_id ) || 1 > $table_id || false == $this->is_table( $table_id ) )
            return "[table \"{$table_id}\" not found /]<br />\n";

        $table = $this->load_table( $table_id );

        $output = $this->render_table( $table );

        return $output;
    }
    
    // ###################################################################################################################
    // handle [table id=<the_table_id> /] in widget texts
    function handle_widget_filter( $text ) {
        // pattern to search for in widget text (only our plugin's shortcode!)
        $pattern = '\[(' . preg_quote( $this->shortcode ) . ')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\1\])?';
        // search for it, if found, handle as if it were a shortcode
        return preg_replace_callback( '/'.$pattern.'/s', 'do_shortcode_tag', $text );
    }

    // ###################################################################################################################
    function is_table( $table_id ) {
        return isset( $this->tables[ $table_id ] );
    }

    // ###################################################################################################################
    function load_table( $table_id ) {
        $this->tables[ $table_id ] = ( isset( $this->tables[ $table_id ] ) ) ? $this->tables[ $table_id ] : $this->optionname['table'] . '_' . $table_id;
        $table = get_option( $this->tables[ $table_id ], array() );
        return $table;
    }

    // ###################################################################################################################
    // echo content of array
    function render_table( $table ) {
        // classes that will be added to <table class=...>, can be used for css-styling
        $cssclasses = array( 'wp-table-reloaded', "wp-table-reloaded-id-{$table['id']}" );
        $cssclasses = implode( ' ', $cssclasses );

        $rows = count( $table['data'] );
        $cols = (0 < $rows) ? count( $table['data'][0] ) : 0;

        $output = '';

        if ( 0 < $rows && 0 < $cols) {
        
            if ( true == $table['options']['print_name'] )
                $output .= '<h2 class="wp-table-reloaded-table-name">' . $this->safe_output( $table['name'] ) . "</h2>\n";
        
            $output .= "<table class=\"{$cssclasses}\" cellspacing=\"1\" cellpadding=\"0\" border=\"0\">\n";

            foreach( $table['data'] as $row_idx => $row ) {
                if ( true == $table['options']['alternating_row_colors'] )
                    $row_class = ( 1 == ($row_idx % 2) ) ? ' class="even"' : ' class="odd"';
                if( 0 == $row_idx ) {
                    if ( true == $table['options']['first_row_th'] ) {
                        $output .= "<thead>\n";
                        $output .= "\t<tr{$row_class}>\n\t\t";
                        foreach( $row as $col_idx => $cell_content ) {
                            $cell_content = $this->safe_output( $cell_content );
                            $output .= "<th>" . "{$cell_content}" . "</th>";
                        }
                        $output .= "\n\t</tr>\n";
                        $output .= "</thead>\n";
                        $output .= "<tbody>\n";
                    } else {
                        $output .= "<tbody>\n";
                        $output .= "\t<tr{$row_class}>\n\t\t";
                        foreach( $row as $col_idx => $cell_content ) {
                            $cell_content = $this->safe_output( $cell_content );
                            $output .= "<td>" . "{$cell_content}" . "</td>";
                        }
                        $output .= "\n\t</tr>\n";
                    }
                } else {
                    $output .= "\t<tr{$row_class}>\n\t\t";
                    foreach( $row as $col_idx => $cell_content ) {
                        $cell_content = $this->safe_output( $cell_content );
                        $output .= "<td>" . "{$cell_content}" . "</td>";
                    }
                    $output .= "\n\t</tr>\n";
                }
            }
            $output .= "</tbody>\n";
            $output .= "</table>\n";

            if ( true == $table['options']['print_description'] )
                $output .= '<span class="wp-table-reloaded-table-description">' . $this->safe_output( $table['description'] ) . "</span>\n";

            $widgets = ( true == $table['options']['alternating_row_colors'] ) ? "{widgets: ['zebra']}" : '';
            if ( true == $table['options']['use_tablesorter'] ) {
                $output .= <<<JSSCRIPT
<script type="text/javascript">
jQuery(document).ready(function($){
    $(".wp-table-reloaded-id-{$table['id']}").tablesorter({$widgets});
});
</script>
JSSCRIPT;
            }
        }
        return $output;
    }

    // ###################################################################################################################
    function safe_output( $string ) {
        return stripslashes( $string );
    }
    
    // ###################################################################################################################
    // enqueue tablesorter-js-file, if it exists
    function add_head_tablesorter_js() {
        $jsfile =  'jquery.tablesorter.min.js';
        if ( file_exists( dirname ( __FILE__ ) . '/js/' . $jsfile ) ) {
            wp_enqueue_script( 'wp-table-reloaded-tablesorter-js', WP_PLUGIN_URL . '/' . basename( dirname( __FILE__ ) ) . '/js/' . $jsfile, array( 'jquery' ) );
        }
    }
    // ###################################################################################################################
    // enqueue tablesorter-css-file, if it exists, may be modified by user
    function add_head_global_css() {
        $cssfile =  'global-frontend-style.css';
        if ( file_exists( dirname ( __FILE__ ) . '/css/' . $cssfile ) ) {
            wp_enqueue_style( 'wp-table-reloaded-global-css', WP_PLUGIN_URL . '/' . basename( dirname( __FILE__ ) ) . '/css/' . $cssfile );
            // WP < 2.7 does not contain call to add_action( 'wp_head', 'wp_print_styles' ) in default-filters.php (Core Trac Ticket #7720)
            if ( false == has_action( 'wp_head', 'wp_print_styles' ) )
                add_action( 'wp_head', array( &$this, 'print_style' ) );
        }
    }

    // ###################################################################################################################
    // print our style in wp-head (only done in WP < 2.7)
    function print_style() {
        wp_print_styles( 'wp-table-reloaded-global-css' );
    }

} // class WP_Table_Reloaded_Frontend

?>