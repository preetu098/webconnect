 <form method="POST" action="<?= base_url('clients/addfaq');?>/<?=$cid;?>/<?= $pid;?>" enctype="multipart/form-data">
        <div class="row">
                 <!--  <div class="col-lg-6 col-md-6">
                     <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" class="form-control" placeholder="Add New Item">
                     </div>
                  </div> -->
                 
                  <div class="col-lg-12 col-md-6">
                     <div class="form-group">
                        <label> Question</label>
                        <input type="text" name="question" class="form-control" placeholder=" Question">
                     </div>
                  </div>
                  <div class="col-lg-12 col-md-6">
                     <div class="form-group">
                        <label>Answer</label>
                        <textarea style="height: 250px;" class="form-control" name="answer"></textarea>
                     </div>
                  </div>
                  
               </div>
               <br>
               <button type="submit" class="btn btn-primary">Add FAQ</button>
         </form>