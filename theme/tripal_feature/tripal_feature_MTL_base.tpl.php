<?php
// The marker link is for GDR only
$marker_link = "/node/";

$feature  = $variables['node']->feature;
$feature = tripal_core_expand_chado_vars($feature,'table','featureprop');

// Process featureprop (i.e. Triait Symbol / Comments
$properties = $feature->featureprop;
if (!$properties) {
    $properties = array();
} elseif (!is_array($properties)) {
    $properties = array($properties);
}
$symbol = "N/A";
$comments = "N/A";
foreach ($properties AS $prop) {
    if ($prop->type_id->name == 'published_symbol') {
        $symbol = $prop->value;
    } else if ($prop->type_id->cv_id->name == 'MAIN' && $prop->type_id->name == 'comments') {
        $comments = $prop->value;
    }
}

// Generate MTL details
$mtl_details = getQTLDetails($feature->feature_id);

// Synonyms
$synonyms = "N/A";
if ($mtl_details->synonyms) {
    $synonyms = "";
    foreach ($mtl_details->synonyms as $syn) {
        $synonyms .= $syn->name . ". ";
    }
}

// Population
$population = "N/A";
if ($mtl_details->population->pop_nid) {
    $population = "<a href=\"/node/" . $mtl_details->population->pop_nid . "\">". $mtl_details->population->uniquename . "</a>";
} else if ($mtl_details->population->uniquename) {
    $population = $mtl_details->population->uniquename;
}

// Female Parent
$fparent = "N/A";
if ($mtl_details->population->m_nid) {
    $fparent = "<a href=\"/node/" . $mtl_details->population->m_nid . "\">". $mtl_details->population->maternal . "</a>";
} else if ($mtl_details->population->maternal) {
    $fparent = $mtl_details->population->maternal;
}

// Male Parent
$mparent = "N/A";
if ($mtl_details->population->p_nid) {
    $mparent = "<a href=\"/node/" . $mtl_details->population->p_nid . "\">". $mtl_details->population->paternal . "</a>";
} else if ($mtl_details->population->paternal) {
    $mparent = $mtl_details->population->paternal;
}

// Colocalizing Markers
$colocM = "N/A";
if (count($mtl_details->colocalizing_marker) != 0) {
    $colocM = "";
}
foreach($mtl_details->colocalizing_marker as $marker) {
    $colocM .= "<a href=\"$marker_link$marker->coloc_marker_nid\">" . $marker->colocalizing_marker . "</a><br>";
}

// Neighboring Marks
$neighborM = "N/A";
if (count($mtl_details->neighboring_marker) != 0) {
    $neighborM = "";
}
foreach($mtl_details->neighboring_marker as $marker) {
    $neighborM .= "<a href=\"$marker_link$marker->neighboring_marker_nid\">" . $marker->neighboring_marker . "</a><br>";
}

?>
<div id="tripal_feature-base-box" class="tripal_feature-info-box tripal-info-box">
  <div class="tripal_feature-info-box-title tripal-info-box-title"> Mendelian Trait Locus (MTL) Details</div>
  <div class="tripal_feature-info-box-desc tripal-info-box-desc"></div>

   <?php if($feature->is_obsolete =='t') { ?>
      <div class="tripal_feature-obsolete">This feature is obsolete</div>
   <?php }?>
   <table id="tripal_feature-base-table" class="tripal_feature-table tripal-table tripal-table-vert">
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th width="45%">MTL Label</th>
        <td><?php print $feature->uniquename; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th nowrap>Published Symbol</th>
        <td><?php print $symbol; ?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th>Trait Name</th>
        <td><?php print $feature->name; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th>Trait Alias</th>
        <td><?php print $synonyms; ?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th>Population</th>
        <td><?php print $population; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th nowrap>Female Parent</th>
        <td><?php print $fparent; ?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th>Male Parent</th>
        <td><?php print $mparent; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th nowrap>Colocalizing Marker</th>
        <td><?php print $colocM; ?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th>Neighboring Marker</th>
        <td><?php print $neighborM; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th>Comments</th>
        <td><?php print $comments; ?></td>
      </tr>
   </table>
</div>
