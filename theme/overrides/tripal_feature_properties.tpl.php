<?php
$feature = $variables['node']->feature;

// eksc hack
if (strcmp($feature->type_id->name, 'QTL') == 0 ) {
  include_once('sites/all/modules/legume/legume_qtl/theme/templates/tripal_feature_QTL_details.tpl.php');
}
else {
  include_once('sites/all/modules/tripal/tripal_feature/theme/templates/tripal_feature_properties.tpl.php');
}
