<div class="table-responsive">
   <table class="table table-bordered verticle-middle table-responsive-sm">
      <thead>
         <tr>
            <th scope="col">Document Category</th>
            <th scope="col">Document Name</th>
            <th scope="col">Document Link</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
         </tr>
      </thead>
      <tbody>
        <?php 
            $doc = $this->qm->all('client_doc_tbl','*',array('cid'=>$cid,'pid'=>$pid));
            foreach ($doc as $doc) {
                
        ?>
         <tr>
            <td><?= ($doc->doc_cate==1)?'<span class="badge badge-success light">Link</span>':'<span class="badge badge-info light">Other</span>';?></td>
          
            <td><?= $doc->docu_name;?></td>
            <td>
                <?php 
                    if($doc->doc_cate==1){
                        ?>
                     <a href="<?= $doc->docu_link;?>"><?= $doc->docu_link;?></a>   
                 <?php    }
                 else{
                ?>
                <img src="<?= base_url('external/uploads/');?><?= $doc->docu_link;?>" style="width: 100px;">
            <?php } ?>
            </td>
            <td><?= $doc->docu_des;?></td>
            <td>
              <div class="d-flex">
                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                </div>
            </td>
         </tr>
         <?php } ?>
      </tbody>
   </table>
</div>
