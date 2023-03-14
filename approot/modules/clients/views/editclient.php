
         <div class="content-body">
            <div class="container-fluid">
               <div class="row page-titles">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Client</a></li>
                  </ol>
               </div>
               <div class="row">
                
                  
                 
               
                  
                
                  <div class="col-xl-12 col-lg-12">
                     <div class="card">
                        <div class="card-header">
                           <h4 class="card-title">Edit Client</h4>
                            <?php 
                                 if(!empty($this->session->flashdata('success'))){

                                    $success = $this->session->flashdata('success');
                              ?>
                           <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Success!</strong><?= $success;?>
                           </div>
                        <?php }
                        else if(!empty($this->session->flashdata('error'))){
                           $error = $this->session->flashdata('error');
                         ?>
                          <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Error!</strong> <?= $error;?>
                           </div>
                         <?php }else{} ?>  
                        </div>
                        <div class="card-body">
                           <div class="basic-form">
                              <form method="POST">
                                 <div class="row">
                                    
                                    <div class="mb-3 col-md-6">
                                       <label class="form-label">Company Name</label>
                                       <select class="form-control" name="cname" id="cname" onchange="editCli(this.value)">
                                        <option>Select Company</option>
                                        <?php 
                                          $cli = $this->qm->all('ri_clients_tbl');
                                          foreach ($cli as $cli) {
                                         
                                         ?>

                                          <option value="<?= $cli->cid;?>"><?= $cli->cname;?></option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                  
                                 </div>
                                 
                                
                                 <!-- <button type="submit" class="btn btn-primary">Add Client</button> -->
                              </form>
                              <div class="row" id="getclient">
                                       
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                 
               </div>
            </div>
         </div>
    
<script type="text/javascript">
   
   function editCli(cid) {
      
       $.ajax({

          method:"GET",
          url:"<?= base_url('clients/clientform/');?>"+cid,
          dataType: 'html',
          success:function(data){

              $('#getclient').html(data);
             
          }

      });

   }


</script>