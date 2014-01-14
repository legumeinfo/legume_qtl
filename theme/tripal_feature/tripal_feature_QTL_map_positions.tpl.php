<?php

$feature = $variables['node']->feature;
$map_positions = $feature->mainlab_qtl->map_positions;

$counter_pos = count($map_positions);

if ($counter_pos > 0) { ?>
  <div id="tripal_feature-QTL_map_positions-box" class="tripal_feature-info-box tripal-info-box">
  <div class="tripal_feature-info-box-title tripal-info-box-title">Map Positions</div> <?php 
  $counter_pos = count($map_positions);
  if ($counter_pos > 0) { ?>
    Total <?php print $counter_pos ?> map position
    <div id="cottongen-QTL-mappositions">
      <table id="cottongen-QTL-mappositions-table" class="tripal_feature-table tripal-table tripal-table-horz" style="margin-top:15px;margin-bottom:15px;border-bottom:2px solid #999999;;border-top:2px solid #999999">
        <tr>
          <th style="width:20px;">#</th>
          <th>Map Name</th>
          <th>Linkage Group</th>
          <th>Bin</th>
          <th>Chromosome</th>
          <th>Peak</th>
          <th>Span Start</th>
          <th>Span Stop</th>
        </tr> <?php
        $counter = 1;
        foreach($map_positions AS $pos) {
          // If the value doesn't exist, change it to 'N/A'
          $mapnid = $pos->nid;
          if (!$mapnid) { 
            $map = "$pos->name";
          } 
          else { 
            $map = "<a href=\"/node/$pos->nid\">$pos->name</a>";
          }
          $lg = $pos->linkage_group;
          if (!$lg) {
            $lg = "N/A";
          }
          $bin = $pos->bin;
          if (!$bin) {
            $bin = "N/A";
          }
          $chr = $pos->chr;
          if (!$chr) {
            $chr = "N/A";
          }
          $start =  number_format($pos->qtl_start, 1);
          if ($start == 0) {
            $start = "N/A";
          }
          $stop =  number_format($pos->qtl_stop, 1);
          if ($stop == 0) {
            $stop = "N/A";
          }
          $peak = number_format($pos->qtl_peak, 1);
          if ($peak == 0) {
            $peak = "N/A";
          }
          if ($counter % 2 == 1) {
            $class = "tripal_feature-table-even-row tripal-table-even-row";
          } 
          else {
            $class = "tripal_feature-table-odd-row tripal-table-odd-row";
          } ?>
          <tr class="$class">
            <td><?php print $counter ?></td>
            <td><?php print $map ?></td>
            <td><?php print $lg ?></td>
            <td><?php print $bin ?></td>
            <td><?php print $chr ?></td>
            <td><?php print $peak ?></td>
            <td><?php print $start ?></td>
            <td><?php print $stop ?></td>
          </tr><?php
          $counter ++;
        } ?>
      </table>
    </div> <?php
  } ?>
  </div> <?php 
} ?>
