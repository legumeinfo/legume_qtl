<?php
$map_positions = $mtl_details->map_positions;
$counter_pos = count($map_positions);
 ?>
 
<?php 
// Load the table pager javascript code as we'll need it after the allele table is created.
drupal_add_js(drupal_get_path('theme', 'ljpeach') . "/js/mainlab_table_pager.js");
function MTLGetTableRowClass($c) {
    if ($c % 2 == 1) {
        $class = "tripal_feature-table-even-row tripal-table-even-row";
    } else {
        $class = "tripal_feature-table-odd-row tripal-table-odd-row";
    }
    return $class;
}
?>

<?php if ($counter_pos > 0) { ?>
    <div id="tripal_feature-MTL_map_positions-box" class="tripal_feature-info-box tripal-info-box">
    <div class="tripal_feature-info-box-title tripal-info-box-title">Map Positions</div>

      <script type="text/javascript">
         // Insert Marker position count to the base template
         $('#tripal-feature-MTL-map_position').html("[<a href='#' id='tripal-feature-MTL-map_position-link'>view all <?php print $counter_pos;?></a>]");
         $('#tripal-feature-MTL-map_position-link').click(function() {
             $('.tripal-info-box').hide();
             $('#tripal_feature-MTL_map_positions-box').fadeIn('slow');
             $('#tripal_feature_toc').height($('#tripal_feature-MTL_map_positions-box').parent().height());
         })
      </script>
      
       <!-- Map positions -->
        <?php 
          $counter_pos = count($map_positions);
          if ($counter_pos > 0) {
            print "Total $counter_pos map position";
            print "<div id=\"cottongen-MTL-mappositions\">
                        <table id=\"cottongen-MTL-mappositions-table\"class=\"tripal_feature-table tripal-table tripal-table-horz\" style=\"margin-top:15px;margin-bottom:15px;border-bottom:2px solid #999999;;border-top:2px solid #999999\">
                            <tr><th style=\"width:20px;\">#</th><th>Map Name</th><th>Linkage Group</th><th>Bin</th><th>Chromosome</th><th>Position</th></tr>";
            $counter = 1;

            foreach($map_positions AS $pos) {
               // If the value doesn't exist, change it to 'N/A'
               $mapnid = $pos->nid;
               if (!$mapnid) { $map = "$pos->name";} else { $map = "<a href=\"/node/$pos->nid\">$pos->name</a>";}
               $lg = $pos->linkage_group;
               if (!$lg) {$lg = "N/A";}
               $bin = $pos->bin;
               if (!$bin) {$bin = "N/A";}
               $chr = $pos->chr;
               if (!$chr) {$chr = "N/A";}
               $start = number_format($pos->qtl_start, 1);
               if ($start == 0) {$start = "N/A";}
               $class = MTLGetTableRowClass($counter);
                print "<tr class=\"$class\">
                              <td>$counter</td>
                              <td>$map</td>
                              <td>$lg</td>
                              <td>$bin</td>
                              <td>$chr</td>
                              <td>$start</td>
                           </tr>";
                $counter ++;
          }
            print "  </table>
                       </div>";
        }
        ?>
     </div>
    <?php } ?>
    
<script type="text/javascript">
// Create a pager for the marker position
tripal_table_make_pager ('cottongen-MTL-mappositions-table', 0, 15);
// Adjust hieght of two columns whenever the page changes
$('#cottongen-MTL-mappositions-table-pager').click(function () {
  $("#tripal_feature_toc").height($("#tripal_feature-MTL_map_positions-box").parent().height());
});
</script>
