<!DOCTYPE html>
<html>
<head>
    <meta charset="{CHARSET}" name="viewport"
          content="width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.css")}}">
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/jquery-1.8.3.min.js")}}"></script>
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.js")}}"></script>
</head>
<body>
<div data-role="page" id="service-div">
    <div data-role="header" data-position="right" style="height: 42px" data-display="overlay">
        <h2>我的</h2>
        <a href="{{env('CURRENT_SERVER')}}/factory/listPage" data-ajax="false" data-icon="home" data-iconpos="notext">Menu</a>
        <a href="{{env('CURRENT_SERVER')}}/factory/my" data-ajax="false" data-icon="user" data-iconpos="notext">User</a>
    </div>
    <div data-role="content" style="font-size: 10px">
        <ul data-role="listview" id="village-list" data-count-theme="b" data-inset="true">
            @foreach($collections as $c)
                <li>
                    <a href="{{env('CURRENT_SERVER')}}/factory/detailPage?factory_id={{$c->id}}" data-ajax="false">{{$c->name}}</a>
                    <a href="{{env('CURRENT_SERVER')}}/factory/confirm?factory_id={{$c->id}}" lass="delete" data-transition="pop" data-icon="delete"></a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script type="text/javascript">
    function doRemoveConfirm(factory_id){
        $.ajax({
            url : "{{env('CURRENT_SERVER')}}/cancel/collection?factory_id=" + factory_id,
            type : 'get',
            dataType : 'json',
            success : function(response) {

            }
        })
    }
</script>
</body>
</html>
