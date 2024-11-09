<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

include("ux.php");

// TODO: move into a common
if (($cad_json = file_get_contents("{$cad_dir}/cad.json")) == false) {
  return_error("cannot find cad {$case["cad"]}");
}

if (($cad = json_decode($cad_json, true)) == null) {
  return_error("cannot decode cad {$id}");
}
?>


<h5 class="text-center">Meshing progress</h5>
<hr>

<div class="accordion" id="accordion_mesh">

 <div class="accordion-item">
  <h2 class="accordion-header" id="heading_meshingstatus">
   <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_meshingstatus" aria-expanded="true" aria-controls="collapse_meshingstatus">
   Status
   </button>
  </h2>
  <div id="collapse_meshingstatus" class="accordion-collapse collapse show" aria-labelledby="heading_meshingstatus" data-bs-parent="#accordion_mesh">
   <div class="accordion-body">
   
<!--  TODO: the php in charge of informing the progress should also send the legends  -->

    <legend>1D :&nbsp;: <span id="mesh_status_edges">0</span>/<?=$cad["edges"]?>&nbsp;edges</legend>
    <div class="progress mt-2 mb-4" role="progressbar">
     <div class="progress-bar bg-info" style="width=0%" id="progress_edges"></div>
    </div>

    <legend>2D :&nbsp;: <span id="mesh_status_faces">0</span>/<?=$cad["faces"]?>&nbsp;faces</legend>
    <div class="progress mt-2 mb-4" role="progressbar">
     <div class="progress-bar bg-info" style="width=0%" id="progress_faces"></div>
    </div>
    
    <legend>3D :&nbsp;: <span id="mesh_status_volumes">0</span>/<?=$cad["solids"]?>&nbsp;volumes</legend>
    <div class="progress mt-2 mb-4" role="progressbar">
     <div class="progress-bar bg-info" style="width=0%" id="progress_volumes"></div>
    </div>

    <legend>Processing</legend>
    <div class="progress mt-2 mb-4" role="progressbar">
     <div class="progress-bar bg-info" style="width=0%" id="progress_data"></div>
    </div>
    
    <div class="col-12 my-4">
     <div class="d-flex justify-content-center">
      <div class="spinner-border text-primary" role="status">
       <span class="visually-hidden">Meshing...</span>
      </div>
     </div> 
    </div>
  
    <div class="col-12 mt-3 py-2">
     <div class="alert alert-light w-100 text-small m-0 p-0">
<pre id="mesh_log" class="small m-0 p-0">





</pre>
     </div>
     
     <button class="btn btn-lg btn-outline-danger w-100 mt-4" onclick="cancel_meshing('<?=$mesh_hash?>')">
      <i class="bi bi-ban me-2"></i>&nbsp;Cancel meshing
     </button>
     
    </div>
  
   </div>
  </div>
 </div>

<img src onerror="update_mesh_status('<?=$mesh_hash?>')"> 
 
</div>
