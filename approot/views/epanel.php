<?php

$this->load->view('common/emenu');
$this->load->view($mainContent); 
//$this->load->view('common/footer'); 
$this->load->view('common/efooter');

?>
 <div class="modal fade" id="deletedepmodal" tabindex="-1" aria-labelledby="deletedepmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletedepmodalLabel">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="delete-dep-form" enctype="multipart/form-data">
                    <input type="hidden" name="did">
                    <input type="hidden" name="pid">
                    <input type="hidden" name="cid">
                    <input type="hidden" name="eid">
                    <label for="img">DOL:</label>
                    <input type="date" class="form-control" id="dol" name="dol">
                    <span class='error'></span><br>
                    <label for="img">Reason:</label>
                    <textarea class="form-control" name="reson"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="doDelDep()" class="btn btn-primary delete-dep-invite-excel">Submit</button>
            </div>
        </div>
    </div>
</div>
<script>
    function deleterec2(did,pid,cid,eid) {
        $('#deletedepmodal').find('input[name="did"]').val(did);
        $('#deletedepmodal').find('input[name="pid"]').val(pid);
        $('#deletedepmodal').find('input[name="cid"]').val(cid);
        $('#deletedepmodal').find('input[name="eid"]').val(eid);
        $('#deletedepmodal').modal('show');
    }

    function doDelDep() {
        msg = $('#deletedepmodal').find('input[name="dol"]').val();
        reson = $('#deletedepmodal').find('textarea[name="reson"]').val();
        if (msg == '' || reson == '') {
            alert('Please fill Date of leaving and Reason');
            return false;
        }
        did = $('#deletedepmodal').find('input[name="did"]').val();
        pid = $('#deletedepmodal').find('input[name="pid"]').val();
        cid = $('#deletedepmodal').find('input[name="cid"]').val();
        eid = $('#deletedepmodal').find('input[name="eid"]').val();
        window.location.href = "<?= base_url('employee/deletedep/') ?>" + cid + "/"+pid+"/"+eid+"/"+did+"?reson=" + reson + "&dol=" + msg;
    };

    
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

    $("#dob6").change(function(){

        var today = new Date();
        var birthDate = new Date($('#dob6').val());
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return $('#age6').val(age);
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