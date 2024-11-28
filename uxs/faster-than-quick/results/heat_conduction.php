<?php
// $warp_max = 0;
if (file_exists("{$case_dir}/run/{$problem_hash}-max.json")) {
  $max_json = json_decode(file_get_contents("{$case_dir}/run/{$problem_hash}-max.json"), true);
  $T_max = $max_json["max"];
  $T_min = $max_json["min"];
}
  
row_set_width(7);
row_ro_units("Max. temp. ".$label["maxT"], number_format($T_max, 1), $label["K"]);
row_ro_units("Min. temp. ".$label["minT"], number_format($T_min, 1), $label["K"]);
?>
