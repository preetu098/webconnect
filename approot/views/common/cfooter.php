 <div class="footer">
            <div class="copyright">
                 <p>Designed &amp; Developed by <a href="javascript:void();" target="_blank">A&M Insurance Brokers Pvt. Ltd. </a></p>
            </div>
         </div>
      </div>




      <script src="<?= base_url('external/');?>vendor/apexchart/apexchart.js"></script>
<script src="<?= base_url('external/');?>vendor/global/global.min.js"></script>

<script src="<?= base_url('external/');?>vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('external/');?>js/plugins-init/datatables.init.js"></script>
      <script src="<?= base_url('external/');?>vendor/chart.js/Chart.bundle.min.js"></script>
      <script src="<?= base_url('external/');?>vendor/peity/jquery.peity.min.js"></script>
      <script src="<?= base_url('external/');?>js/dashboard/dashboard-1.js"></script>
      <script src="<?= base_url('external/');?>vendor/owl-carousel/owl.carousel.js"></script>
      <script src="<?= base_url('external/');?>js/custom.min.js"></script>
      <script src="<?= base_url('external/');?>js/dlabnav-init.js"></script>
      <script src="<?= base_url('external/');?>js/demo.js"></script>
      <script src="<?= base_url('external/');?>js/ajax.js"></script>
      <script src="<?= base_url('external/');?>vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('external/');?>js/plugins-init/datatables.init.js"></script>
    <script src="<?= base_url('external/');?>js/custome_val.js"></script>
    <script src="<?= base_url('external/');?>js/sweetalert.min.js"></script>

   <!--    <script src="<?= base_url('external/');?>js/styleSwitcher.js"></script> -->
   <script type="text/javascript">
function ExportToExcel(){
       var htmltable= document.getElementById('example');
       var html = htmltable.outerHTML;
       window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    }
</script>

    <script>
  $('.copy').click(function (e) {
   e.preventDefault();
   var copyText = $(this).attr('href');

   document.addEventListener('copy', function(e) {
      e.clipboardData.setData('text/plain', copyText);
      e.preventDefault();
   }, true);

   document.execCommand('copy');  
   console.log('copied text : ', copyText);
   alert('Copied url'); 
 });
</script>
   <script type="text/javascript">

    $(".calcage").change(function(){
        let inp = $(this).attr('data-age-inp');
        var today = new Date();
        var birthDate = new Date($(this).val());
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return $('#'+inp).val(age);
    });
   
   $("#dob").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age').val(age);
});


$("#dob3").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob3').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age3').val(age);
});
   $("#dob4").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob4').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age4').val(age);
});
     $("#dob5").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob5').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age5').val(age);
});

$("#dob4Kid2").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob4Kid2').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age4Kid2').val(age);
});

$("#dob4Kid0").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob4Kid0').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age4Kid0').val(age);
});
$("#dob4Kid1").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob4Kid1').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age4Kid1').val(age);
});



   

</script>

  <script>
            $(document).ready(function(){
$("#selectall").click(function(){
        if(this.checked){
            $('.checkboxall').each(function(){
                $(".checkboxall").prop('checked', true);
            })
        }else{
            $('.checkboxall').each(function(){
                $(".checkboxall").prop('checked', false);
            })
        }
    });
  $(document).ready(function () {
    $('.endorsementtable').DataTable({
        "searching": false,
        "pageLength": 20,
        "lengthChange": false
    });
});
});



 $('.upload-emp-invite-excel').on('click',function(){
        let _this = $(this);
        let btnTxt = _this.html();
        let fileName = $('#employee').val();
        let ext = fileName.split('.').pop();
        var formData = new FormData(document.getElementById('upload-emp-form'));
        if(fileName !=''){
            if(ext =='xlsx'){
                _this.html('Please wait..');
                $.ajax({
                    url:'<?php echo base_url(); ?>client/inviteemployees',
                    type:'POST',
                    data:formData,
                    dataType: 'json',
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        if(data.success){
                            let batchId = data.batch_id;
                            let redirectUrl = data.redirecturl+'?batchid='+batchId;
                            var refreshIntervalId = setInterval(() => {
                                $.ajax({
                                    url: '<?php echo base_url(); ?>client/getemployeeinvitestatus',
                                    type: 'GET',
                                    data: {
                                        'batch_id': batchId
                                    },
                                    success: function(data){
                                        data = $.parseJSON(data);
                                        var total = data.batch_details.total;
                                        var pending = data.batch_details.pending;
                                        if(total == 0) {
                                            alert("Emails sent Successfully");
                                            document.location.href = redirectUrl;
                                        } else {
                                            var progress = Math.ceil(((total - pending)/total)*100);
                                            $('.emp-invite-progress').find('.progress-bar').attr('aria-valuenow',progress);
                                            $('.emp-invite-progress').find('.progress-bar').css('width', progress+'%');
                                            if(progress >= 100) {
                                                clearInterval(refreshIntervalId);
                                                setTimeout(() => {
                                                    alert("Emails sent Successfully");
                                                    document.location.href = redirectUrl;
                                                }, 3000);
                                            }
                                        }
                                    }
                                });
                            }, 3000);
                        }
                    },
                    error: function() {
                        alert("Something went wrong, please try again");
                        _this.html(btnTxt);
                    }
                });
            }else{
                $('#employee').val('');
                $(".error").html('');
                $(".error").html('Only Allowed File type xlsx').addClass('text-danger');
            }
        }else{
            $(".error").html('');
            setTimeout(function(){
                $(".error").html('Please Choose File').addClass('text-danger')
            },1000);
        }
    });
     

        </script>
        
        
<script type="text/javascript">
$(document).on('click', '.addmore', function (ev) {
	var $clone = $(this).parent().parent().clone(true);
	var $newbuttons = "<label class='form-label' >Remove Location</label><button type='button' class='mb-xs mr-xs btn btn-info removemore'>Remove</button>"; 
	//var $newbuttons = " <a href="javascript:;" class="btn btn-primary removemore">Remove</a>";
	$clone.find('.tn-buttons').html($newbuttons).end().appendTo($('#packagingappendhere'));
});

$(document).on('click', '.removemore', function () {
	$(this).parent().parent().remove();
});
 
</script>

<script>
        $(document).on('click','#proceed_endorsment', function(){
            swal({
                    title: "Confirm to Proceed",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                    } else {
                        swal("You click the cancel button");
                    }
            });
        })
</script>
   </body>
</html>
