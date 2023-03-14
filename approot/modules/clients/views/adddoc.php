 <form method="POST" action="<?= base_url('clients/adddocu');?>/<?=$cid;?>/<?= $pid;?>" enctype="multipart/form-data">
        <div class="row">
                
                 
                  <div class="col-lg-6 col-md-6">
                     <div class="form-group">
                        <label> Document Category</label>
                        <select class="form-select form-control" name="doc_cate" onchange="getcate(this.value)">
                           <option>Select category</option>
                           <option value="1">Website Link</option>
                           <option value="2">Other</option>
                           
                        </select>
                     </div>
                  </div>
                   <div class="col-lg-6 col-md-6">
                     <div class="form-group" id="cate_item">
                        
                     </div>
                  </div>
                  <div class="col-lg-12 col-md-6">
                     <div class="form-group">
                        <label>Document Name</label>
                        <input type="text" class="form-control" name="docu_name" placeholder="Document Name">
                     </div>
                  </div>
                  <div class="col-lg-12 col-md-6">
                     <div class="form-group">
                        <label>Description</label>
                        <textarea style="height: 100px;" class="form-control" name="docu_des"></textarea>
                     </div>
                  </div>
                  
               </div>
               <br>
               <button type="submit" class="btn btn-primary">Add FAQ</button>
         </form>

         <script type="text/javascript">
            
         function getcate(cate) {
            
            if(cate == 1){

               $('#cate_item').html('<label>Document Link</label><input type="text" name="docu_link" class="form-control" placeholder="Document Link">');
            }
            else{
                $('#cate_item').html('<label>Other</label><input type="file" name="docu_link" class="form-control">');
            }
         }
         </script>