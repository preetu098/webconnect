<div class="basic-form custom_file_input">
<form method="POST" action="<?= base_url('clients/addbanner');?>/<?= $cid;?>/<?= $pid;?>" enctype="multipart/form-data">


<div class="input-group mb-3">
		<div class="form-file">
			<input type="file" name="banner_img" class="form-file-input form-control">
		</div>
	<button class="btn btn-primary btn-sm" type="submit">Add</button>
</div>

</form>
</div>
<div class="row">
<!-- javed -->
<div class="col-xl-6">
   <div class="card">
      <div class="card-body p-4">
         <h4 class="card-intro-title">Images</h4>
         <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            
            <div class="carousel-inner">
             <?php 
               $ss =1;
            	$img = $this->qm->all('ri_banner_tbl','*',array('cid'=>$cid,'pid'=>$pid));
            	foreach ($img as $img) {
            		
            ?>		
               <div class="carousel-item <?= ($ss==1)?'active':'';?>">
                  <img class="d-block w-100" src="<?= base_url('external/uploads/');?><?= $img->banner_img;?>" style="height: 250px;object-fit: cover;">
               </div>
           <?php 
           $ss++;
        } ?>
              
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
         </div>
      </div>
   </div>
</div>

<!-- <div class="col-xl-6">
   <div class="card">
      <div class="card-header">
         <h4 class="card-title">Delete Image</h4>
      </div>
      <div class="card-body">
         <div class="basic-form">
            <form action="#">
              <div class="form-group">
              		<label class="form-label">Select Image</label>
              		<select class="form-control">

              			<option value="1"><img src="" style="width: 100px;"></option>
              		</select>
              </div>	
             <button class="btn btn-primary btn-sm" type="submit">Delete</button>
            </form>
         </div>
      </div>
   </div>
</div> -->

</div>
