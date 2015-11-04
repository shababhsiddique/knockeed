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

            function clickHandler() {

                //Do this when link clicked-
                var url = $(this).attr("href");   //Get link
                koController(url);   //Request JSon

                return false;   //Dont reload
            }

            function hash(s) {
                return s.split("").reduce(function(a, b) {
                    a = ((a << 5) - a) + b.charCodeAt(0);
                    return a & a
                }, 0);
            }

            function koController(url) {

                var vModHash = vMod;

                $.ajax({
                    type: "POST",
                    url: url,
                    data: vMod.hash,
                    dataType: "json",
                    success: function(json) {
                        //Change URL
                        window.history.pushState({state: 'new'}, json.page_header, url);

                        // Now use this data to update your view models, 
                        // and Knockout will update your UI automatically 

                        // Update view model properties and corresponding hashes
                        for (var prop in json) {
                            
                            if(prop === 'content_multi'){
                                
                                console.log("Working on "+prop);
                                var idstokeep = [];
                                var idstodelete = [];
                                
                                console.log(json["__content_multi"]);
                                if(json["__content_multi"].length < 1){
                                    console.log("No multi here");
                                    vMod.view.content_multi.removeAll();
                                }else{
                                    var hashJson = JSON.parse(json["__content_multi"]);
                                    vMod.hash["__content_multi"](json["__content_multi"]);
                                    delete json["__content_multi"];

                                    for (var MCHashItemKey in hashJson){
                                        idstokeep.push(MCHashItemKey); //These things are going to stay on the view or get updated.
                                    }    

                                    for(var i=0 ; i< vMod.view.content_multi().length ; i++){
                                        var thisKey = vMod.view.content_multi()[i].key;                                    
                                        if(idstokeep.indexOf(thisKey) === -1){
                                            //This does not belong here,
                                            idstodelete.push(thisKey); 
                                        }
                                    }

                                    for(var i=0 ; i< idstodelete.length ; i++){
                                        vMod.view.content_multi.remove(function(item) { return item.key === idstodelete[i] });
                                    }

                                    for (var MCItemKey in json["content_multi"]){
                                        //Add new arrived items
                                        vMod.view.content_multi.push(new MC_Model(MCItemKey, 'dfltTmpl', { content: json["content_multi"][MCItemKey] }));
                                    }  
                                }

                            }else{
                                
                                console.log("Working on "+prop);
                                
                                //Regular case
                                if (prop[1] == '_') {
                                    vMod.hash[prop](json[prop]);
                                } else {
                                    vMod.view[prop](json[prop]);  //vMod.view.footer(json.footer);
                                }
                            }
                            
                        }

                        $("a.ko_link").unbind("click");
                        $("a.ko_link").bind("click", clickHandler);
                    }
                });

            }

            $(document).ready(function() {
                $("a.ko_link").unbind("click");
                $("a.ko_link").bind("click", clickHandler);

                window.onpopstate = function(event) {
                    location.reload();              //Back button ajax not yet implemented, will reload actual site.                   
                };
            });
        </script>
    </body>
</html>
