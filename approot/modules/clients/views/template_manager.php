<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Template Manager</a></li>
            </ol>
        </div>
        <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Template Manager </h4>
                
            </div>
            <div class="col-sm-4">
            
            </div>
            <?php
            $data = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
            $policy_info = $this->qm->single("ri_clientpolicy_tbl", "*", array('id' => $pid ,'cid' => $cid,));
                                       
            ?>
            <div class="card-body">
                <div class="basic-list-group">
                    <div class="row">
                        
                        <div class="col-lg-6 col-xl-6">
                            <div class="tab-content" id="nav-tabContent">
                                
                                
                                    <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/endorsmentCalculation/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                        <h4 class="mb-4">SELECT Policy Type :
                                            <select name="basis_of_calculation" id="basis_of_calculation" class="form-select form-control" required >
                                                <option value="">-Select-</option>
                                               <option value="gmc">GMC</option>
                                               <option value="gpa">GPA</option>
                                               <option value="gtli">GTLI</option>
                                            </select>
                                        </h4>
                                        <h4 class="mb-4">SELECT Endorsement Type :
                                            <select name="basis_of_calculation" id="basis_of_calculation" class="form-select form-control" required >
                                                <option value="">-Select-</option>
                                                <option value="addition">Addition</option>
                                               <option value="deletion">Deletion</option>
                                               <option value="correction">Correction</option>
                                            </select>
                                        </h4>
                                       
                                        <button type="submit" class="btn btn-primary">
                                            Submit</button>
                                        <span id="showpopupbtn"></span>
                                    </form>
                                </div>
                                
                               
                            </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>

   