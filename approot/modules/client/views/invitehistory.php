<div class="content-body">
   <div class="container-fluid">
      <!--<div class="row page-titles">
         <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="index.php">Home ></a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Invited Employees History</a></li>
         </ol>
      </div>-->
      <!-- row -->
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Invited Employees History</h4>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table id="example" class="display" style="min-width: 845px">
                        <thead>
                           <tr>
                              <th>Sr No</th>
                              <th>Total</th>
                              <th>Sent</th>
                              <th>Failed</th>
                              <th>Bounced</th>
                              <th>Created At</th>
                              <th>View</th>
                           </tr>
                        </thead>
                        <tbody>
                            <?php
                              $exportList = array();
                              foreach($batchData as $key=>$data){
                                 $invData = json_decode($data->invite_data, true);
                           ?>
                        <tr>
                                <td><?=$key+1?></td>
                                <td><?=$invData['total']?></td>
                                <td><?=$invData['sent']?></td>
                                <td><?=$invData['failed']?></td>
                                <td><?=$invData['bounced']?></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($data->created_at)) ?></td>
                                <td><a href="<?= base_url().'client/empinvitationlist?batchid='.$data->batch?>">View</a></td>
                        </tr>
                        <?php
                           $_SESSION['export_email_list'] = $exportList;
                              } 
                        ?>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>