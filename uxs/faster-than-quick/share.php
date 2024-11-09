<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

include("../conf.php");
include("../auths/{$auth}/auth.php");
include("common.php");
include("case.php");
include("ux.php");
?>

<h5 class="text-center">Share case</h5>
<hr>

<div class="accordion" id="accordion_expert">
 <div class="accordion-item">
  <h2 class="accordion-header" id="heading_download">
   <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_download" aria-expanded="true" aria-controls="collapse_download">
    With colleages
   </button>
  </h2>
  <div id="collapse_download" class="accordion-collapse collapse show" aria-labelledby="heading_download" data-bs-parent="#accordion_expert">
   <div class="accordion-body">
    choose email address
   </div>
  </div>
 </div>
 <div class="accordion-item">
  <h2 class="accordion-header" id="heading_cache">
   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_cache" aria-expanded="false" aria-controls="collapse_cache">
    Social media
   </button>
  </h2>
  <div id="collapse_cache" class="accordion-collapse collapse" aria-labelledby="heading_cache" data-bs-parent="#accordion_expert">
   <div class="accordion-body">
    Twitter,
    LinkedIn,
    etc
   </div>
  </div>
 </div>
</div>

