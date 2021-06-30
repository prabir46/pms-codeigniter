<style type="text/css">
    
    .ui-menu .ui-menu-item {
    margin: 0;
    padding: 0;
    zoom: 1;
    float: left;
    clear: left;
    width: 100%;
}
.ui-widget-content {
    border: 1px solid #aaaaaa/*{borderColorContent}*/;
    color: #222222/*{fcContent}*/;
}
.ui-menu {
    list-style: none;
    padding: 2px;
    margin: 0;
    display: block;
    float: left;
}
.ui-menu {
    list-style: none;
    padding: 2px;
    margin: 0;
    display: block;
    float: left;
}
.ui-menu .ui-menu-item {
    margin: 0;
    padding: 0;
    zoom: 1;
    float: left;
    clear: left;
    width: 100%;
}
.ui-menu .ui-menu-item a {
    text-decoration: none;
    display: block;
    padding: .2em .4em;
    line-height: 1.5;
    zoom: 1;
    color: black;
}

.ui-autocomplete {
    position: absolute;
    cursor: default;
}
.ui-widget {
    font-family: Roboto/*{ffDefault}*/;
    font-size: 1.1em/*{fsDefault}*/;
}

li {
    display: list-item;
    text-align: -webkit-match-parent;
}
.ui-autocomplete {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1051 !important;
    float: left;
    display: none;
    min-width: 160px;
    _width: 160px;
    padding: 4px 0;
    margin: 2px 0 0 0;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-color: rgba(0, 0, 0, 0.2);
    border-style: solid;
    border-width: 1px;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -webkit-background-clip: padding-box;
    -moz-background-clip: padding;
    background-clip: padding-box;
}
.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl {
    -moz-border-radius-topleft: 4px/*{cornerRadius}*/;
    -webkit-border-top-left-radius: 4px/*{cornerRadius}*/;
    -khtml-border-top-left-radius: 4px/*{cornerRadius}*/;
    border-top-left-radius: 4px/*{cornerRadius}*/;
}
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {
    -moz-border-radius-topright: 4px/*{cornerRadius}*/;
    -webkit-border-top-right-radius: 4px/*{cornerRadius}*/;
    -khtml-border-top-right-radius: 4px/*{cornerRadius}*/;
    border-top-right-radius: 4px/*{cornerRadius}*/;
}
.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl {
    -moz-border-radius-bottomleft: 4px/*{cornerRadius}*/;
    -webkit-border-bottom-left-radius: 4px/*{cornerRadius}*/;
    -khtml-border-bottom-left-radius: 4px/*{cornerRadius}*/;
    border-bottom-left-radius: 4px/*{cornerRadius}*/;
}
ul, menu, dir {
    display: block;
    list-style-type: disc;
    -webkit-margin-before: 1em;
    -webkit-margin-after: 1em;
    -webkit-margin-start: 0px;
    -webkit-margin-end: 0px;
    -webkit-padding-start: 40px;
}
@media (min-width: 979px)
body {
    padding-top: 0px;
    color: #222222;
}
</style>

<div class="content-wrapper fxset" style="padding-top: 20px; height: 100%;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2 class="pagetitle" style="margin-left:20px;">Videos</h2>
                <div class="panel-body" style="margin-left: 10px;">

                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-9">

                            <div class="form-group label-static is-empty">

                                <label for="search" class="control-label">Search Videos</label>
                                <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control onFocus smart ui-autocomplete-input" id="search" type="text" name="search" value="" autocomplete="off">

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-3" style="margin-top: 25px;">
                            <span class="input-group-btn" style="/*padding-top:6%*/;" id="searchIpad">
                                <button id="SearchButton" class="btn btn-md btn-primary">Search</button>
                            </span>
                        </div>

                    </div>

                </div>

                <div id="youtubevideo">


                        
                </div>
                

                </div>

            </div>

        </div>
    </div>
    <script type="text/javascript">
        
          $(document).ready(function () {

                GetVideos('');

               

                $("#SearchButton").on("click", function () {
                    
                    console.log($('#search').val());
                    GetVideos($('#search').val());
                    
                });
                
                


                $('#search').autocomplete({
                    source: "<?php echo site_url('admin/videos/VideoNameAutoComplete'); ?>",
                    minLength: 1,
                    dataType: "json",
                    success: function (data) {
                        response($.map(data, function (item) {
                            return item.value;
                        }))
                    
                    }

                });



                function GetVideos(name) {
                    console.log(name);
                   
                    $.ajax({
                        url: "<?php echo site_url('admin/videos/GetVideos?name='); ?>"+name,
                        
                        type: 'GET',
                        success: function (data, textStatus, jqXHR) {
                            if (typeof data == "object" && data.html) {
                                $("#youtubevideo").html(data.html);

                            } else {

                                $("#youtubevideo").html(data);

                            }

                        }
                    });

                }


           });

    </script>