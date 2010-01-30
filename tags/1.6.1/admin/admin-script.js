jQuery(document).ready(function(d){d("#a-hide-rows").click(function(){var m=d('#table_contents tr:not(".table-foot") :checked').length;if(m==0){alert(WP_Table_Reloaded_Admin.str_UnHideRowsNoSelection)}else{d('#table_contents tr:not(".table-foot") :checked').removeAttr("checked").next().val(true).parents("tr").addClass("row-hidden");e()}return false});d("#a-unhide-rows").click(function(){var m=d('#table_contents tr:not(".table-foot") :checked').length;if(m==0){alert(WP_Table_Reloaded_Admin.str_UnHideRowsNoSelection)}else{d('#table_contents tr:not(".table-foot") :checked').removeAttr("checked").next().val(false).parents("tr").removeClass("row-hidden");e()}return false});d("#a-hide-columns").click(function(){var m=d("#table_contents .table-foot :checked").length;if(m==0){alert(WP_Table_Reloaded_Admin.str_UnHideColsNoSelection)}else{d("#table_contents .table-foot :checked").removeAttr("checked").next().val(true).each(function(){d("#table_contents ."+d(this).attr("id")).addClass("column-hidden")});e()}return false});d("#a-unhide-columns").click(function(){var m=d("#table_contents .table-foot :checked").length;if(m==0){alert(WP_Table_Reloaded_Admin.str_UnHideColsNoSelection)}else{d("#table_contents .table-foot :checked").removeAttr("checked").next().val(false).each(function(){d("#table_contents ."+d(this).attr("id")).removeClass("column-hidden")});e()}return false});d("#button-insert-rows").click(function(){var m=d('#table_contents tr:not(".table-foot") :checked').length;if(m==0){alert(WP_Table_Reloaded_Admin.str_InsertRowsNoSelection);return false}else{return true}});d("#button-insert-columns").click(function(){var m=d("#table_contents .table-foot :checked").length;if(m==0){alert(WP_Table_Reloaded_Admin.str_InsertColsNoSelection);return false}else{return true}});var c="";function a(){d(this).val(c);d("#table_contents textarea").unbind("click",a);e()}d("#a-add-colspan").click(function(){c="#colspan#";if(confirm(WP_Table_Reloaded_Admin.str_DataManipulationAddColspan)){d("#table_contents textarea").bind("click",a)}return false});d("#a-add-rowspan").click(function(){c="#rowspan#";if(confirm(WP_Table_Reloaded_Admin.str_DataManipulationAddRowspan)){d("#table_contents textarea").bind("click",a)}return false});var g=null;if(WP_Table_Reloaded_Admin.option_growing_textareas){d("#table_contents textarea").focus(function(){d(g).removeClass("focus");g=d(this).parents("tr").find("textarea");d(g).addClass("focus")})}function i(){d("#options_custom_css").addClass("focus")}d("#options_custom_css").one("focus",i);d("#export_format").change(function(){if("csv"==d(this).val()){d(".tr-export-delimiter").show()}else{d(".tr-export-delimiter").hide()}}).change();var j=d(".wp-table-reloaded-table-information #table_id").val();d(".wp-table-reloaded-table-information #table_id").change(function(){if(j!=d(this).val()){if(confirm(WP_Table_Reloaded_Admin.str_ChangeTableID)){j=d(this).val();e()}else{d(this).val(j)}}});d(".tr-import-addreplace input").click(function(){if("replace"==d(".tr-import-addreplace input:checked").val()){d(".tr-import-addreplace-table").show()}else{d(".tr-import-addreplace-table").hide()}});d(".tr-import-addreplace input:checked").click();d(".tr-import-from input").click(function(){d(".tr-import-file-upload, .tr-import-url, .tr-import-form-field, .tr-import-server").hide();d(".tr-import-"+d(".tr-import-from input:checked").val()).show()});d(".tr-import-from input:checked").click();d("#options_use_custom_css").change(function(){if(d(this).attr("checked")){d("#options_custom_css").removeAttr("disabled")}else{d("#options_custom_css").attr("disabled","disabled")}});d("#options_enable_tablesorter").change(function(){if(d(this).attr("checked")){d("#options_tablesorter_script").removeAttr("disabled")}else{d("#options_tablesorter_script").attr("disabled","disabled")}});if(WP_Table_Reloaded_Admin.option_tablesorter_enabled&&WP_Table_Reloaded_Admin.option_datatables_active){d("#table_options_first_row_th").change(function(){if(d(this).attr("checked")){d("#table_options_use_tablesorter").removeAttr("disabled");if(d("#table_options_use_tablesorter").attr("checked")){d(".wp-table-reloaded-datatables-options input").removeAttr("disabled");if(!WP_Table_Reloaded_Admin.option_tabletools_active){d("#table_options_datatables_tabletools").attr("disabled","disabled")}}}else{d("#table_options_use_tablesorter").attr("disabled","disabled");d(".wp-table-reloaded-datatables-options input").attr("disabled","disabled")}});d("#table_options_use_tablesorter").change(function(){if(d(this).attr("checked")){d(".wp-table-reloaded-datatables-options input").removeAttr("disabled");if(!WP_Table_Reloaded_Admin.option_tabletools_active){d("#table_options_datatables_tabletools").attr("disabled","disabled")}}else{d(".wp-table-reloaded-datatables-options input").attr("disabled","disabled")}})}else{if(WP_Table_Reloaded_Admin.option_tablesorter_enabled){d("#table_options_first_row_th").change(function(){if(d(this).attr("checked")){d("#table_options_use_tablesorter").removeAttr("disabled")}else{d("#table_options_use_tablesorter").attr("disabled","disabled")}})}}d("#table_options_print_name").change(function(){if(d(this).attr("checked")){d("#table_options_print_name_position").removeAttr("disabled")}else{d("#table_options_print_name_position").attr("disabled","disabled")}});d("#table_options_print_description").change(function(){if(d(this).attr("checked")){d("#table_options_print_description_position").removeAttr("disabled")}else{d("#table_options_print_description_position").attr("disabled","disabled")}});d("#options_uninstall_upon_deactivation").click(function(){if(d(this).attr("checked")){return confirm(WP_Table_Reloaded_Admin.str_UninstallCheckboxActivation)}});var k="";function f(){d(this).val(d(this).val()+k);d("#table_contents textarea").unbind("click",f);e()}d("#a-insert-link").click(function(){var o="";if(WP_Table_Reloaded_Admin.option_add_target_blank_to_links){o=' target="_blank"'}var n=prompt(WP_Table_Reloaded_Admin.str_DataManipulationLinkInsertURL+":","http://");if(n){var m=prompt(WP_Table_Reloaded_Admin.str_DataManipulationLinkInsertText+":",WP_Table_Reloaded_Admin.str_DataManipulationLinkInsertText);if(m){k='<a href="'+n+'"'+o+">"+m+"</a>";k=prompt(WP_Table_Reloaded_Admin.str_DataManipulationLinkInsertExplain,k);if(k){d("#table_contents textarea").bind("click",f)}}}return false});function b(){edCanvas=this;d("#table_contents textarea").unbind("click",b);var m=d("#a-insert-image");tb_show(m.attr("title"),m.attr("href"),m.attr("rel"));tb_my_position();d(this).blur();e()}function h(){if(confirm(WP_Table_Reloaded_Admin.str_DataManipulationImageInsertThickbox)){d("#table_contents textarea").bind("click",b)}return false}d("#a-insert-image").bind("click",h);d("#insert_custom_field_name").keyup(function(){d(this).val(d(this).val().toLowerCase().replace(/[^a-z0-9_-]/g,""))});d(".focus-blur-change").focus(function(){if(d(this).attr("title")==d(this).val()){d(this).val("")}}).blur(function(){if(""==d(this).val()){d(this).val(d(this).attr("title"))}});d("#table_custom_fields textarea").focus(function(){d("#table_custom_fields .focus").removeClass("focus");d(this).addClass("focus")});d("input.bulk_copy_tables").click(function(){return confirm(WP_Table_Reloaded_Admin.str_BulkCopyTablesLink)});d("input.bulk_delete_tables").click(function(){return confirm(WP_Table_Reloaded_Admin.str_BulkDeleteTablesLink)});d("input.bulk_wp_table_import_tables").click(function(){return confirm(WP_Table_Reloaded_Admin.str_BulkImportwpTableTablesLink)});d("a.copy_table_link").click(function(){return confirm(WP_Table_Reloaded_Admin.str_CopyTableLink)});d("#button-delete-rows").click(function(){var n=d('#table_contents tr:not(".table-foot") :checkbox').length-1;var m=d('#table_contents tr:not(".table-foot") :checked').length;if(m==0){alert(WP_Table_Reloaded_Admin.str_DeleteRowsFailedNoSelection);return false}else{if(n==m){alert(WP_Table_Reloaded_Admin.str_DeleteRowsFailedNotAll);return false}else{return confirm(WP_Table_Reloaded_Admin.str_DeleteRowsConfirm)}}});d("#button-delete-columns").click(function(){var m=d("#table_contents .table-foot :checkbox").length;var n=d("#table_contents .table-foot :checked").length;if(n==0){alert(WP_Table_Reloaded_Admin.str_DeleteColsFailedNoSelection);return false}else{if(m==n){alert(WP_Table_Reloaded_Admin.str_DeleteColsFailedNotAll);return false}else{return confirm(WP_Table_Reloaded_Admin.str_DeleteColsConfirm)}}});d("a.import_wptable_link").click(function(){return confirm(WP_Table_Reloaded_Admin.str_ImportwpTableLink)});d("#import_wp_table_reloaded_dump_file").click(function(){return confirm(WP_Table_Reloaded_Admin.str_ImportDumpFile)});d("#uninstall_plugin_link").click(function(){if(confirm(WP_Table_Reloaded_Admin.str_UninstallPluginLink_1)){return confirm(WP_Table_Reloaded_Admin.str_UninstallPluginLink_2)}else{return false}});d("a.cf_shortcode_link").click(function(){var m=prompt(WP_Table_Reloaded_Admin.str_CFShortcodeMessage,d(this).attr("title"));return false});d("a.table_shortcode_link").click(function(){var m=prompt(WP_Table_Reloaded_Admin.str_TableShortcodeMessage,d(this).attr("title"));return false});d(".postbox h3, .postbox .handlediv").click(function(){d(d(this).parent().get(0)).toggleClass("closed")});var l=false;function e(){l=true;d("#wp_table_reloaded_edit_table").find("#table_name, textarea").unbind("change",e);d("#wp_table_reloaded_edit_table .wp-table-reloaded-options input, #wp_table_reloaded_edit_table .wp-table-reloaded-options select").unbind("change",e)}if(WP_Table_Reloaded_Admin.option_show_exit_warning){window.onbeforeunload=function(){if(l){return WP_Table_Reloaded_Admin.str_saveAlert}};d("#wp_table_reloaded_edit_table input[name='submit[update]'], #wp_table_reloaded_edit_table input[name='submit[save_back]']").click(function(){d("#wp_table_reloaded_edit_table .wp-table-reloaded-options input, #wp_table_reloaded_edit_table .wp-table-reloaded-options select").removeAttr("disabled");window.onbeforeunload=null});d("#wp_table_reloaded_edit_table").find("#table_name, textarea").bind("change",e);d("#wp_table_reloaded_edit_table .wp-table-reloaded-options input, #wp_table_reloaded_edit_table .wp-table-reloaded-options select").bind("change",e)}tb_init("a.help-link");tb_init("a.preview-link");tb_my_position()});function send_to_editor(a){jQuery(edCanvas).val(jQuery(edCanvas).val()+a);tb_remove()}var tb_my_position;(function(a){tb_my_position=function(){var e=a("#TB_window"),d=a(window).width(),c=a(window).height(),b=(720<d)?720:d;if(e.size()){e.width(b-50).height(c-45);a("#TB_iframeContent").width(b-50).height(c-75);e.css({"margin-left":"-"+parseInt(((b-50)/2),10)+"px"});if(typeof document.body.style.maxWidth!="undefined"){e.css({top:"20px","margin-top":"0"})}}return a("a.preview-link").each(function(){var f=a(this).attr("href");if(!f){return}f=f.replace(/&width=[0-9]+/g,"");f=f.replace(/&height=[0-9]+/g,"");a(this).attr("href",f+"&width="+(b-80)+"&height="+(c-85))})};a(window).resize(function(){tb_my_position()})})(jQuery);