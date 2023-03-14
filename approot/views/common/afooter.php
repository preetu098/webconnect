 <div class="footer">
    <div class="copyright">
       <p>Designed &amp; Developed by <a href="javascript:void();" target="_blank">A&M Insurance Brokers Pvt. Ltd. </a></p>
    </div>
 </div>
 </div>


 <script src="<?= base_url('external/'); ?>vendor/apexchart/apexchart.js"></script>

 <script src="<?= base_url('external/'); ?>vendor/global/global.min.js"></script>
 <script src="<?= base_url('external/'); ?>js/datatables1.min.js"></script>
 <script src="<?= base_url('external/'); ?>js/plugins-init/datatables.init.js"></script>
 <script src="<?= base_url('external/'); ?>vendor/chart.js/Chart.bundle.min.js"></script>
 <script src="<?= base_url('external/'); ?>vendor/peity/jquery.peity.min.js"></script>
 <script src="<?= base_url('external/'); ?>js/dashboard/dashboard-1.js"></script>
 <script src="<?= base_url('external/'); ?>vendor/owl-carousel/owl.carousel.js"></script>
 <script src="<?= base_url('external/'); ?>js/custom.min.js"></script>
 <script src="<?= base_url('external/'); ?>js/dlabnav-init.js"></script>
 <script src="<?= base_url('external/'); ?>js/demo.js"></script>
 <script src="<?= base_url('external/'); ?>js/ajax.js"></script>
     <script src="<?= base_url('external/'); ?>js/styleSwitcher.js"></script> 
 <script>
    function updSum(sumin, eid, cid, pid) {

       $.ajax({
          method: "GET",
          url: "<?= base_url('clients/updsum/'); ?>" + sumin + '/' + eid + '/' + cid + '/' + pid,
          dataType: 'html',
          success: function(data) {



          }
       });

    }



    $('.copy').click(function(e) {
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
 <?php $d = rand(0, 999); ?>
 <script>
    function myFunction(cname) {
       let j = <?= $d; ?>;
       let st = cname.substr(0, 4);
       let hj = st + j;
       let tex = hj.replaceAll(' ', '');
       document.getElementById("cod").value = tex;
    }
 </script>
 <script>
    $('.copy').click(function(e) {
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
    $("#dob").change(function() {

       var today = new Date();
       var birthDate = new Date($('#dob').val());
       var age = today.getFullYear() - birthDate.getFullYear();
       var m = today.getMonth() - birthDate.getMonth();
       if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
       }
       return $('#age').val(age);
    });
 </script>
 </body>

 </html>