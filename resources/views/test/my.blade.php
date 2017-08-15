<!DOCTYPE html>
<html>
<head>
    <meta charset="{CHARSET}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.css")}}">
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/jquery-1.8.3.min.js")}}"></script>
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.js")}}"></script>
</head>
<body>
<div data-role="page" id="service-div">
    <div data-role="header" data-position="fixed" style="height: 42px">
        <h2>我的收藏</h2>
    </div>
    <div data-role="content" style="font-size: 10px">
        <ul data-role="listview" id="village-list" data-count-theme="b" data-inset="true">
            @foreach($collections as $c)
                <li>
                    <a href="/weichatshow/public/factory/detailPage?factory_id={{$c->factory_id}}">{{$c->factory_id}}</a>
                    <a href="#" class="delete" data-icon="delete"></a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script type="text/javascript">
</script>
</body>
</html>
