<?php
                                    $sn = 1; 
                                       $ppt = $this->qm->all('upload_ppt_ri','*',array('cid'=>$cid,'pid'=>$pid));
                                       foreach ($ppt as $ppt) {
                                          
                                       

                                    ?>
<!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http://web-techno.com/pms/jav.ppt' width='100%' height='400px' frameborder='0'> </iframe>-->
<?php if(!empty($ppt->ppt) && file_exists('external/uploads/'.$ppt->ppt)): ?>
<img src="<?=base_url('external/uploads/'.$ppt->ppt)?>" width="200"/>
<a href="<?=base_url('clients/pptdel/'.$cid.'/'.$pid)?>" data-id="<?= $ppt->id ?>" class="btn btn-sm btn-danger ppt_delbtn">Delete</a>
<?php endif; ?>

<?php } ?>
<br><br><br><br>
<?php if(!empty($ppt->ppt) && file_exists('external/uploads/'.$ppt->ppt)): ?>
<a href="<?=base_url('clients/pptdelAll/'.$cid.'/'.$pid)?>" data-id="<?= $ppt->id ?>" class="btn btn-sm btn-warning pptdelall">Delete All</a>
<?php endif; ?>
<script>
   $(document).ready(function(){

      $(".ppt_delbtn").click(function(event){
         var href = $(this).attr("href")
         var pptId = $(this).data('id');
         var status = confirm("Are you sure you want to delete ?");  
            if(status==true)
            {
               $.ajax({
                  type: "POST",
                  url: href,
                  data:{id:pptId},
                  dataType: 'html',
                  success: function(res) {
                        alert('Deleted ppt!');
                        $('#dem').html(res);
                  }
               });
            }
            event.preventDefault();
      })

      $(".pptdelall").click(function(event){
         var href = $(this).attr("href")
         var status = confirm('Are you sure you want to delete all ppt ?');  
            if(status==true)
            {
               $.ajax({
                  type: "POST",
                  url: href,
                  dataType: 'html',
                  success: function(res) {
                        alert('Deleted all ppt!');
                        $('#dem').html(res);
                  }
               });
            }
            event.preventDefault();
      })
   });
</script>