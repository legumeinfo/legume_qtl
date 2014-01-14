<?php
// $Id: views-view-table.tpl.php,v 1.8 2009/01/28 00:43:43 merlinofchaos Exp $
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * @ingroup views_templates
 */
?>

<?php 
   $total = $view->total_rows;
   $query = $view->build_info['query'];
   $download_form = $view->attachment_after;
   $download_form = "<div id=\"views-qtl_search-download-box\" style=\"position:absolute;margin-left:260px;margin-top:10px;padding:25px;border:1px solid #CCCCCC;background:white;z-order:-10;display:none;\">". $download_form ."<div onClick=\"this.parentNode.style.display='none'\" style=\";text-align:right\"><a href=\"#\" onClick=\"return false;\">[Close]</a></div></div>";
   $view->attachment_after = "<div style=\"margin:20px 20px 20px 20px;\" onClick=\"$('#views-qtl_search-exposed-widgets-fieldset').removeClass('collapsed');\"><p><a href=\"#search-form-top\">Return to search criteria at top of page</a></p></div>";
   unset($view->feed_icon);
?>

<a id="search-results-top"></a>
<script type="text/javascript">
   /* make the search form collapsed */
   $("#views-qtl_search-exposed-widgets-fieldset").addClass('collapsible');
   $("#views-qtl_search-exposed-widgets-fieldset").addClass('collapsed');
</script>

<div id=views-qtl_search-results style="margin:0px 20px 20px 20px; background: #FFFFFF; border: 1px solid #CCCCCC;padding:20px 30px 30px 30px;overflow:auto;">
   <div id=views-qtl_search-header>
      <p style="margin-top: 0px">
         <a style="float:right;text-align:right;vertical-align:text-top;" onClick="document.getElementById('views-qtl_search-download-box').style.display='block'">Download the results</a>
         <?php if($total == 1){ 
           print '<b>1</b> record was found.';
         } else {
           print '<b>'.number_format($total).'</b> records were found.';
         }?>
      </p>
      <?php print $download_form; ?>
   </div>
<div id=views-qtl_search-table-view>

<table class="views-qtl_search-table <?php print $class; ?> tripal-table-vert" style="border: 1px solid #DDDDDD;" width="100%">
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <thead>
    <tr class="views-qtl_search-table-header tripal-table-header">
      <?php foreach ($header as $field => $label): ?>
        <th class="views-field views-field-<?php print $fields[$field]; ?>" style="padding:5px 10px 5px 10px;background: #DDDDDD">
          <?php print $label; ?>
        </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $count => $row): 
    			$rowclass = "";
    			$no_row ++;
    			if ($count % 2 != 0) {
    				$rowclass = "views-qtl_search-table-even-row tripal-table-even-row";
    			} else {
    				$rowclass = "views-qtl_search-table-odd-row tripal-table-odd-row";
    			}
    ?>
      <tr class="<?php print $rowclass?> <?php print implode(' ', $row_classes[$count]); ?>">
        <?php foreach ($row as $field => $value): 
        ?>
          <td class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php print $value; ?>
          </td>
        <?php           
        endforeach; 
        ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>
