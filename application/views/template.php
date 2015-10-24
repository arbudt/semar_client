<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Semar Client</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="<?php echo base_url() ?>assets/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/docs.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/prettify.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/table-pagination.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/bootstrap-editable.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/select2.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/yamm.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/autoSuggest.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/jquery.dataTables.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/jquery.handsontable.full.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">

        <!-- TAMBAHAN -->
        <link href="<?php echo base_url() ?>assets/css/bootstrap-modal.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/general.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/vscroller.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/rightposthover.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/jquery.fixheadertable.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/font-awesome-403.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/animate.css" rel="stylesheet">

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
        <![endif]-->
        <!-- Jquery ui -->

        <!-- Le fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="assets/ico/favicon.png">
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.js'); ?>"></script>

    <style>
        table thead tr th{
            font-weight: bold !important;
            text-align: center !important;
            background: #C5C5C5;
        }
        form {
            margin-bottom: 5px !important;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }
        .loadingProgress{
            height: 5px !important;
        }
        .date{

            margin-bottom: 1px !important;

        }
        .add-on{
            height: 14px !important;
        }

        .btn[disabled]{
            color: #868686 !important;
            background-color: #eeeeee !important;
        }

        #menuBos .dropdown{
            font-size: large;
        }

        #menuBos li a{
            font-size: large;
        }
    </style>
    <script>
        function showPopOver(){
            $('.brand').popover('show');
        }
            
        function hidePopOver(){
            $('.brand').popover('hide');
        }
            
        $(document).ready(function(){
            $('.loadingProgress').modal('hide');
        });
            
        function showProgressBar(msg){
            $('#labelProgressBar').html(msg+'...');
            $('.loadingProgress').modal('show');
        }
            
        function hideProgressBar(){
            $('.loadingProgress').modal('hide');
        }
    </script>
    <!-- header -->
    <div class="navbar navbar navbar-fixed-top">
        <div class="btn-info" style="min-height: 60px !important;">
            <div class="row-fluid" style="text-align: center">
                <div class="span12">
                    <h4>RUMAH SAKIT</h4>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <div class="navbar-inner menuTop" style="max-height: 5px !important;">
            <div class="container" style="max-height: 5px !important;">
                <a href="#" class="brand" data-toggle="popover" data-placement="bottom" data-content="<?php echo!empty($menuDescription) ? $menuDescription : ''; ?>" title="<?php echo!empty($menuTitle) ? $menuTitle : ''; ?>" onmouseover="showPopOver()" onmouseout="hidePopOver()"><?php echo!empty($menuTitle) ? $menuTitle : ''; ?></a
                <div class="nav-collapse collapse">
                    <ul class="nav" id="menuBos">
                        <li class="active">
                            <a href="<? echo site_url(); ?>">Home</a>
                        </li>
                        <li class="">
                            <a href="<? echo site_url('registrasi/reg_pasien'); ?>">Registrsi Pasien</a>
                        </li>
                        <li class="">
                            <a href="<? echo site_url('registrasi/reg_poli'); ?>">Poliklinik</a>
                        </li>
                        <li class="">
                            <a href="<? echo site_url('pelayanan/pelayanan'); ?>">Pelayanan</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- loading proses (prosegress bar) -->
        <div id="loadingProgress" class="modal hide loadingProgress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
            <div class="progress progress-striped">
                <div class="bar" style="width: 100%;" id="labelProgressBar">sedang diproses...</div>
            </div>
        </div>

        <!-- body -->
        <div class="container" style="min-height: 380px; margin-top: 75px">
            <div class="row-fluid">
                <div class="span12">
                    <?php
                    $this->load->view($page);
                    ?>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <!--            <footer class="footer">
                        <p>2014 © aby</p>
                    </footer>-->

        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/widgets.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-editable.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/select2.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-transition.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-alert.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-modal.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-scrollspy.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-tab.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-button.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-collapse.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-carousel.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-typeahead.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-affix.js"></script>
<!--            <script type="text/javascript" src="<?php //echo base_url()              ?>assets/js/nagging-menu.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jqBootstrapValidation.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.tablePagination.0.5.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-modalmanager.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.serialize-object.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.bootstrap.js"></script>
        <!-- http://datatables.net/ -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
        <!-- autosuggest input http://code.drewwilson.com/entry/autosuggest-jquery-plugin -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.autoSuggest.minified.js"></script>
        <!-- format numeral -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/numeral.js"></script>
        <!-- custom dialog -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootbox.min.js"></script>

        <!-- Jquery ui DO NOT REMOVE THIS LINE!-->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.numeric.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui-sliderAccess.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.masking.min.js"></script>
        <!-- handsontable -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.handsontable.full.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/tree_multiselect.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-tooltip.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-popover.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/vscroller.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jqClock.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.fixheadertable.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.inputmask.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.inputmask.date.extensions.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.inputmask.numeric.extensions.js"></script>

        <script type="text/javascript">
            var jqValidateReq = <?php echo!empty($jqValidateReq) ? (int) $jqValidateReq : 0; ?>;
            if( jqValidateReq == true) {
                $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
            }
            servertime = parseFloat( $("input#servertime").val() ) * 1000;
            $("#clock").clock({"format":"24","langSet":"simrs","timestamp":servertime});
	
        </script>

    </body>
</html>
