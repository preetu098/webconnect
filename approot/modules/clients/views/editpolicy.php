
         <div class="content-body">
            <div class="container-fluid">
               <div class="row page-titles">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Add Policy</a></li>

                    

                  </ol>
               </div>
               <div class="row">
                
                  <div class="col-xl-12 col-lg-12">
                     <div class="card">
                        <div class="card-header">
                           <h4 class="card-title">Add Policy</h4>
                            <?php 
                             if(!empty($this->session->flashdata('error'))){
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
                              <form method="POST" action="<?= base_url('clients/updpolicy');?>/<?= $pid;?>" enctype="multipart/form-data">

                                 <?php 
                                    $pol = $this->qm->all('ri_clientpolicy_tbl','*',array('id'=>$pid));
                                    foreach($pol as $pol);
                                 ?>
                                 <div class="row">
                                   
                                    <div class="mb-3 col-md-6">

                                       <label class="form-label">Company Name</label>
                                     
                                        <?php 
                                          $cli = $this->qm->all('ri_clients_tbl','*',array('cid'=>$pol->cid));
                                          foreach ($cli as $cli);

                                         
                                         ?>
                                         <input type="text" class="form-control" readonly name="cname" value="<?= $cli->cname;?>">

                                          
                                    </div>
                                      <div class="mb-3 col-md-6">
                                       <label class="form-label">Policy Type</label>
                                        <select class="form-control" name="policy_type" id="type" onchange="chnType(this.value)">
                                          <option>Select Type</option>
                                         <?php 
                                             $typ = $this->qm->all('ad_policy_type','*',array('policy_dept_id'=> 7));
                                             foreach ($typ as $typ);
                                          ?> 
                                          <option value="5283" <?= ($pol->policy_type==5283)?'selected':'';?>>Data Collection</option>
                                          <?php 
                                             $typ = $this->qm->all('ad_policy_type','*',array('policy_dept_id'=> 7));
                                             foreach ($typ as $typ) {
                                          ?>
                                          <option value="<?= $typ->policy_type_id;?>" <?= ($pol->policy_type==$typ->policy_type_id)?'selected':'';?>><?=$typ->policy_type_name;?></option>
                                       <?php } ?>
                                       

                                       </select>
                                    </div>

                                    <div class="mb-3 col-md-2">
                                       <label class="form-label">Status</label>
                                        <select class="form-control" name="status">
                                          <option value="1" <?= ($pol->status==1)?'selected':'';?>>Active</option>
                                          <option value="0" <?= ($pol->status==0)?'selected':'';?>>Inactive</option>

                                       </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <div class="row">
                                            <div class="col-md-7">
                                       <label class="form-label">Insurer Image</label>
                                        <input type="file" name="iimage" class="form-control">
                                        </div>
                                        <div class="col-md-5">
                                            <img src="<?= base_url('external/uploads/');?><?= $pol->iimage;?>" style="width:100%;">
                                        </div>
                                        </div>
                                    </div>
                                     <div class="mb-3 col-md-3">
                                       <div id="inp">
                                          <?php 
                                             $po = $this->qm->all('ri_clientpolicy_tbl','*',array('policy_type'=>$pol->policy_type));
                                             foreach($po as $po);
                                             if($po->policy_num == 5283){

                                                echo'<label>Policy Number </label>';
                                                echo'<select class="form-select form-control" name="policy_num" id="num">';
                                            echo "<option>Select Value</option>";
                                           
                                                
                                                echo '<option value="5283" selected>Data Collection</option>';
                                         
                                            echo '</select>';
                                             }
                                             else{
                                        $type = $this->qm->all2('ad_policy','*',array('policy_type_id'=> $po->policy_type));
                                          ?>
                                          <label>Policy Number </label>
                                          <select class="form-select form-control" name="policy_num" id="num">
                                             <option>Select Value</option>


                                       <?php 
                                       foreach ($type as $type) {?>

                  <option value="<?= $type->policy_no;?>" <?= ($po->policy_num == $type->policy_no)?'selected':'';?>><?= $type->policy_no;?></option>
<?php
                                       }

                                    } ?>
                                 </select>
                                       </div>
                                    </div>
                                    
                                    
                                    <div class="mb-3 col-md-3">
                                         <label class="form-label">TPA</label>
                                      <select name="tpa" class="form-control">
                                          <option>Select TPA</option>
                                          <?php 
                                             $po = $this->qm->all('ad_crm_account','*',array('account_type_id'=>'5'));
                                       foreach ($po as $row){ ?>

                  <option value="<?= $row->account_name;?>" <?= ($row->account_name == $pol->tpa)?'selected':'';?>><?=$row->account_name;?></option>
                            <?php } ?>
                                 </select>
                                       
                                    </div>
                                    
                                    
                                    <div class="mb-3 col-md-3">
                                       <label class="form-label">Servicing Team Member</label>
                                       
                                        <!--<input type="date" name="sdate" value="<?= $pol->sdate;?>" class="form-control">-->
                                        <select name="servicing" class="form-control">
                                            <option>Select Option</option>
                                            <?php
                                       $serv = $this->qm->all2("ad_user","*",array('department_id'=>'28'));
                                       foreach($serv as $row){
                                       ?>
                                       <option value="<?=$row->firstname.' '.$row->lastname?>"><?=$row->firstname.' '.$row->lastname?></option>
                                       <?php } ?>
                                            
                                        </select>
                                    </div>
                                    
                                       <div class="mb-3 col-md-3">
                                       <label class="form-label">Start Date</label>
                                        <input type="date" name="sdate" value="<?= $pol->sdate;?>" class="form-control">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                       <label class="form-label">End Date</label>
                                        <input type="date" name="edate" value="<?= $pol->edate;?>" class="form-control">
                                    </div>
                                    
                                    <div class="mb-3 col-md-6">
                                       <label class="form-label">Sum Insured</label>
                                        <input type="text" name="suminsured" class="form-control" value="<?=$pol->suminsured?>" placeholder="1lac,2lac,4lac..">
                                        
                                    </div>



                                 </div>
                                 
                                
                                 <button type="submit" class="btn btn-primary">Update Policy</button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                 
               </div>
            </div>
         </div>
    
<script type="text/javascript">
    function chnType(typ) {
      
      $.ajax({
      type: "GET",
      url: "<?= base_url('clients/getpolicy/');?>"+typ,
      success: function(result){
       
            $("#inp").html(result);
        
     
      }
      });
   }
</script>