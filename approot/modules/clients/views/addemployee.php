<div class="content-body">
   <div class="container-fluid">
      <div class="row page-titles">
         <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Client</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Employee</a></li>
         </ol>
      </div>
      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Add Employee</h4>
                  <?php
                  if (!empty($this->session->flashdata('error'))) {
                     $error = $this->session->flashdata('error');
                  ?>
                     <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Error!</strong> <?= $error; ?>
                     </div>
                  <?php } else {
                  } ?>
               </div>
               <div class="card-body">
                  <div class="basic-form">
                     <form method="POST" action="<?= base_url('clients/addemp'); ?>/<?= $cid; ?>/<?= $pid; ?>" enctype="multipart/form-data">
                        <div class="row">
                           <?php
                           $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid));
                           foreach ($cl as $cl);
                           ?>
                           <input type="hidden" name="client_code" value="<?= $cl->ccode; ?>">
                           <input type="hidden" name="client_name" value="<?= $cl->cname; ?>">
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Card</label>
                                 <input type="file" class="form-control" name="card">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Employee Id</label>
                                 <input type="text" class="form-control" name="emp_id" placeholder="Employee Id">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Sum Insured</label>
                                 <input type="text" class="form-control" name="sum_insured" placeholder="Sum Insured">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Username</label>
                                 <input type="text" class="form-control" name="username" placeholder="Username">
                              </div>
                           </div>

                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Password</label>
                                 <input type="password" name="password" class="form-control pass-input" placeholder="Password">

                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Employee Name</label>
                                 <input type="text" name="emp_name" class="form-control" placeholder="Employee Name">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Name</label>
                                 <input type="text" name="name" class="form-control" placeholder="Name">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Email</label>
                                 <input type="email" name="email" class="form-control" placeholder="Email">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Mobile</label>
                                 <input type="tel" name="mobile" maxlength="10" class="form-control" placeholder="Mobile">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Relation</label>
                                 <input type="text" name="relation" class="form-control" placeholder="Relation">
                              </div>
                           </div>

                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Gender</label>
                                 <select class="form-control" name="gender">
                                    <option>Select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Wedding Date</label>
                                 <input type="date" name="wedd_date" class="form-control" placeholder="Wedding Date">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>DOB</label>
                                 <input type="date" name="dob" id="dob" class="form-control" placeholder="Dob">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                 <label>Age</label>
                                 <input type="text" name="age" id="age" class="form-control" placeholder="Age">
                              </div>
                           </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Add Employee</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>