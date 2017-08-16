<!DOCTYPE html>
<html>
<head>
    <meta charset="{CHARSET}" name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.css")}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("/css/swang.css")}}">
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/jquery-1.8.3.min.js")}}"></script>
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.js")}}"></script>
</head>
<body>
<div data-role="page" data-dialog="true">
        <div data-role="header" data-theme="b" role="banner" class="ui-header ui-bar-b"><a href="#" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-notext ui-btn-left" data-rel="back">Close</a>
            <h1 class="ui-title" role="heading" aria-level="1">Dialog</h1>
        </div>

        <div role="main" class="ui-content">
            <h1>确认取消收藏吗？</h1>
            <p>你还可以重新在工厂详情页添加</p>
            <a href="javascript:doRemoveConfirm()" class="ui-btn ui-shadow ui-corner-all ui-btn-a">确认</a>
            <a href="#" data-rel="back" class="ui-btn ui-shadow ui-corner-all ui-btn-a">取消</a>
        </div>
</div>

<script type="text/javascript">
    function doRemoveConfirm(){
        $.ajax({
            url : '{{env('CURRENT_SERVER')}}/cancel/collection?factory_id={{$factory_id}}',
            type : 'get',
            dataType : 'json',
            success : function(response) {

            }
        })
    }
</script>
</body>
</html>
