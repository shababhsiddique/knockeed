<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Modern Business - Start Bootstrap Template</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url() ?>theme/modern-business/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo base_url() ?>theme/modern-business/css/modern-business.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo base_url() ?>theme/modern-business/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="<?php echo base_url() ?>theme/modern-business/https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="<?php echo base_url() ?>theme/modern-business/https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- KnockoutJS -->
        <script type='text/javascript' src='<?php echo base_url() ?>resource/js/knockout-3.3.0.js'></script>
        
    </head>

    <body>

        <!-- Navigation -->
        <?php echo $navbar; ?>

        <!-- Page Content -->
        <div class="container">

            <!-- Page Heading/Breadcrumbs -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <span  data-bind="text: view.page_header"><?php echo $page_header ?></span>                        
                        <small data-bind="text: view.page_subheader"><?php echo $page_subheader ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a class="ko_link" href="<?php echo base_url() ?>">Home</a>
                        </li>
                        <li class="active" data-bind="text: view.active_breadcrumb"><?php echo $active_breadcrumb ?></li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <!-- Content Row -->
            <div class="row">
                <div id="sdb-div" class="col-md-3">
                    <!-- Sidebar Column -->
                    <div data-bind="html: view.sidebar"></div>
                </div>
                <div id="cnt-div" class="col-md-9">
                    <!--Content Column--> 
                    <div data-bind="html: view.content"></div>
                    
                    <div data-bind="foreach: view.content_multi ">
                        <div data-bind="template: { name: template(), data: data }"></div>   
                    </div>
                </div>

                <div id="cnt-div-full" class="col-lg-12">
                    <div data-bind="html: view.content_full"></div>
                </div>

            </div>
            <!-- /.row -->
            <hr>
            <!-- Footer -->
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <p data-bind="text: view.footer"><?php echo $footer; ?></p>

                        <strong>Debug info -</strong>
                        <pre data-bind="text: ko.toJSON(hash, null, 2) "> </pre>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.container -->

        <script id="dfltTmpl" type="text/html">
            <div data-bind="html: content "></div>
        </script>


        <!-- jQuery -->
        <script src="<?php echo base_url() ?>theme/modern-business/js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo base_url() ?>theme/modern-business/js/bootstrap.min.js"></script>

        <script type="text/javascript">

            // Boilerplate for multi_content
            function MC_Model(key, template, data) {
                this.key = key;
                this.template = ko.observable(template);
                this.data = data;
            }

            // Layout App View Model
            function AppViewModel() {
                this.footer = ko.observable("<?php echo $footer; ?>");
                this.page_header = ko.observable("<?php echo $page_header; ?>");
                this.page_subheader = ko.observable("<?php echo $page_subheader; ?>");
                this.active_breadcrumb = ko.observable("<?php echo $active_breadcrumb; ?>");

                this.content_full = ko.observable();
                this.sidebar = ko.observable();
                this.content = ko.observable();

                this.content_multi = ko.observableArray([<?php
                    $mcItems = array();
                    foreach ($content_multi as $anMCItemKey => $anMCItem){
                        $mcItems[] = "new MC_Model('$anMCItemKey', 'dfltTmpl', { content: '$anMCItem' })";
                    }
                    echo implode(",", $mcItems);
                ?>]);

            }

            function ViewHashModel() {
                this.__footer = ko.observable("<?php echo md5($footer); ?>");
                this.__page_header = ko.observable("<?php echo md5($page_header); ?>");
                this.__page_subheader = ko.observable("<?php echo md5($page_subheader); ?>");
                this.__active_breadcrumb = ko.observable("<?php echo md5($active_breadcrumb); ?>");
                this.__content_full = ko.observable("<?php echo md5($content_full); ?>");
                this.__sidebar = ko.observable("<?php echo md5($sidebar); ?>");
                this.__content = ko.observable("<?php echo md5($content); ?>");

                this.__content_multi = ko.observable('<?php
                    $mcItems = array();
                    foreach ($content_multi as $anMCItemKey => $anMCItem){
                        $mcItems[$anMCItemKey] = md5($anMCItem) ;
                    }
                    echo json_encode($mcItems);
                ?>');

            }

            var vMod = {
                view: new AppViewModel(),
                hash: new ViewHashModel()
            };

            //HTML observables
            vMod.view.content_full('<?php echo $content_full; ?>');
            vMod.view.sidebar('<?php echo $sidebar; ?>');
            vMod.view.content('<?php echo $content; ?>');

            // Activates knockout.js
            ko.applyBindings(vMod);
            
        </script>
        <script type="text/javascript" src="<?php echo base_url()?>/resource/js/script.js"></script>
    </body>
</html>
