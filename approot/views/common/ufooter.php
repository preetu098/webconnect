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
   <!--    <script src="<?= base_url('external/');?>js/styleSwitcher.js"></script> -->
 
    <script type="text/javascript">
   
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
   $("#dob1").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob1').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age1').val(age);
});

   $("#dob2Kid0").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob2Kid0').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age2Kid0').val(age);
});
   $("#dob2Kid1").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob2Kid1').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age2Kid1').val(age);
});
   $("#dob2Kid2").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob2Kid2').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age2Kid2').val(age);
});
   $("#dob2Kid3").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob2Kid3').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age2Kid3').val(age);
});
 $("#dob2").change(function(){

    var today = new Date();
    var birthDate = new Date($('#dob2').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
   return $('#age2').val(age);
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
</script>

   </body>
</html>
