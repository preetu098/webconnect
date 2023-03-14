 <div class="footer">
            <div class="copyright">
                <p>Designed &amp; Developed by <a href="javascript:void();" target="_blank">A&M Insurance Brokers Pvt. Ltd. </a></p>
            </div>
         </div>
      </div>


     <!-- <script src="<?= base_url('external/');?>vendor/apexchart/apexchart.js"></script>-->
<script src="<?= base_url('external/');?>vendor/global/global.min.js"></script>

<script src="<?= base_url('external/');?>vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('external/');?>js/plugins-init/datatables.init.js"></script>
     <!-- <script src="<?= base_url('external/');?>vendor/chart.js/Chart.bundle.min.js"></script>
      <script src="<?= base_url('external/');?>vendor/peity/jquery.peity.min.js"></script>
      <script src="<?= base_url('external/');?>js/dashboard/dashboard-1.js"></script>-->
      <script src="<?= base_url('external/');?>vendor/owl-carousel/owl.carousel.js"></script>
      <script src="<?= base_url('external/');?>js/custom.min.js"></script>
      <!--<script src="<?= base_url('external/');?>js/dlabnav-init.js"></script>-->
      <script src="<?= base_url('external/');?>js/demo.js"></script>
      <script src="<?= base_url('external/');?>js/ajax.js"></script>
   <!--    <script src="<?= base_url('external/');?>js/styleSwitcher.js"></script> -->
 
        <script type="text/javascript">
   
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

</script>

   </body>
</html>
