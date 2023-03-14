<div class="basic-form">
                              <form method="POST" action="<?= base_url('clients/addppt');?>/<?= $cid;?>/<?= $pid;?>" enctype="multipart/form-data">
                                 <div class="row">
                
                                   
                                    <div class="col-lg-6 col-md-6">
                                       <div class="form-group">
                                          <label> Name</label>
                                          <input type="text" name="ppt_name" class="form-control" placeholder=" Name">
                                       </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                       <div class="form-group">
                                          <label>Upload PPT</label>
                                          <input type="file" name="ppt[]" multiple class="form-control">
                                       </div>
                                    </div>
                                    
                                 </div>
                                 <br>
                                
                                 <button type="submit" class="btn btn-primary">Upload PPT</button>
                              </form>
                           </div>