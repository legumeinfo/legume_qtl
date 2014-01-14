<?php
$pubs = $mtl_details->publications;

if (count($pubs) > 0) { ?>
  <div id="tripal_feature-pub-box" class="tripal_feature-info-box tripal-info-box">
    <div class="tripal_feature-info-box-title tripal-info-box-title">Publications</div>
    <div class="tripal_feature-info-box-desc tripal-info-box-desc"></div>

    <table id="tripal_feature-pub-table" class="tripal_feature-table tripal-table tripal-table-vert" style="border-bottom:solid 2px #999999">
      <tr style="background-color:#EEEEFF;border-top:solid 2px #999999">
        <th style="width:80px;padding:5px 10px 5px 10px;">Year</th>
        <th>Reference</th><th style="padding-left:0px;">Title</th>
      </tr><?php
      $counter = 0;
      $class = "";

      foreach ($pubs AS $pub) {
        if ($counter % 2 == 1) {
          $class = "tripal_featuremap-table-even-row tripal-table-even-row";
        } 
        else {
          $class = "tripal_featuremap-table-odd-row tripal-table-odd-row";
        }
        print "<tr class=\"" . $class ."\">";
        print "<td style=\"padding:5px 10px 5px 10px;\">". $pub->pyear . "</td><td><a href=\"/node/$pub->nid\">$pub->uniquename</a></td><td style=\"padding:5px 0px 5px 0px;\"><a id=\"gdr_publication_link\" href=\"$pub_link$pub->pub_id\" target=\"_blank\">" . $pub->title . "</a></td></tr>";
        $counter ++;
      }?>
    </table>
  </div> <?php 
} 