<style>
    #label {
        font-size: 13px;
        font-weight: 700;
    }

    .searchdivfields {
        margin-bottom: 10px;
        margin-top: 10px;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }

    .form-control {
        background: #fff;
        border: 0.0625rem solid #886cc0;
        padding: 0.3125rem 1.25rem;
        color: #6e6e6e;
        height: 3.5rem;
        border-radius: 1rem;
    }

    .m-top {
        margin-top: 10px;
    }
</style>
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Create Template Manager</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Template Master </h4>

                    </div>
                    <div class="col-sm-2">

                        <input type="number" class="form-control" id="num_row" name="num_row" placeholder="Enter Number ">
                    </div>
                    <?php
                    $data = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
                    $policy_info = $this->qm->single("ri_clientpolicy_tbl", "*", array('id' => $pid, 'cid' => $cid,));

                    ?>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="col-lg-12 col-xl-12">
                                <div class="tab-content" id="nav-tabContent">
                                    <form class="form-group" id="execl" method="POST" action="<?= base_url('clients/add_template_master'); ?>">
                                        <div id=" frmsearch">
                                            <div class="center-text">
                                                <div id="divaddsearchfields" data-noofsearch=1>
                                                    <div class='row'>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <div class="column_field ">
                                                                <label class="form-label" id="label">
                                                                    Column Heading Name
                                                                </label>
                                                                <input type=" text" class="form-control" name="heading_name[]" data-index="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <div class="mapped_field ">
                                                                <label class="form-label" id="label">
                                                                    Mapped with
                                                                </label>
                                                                <div>
                                                                    <select class="form-control searchfield" name="mapped_field[]" data-index="1">
                                                                        <option value="">Select Field</option>
                                                                        <?php
                                                                        $emp = $this->qm->all('ri_employee_tbl', '*', array('cid' => 12, 'pid' => 14));
                                                                        foreach ($emp[0] as $key => $emps) {
                                                                        ?>
                                                                            <option data-function="<?php echo $key ?>" value="<?php echo $key ?>"><?php echo $key; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <div class="searchdiv_field ">
                                                                <label class="form-label" id="label">
                                                                    Font Style
                                                                </label>
                                                                <input type="text" class="form-control" name="font_style[]" data-index="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <div class="searchdiv_condition " id="label">
                                                                <label class="form-label">
                                                                    Font Color</label>
                                                                <input type="text" class="form-control" name="font_color[]" data-index="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 col-xl-1">
                                                            <div class="searchdiv_condition " id="label">
                                                                <label class="form-label">
                                                                    Font Size</label>
                                                                <input type="text" class="form-control" name="font_size[]" data-index="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 col-xl-1">
                                                            <div class="searchdiv_condition " id="label">
                                                                <label class="form-label">
                                                                    Cell Fill Color
                                                                </label>
                                                                <input type="text" class="form-control" name="cell_fill_color[]" data-index="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <div class="searchdiv_condition " id="label">
                                                                <label class="form-label">
                                                                    Modification
                                                                </label>
                                                                <input type="text" class="form-control" name="modific[]" data-index="1">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <button class="btn btn-primary m-top">Create Template</button>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        // Get value on button click and show alert
        $("#num_row").keyup(function() {
            var str = $("#num_row").val();
            // alert(str);
            for (i = 1; i <= str; i++) {
                addAnotherSearchField();
            }
        });
    });

    function addAnotherSearchField() {

        // var selectedoperator = $(".searchoperator[data-index='1']").val();
        // if (selectedoperator == "") {
        //     alert("Please select Operator");
        //     return;
        // }
        // var serachopeartor_option = $(".searchoperator[data-index='1'] option:selected");
        // var newoperatoroption = `<option value='${selectedoperator}'>${serachopeartor_option.text()}</option>`;
        var options = $(".searchfield[data-index='1'] option");
        console.log("options", options);
        var fields = [];
        options.each(function() {
            fields.push({
                'fieldname': $(this).val(),
                'fieldlabel': $(this).text(),
                'fieldfunction': $(this).data('function')
            });
        });
        var noofsearch = $("#divaddsearchfields").data("noofsearch");
        noofsearch = parseInt(noofsearch) + 1;

        $("#divaddsearchfields").append(`
        <div class='searchdivfields' data-index='${noofsearch}' >
            <div class='row'>
                <div class="col-lg-2 col-xl-2">
                    <div class="column_field ">
                        <!-- <label class="lbl_control">Field:</label> -->

                        <input type=" text" class="form-control" name="heading_name[]" data-index='${noofsearch}'>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-2">
                    <div class="mapped_field ">

                        <div>
                            <select class="form-control searchfield" name="mapped_field[]"  data-index='${noofsearch}'></select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-2">
                    <div class="searchdiv_field ">

                        <input type="text" class="form-control" name="font_style[]" data-index='${noofsearch}'>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-2">
                    <div class="searchdiv_condition " id="label">
                        <input type="text" class="form-control" name="font_color[]" data-index='${noofsearch}'>
                    </div>
                </div>
                <div class="col-lg-1 col-xl-1">
                    <div class="searchdiv_condition " id="label">
                        <input type="text" class="form-control" name="font_size[]" data-index='${noofsearch}'>
                    </div>
                </div>
                <div class="col-lg-1 col-xl-1">
                    <div class="searchdiv_condition " id="label">
                        <input type="text" class="form-control" name="cell_fill-color[]" data-index='${noofsearch}'>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-2">
                    <div class="searchdiv_condition " id="label">

                        <input type="text" class="form-control" name="modific[]" data-index='${noofsearch}'>
                    </div>
                </div>
                <div class='searchdiv_trash'>
                    <a data-index="${noofsearch}" href='javascript:void(0);' onclick='deleteFieldFilter(${noofsearch})'> <i class="fa fa-trash" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
`);

        $("#divaddsearchfields").data("noofsearch", noofsearch);


        for (let field of fields) {
            $(`.searchfield[data-index='${noofsearch}']`).append(`<option  data-function="${field['fieldfunction']}"   value="${field['fieldname']}">${field['fieldlabel']}</option>`);
        }


    }

    function deleteFieldFilter(index) {

        $(`#divaddsearchfields  .searchdivfields[data-index='${index}']`).remove();

    }
</script>