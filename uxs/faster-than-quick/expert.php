<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

include("ux.php");
?>

<h5 class="text-center">Expert zone</h5>
<hr>

<div class="accordion" id="accordion_expert">
 <div class="accordion-item">
  <h2 class="accordion-header" id="heading_download">
   <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_download" aria-expanded="true" aria-controls="collapse_download">
    Download files
   </button>
  </h2>
  <div id="collapse_download" class="accordion-collapse collapse show" aria-labelledby="heading_download" data-bs-parent="#accordion_expert">
   <div class="accordion-body">
    TODO: mesh

    TOD: vtk
   </div>
  </div>
 </div>
 <div class="accordion-item">
  <h2 class="accordion-header" id="heading_cache">
   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_cache" aria-expanded="false" aria-controls="collapse_cache">
    Cache management
   </button>
  </h2>
  <div id="collapse_cache" class="accordion-collapse collapse" aria-labelledby="heading_cache" data-bs-parent="#accordion_expert">
   <div class="accordion-body">
    TODO: show usage

    TODO: clear
   </div>
  </div>
 </div>
 <div class="accordion-item">
  <h2 class="accordion-header" id="heading_input">
   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_input" aria-expanded="false" aria-controls="collapse_input">
    Mesher &amp; solver inputs
   </button>
  </h2>
  <div id="collapse_input" class="accordion-collapse collapse" aria-labelledby="heading_input" data-bs-parent="#accordion_expert">
   <div class="accordion-body">
<!--   
    <div class="row m-1 p-1">
     <div class="col-10">
      <button class="btn btn-lg btn-info w-100" onclick="edit_yaml()">Metadata</button>
     </div>
     <div class="col-2">
      ?
     </div>
    </div> 
-->

    <div class="row m-1 p-1">
     <div class="col-10">
      <button class="btn btn-outline-secondary w-100" onclick="geo_show()">Show &amp; edit mesher input</button>
     </div>
     <div class="col-2">
      <a href="#"><i class="bi bi-question-circle text-secondary"></i></a>
     </div> 
    </div>
    
    <div class="row m-1 p-1">
     <div class="col-10">
      <button class="btn btn-outline-primary w-100" onclick="fee_show()">Show &amp; edit solver input</button>
     </div>
     <div class="col-2">
      <a href="#"><i class="bi bi-question-circle text-primary"></i></a>
     </div> 
    </div>
    
   </div> 
  </div>
 </div>
</div>

