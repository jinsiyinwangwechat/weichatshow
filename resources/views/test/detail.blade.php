<!DOCTYPE html>
<html>
<head>
    <meta charset="{CHARSET}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.css")}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("/css/swang.css")}}">
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/jquery-1.8.3.min.js")}}"></script>
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.js")}}"></script>
</head>
<body>
<div data-role="page" id="service-div">
    <div data-role="header" data-position="fixed" style="height: 42px">
        <h1>工厂详情</h1>
    </div>
    <input type="hidden" id="factory-id-input" value="{{$factoryId}}"/>
    <div data-role="content" style="font-size: 10px">
        <div id="preview-div" class="info-div">
            <div style="width: 30%;float:left">
                <div id="pic" style="padding: 2px; border: solid 1px #EEEEEE"></div>
            </div>
            <div style="width: 65%;float: left;margin-left: 10px">
                <div id="name" style="font-size: 13px;font-weight: bold">
                </div>
                <div style="margin-top: 5px">
                    地址：<span id="address"></span>
                </div>
                <div style="margin-top: 5px">
                    电话：<span id="telephone"></span>
                </div>
            </div>
        </div>
        <div id="discount-div"></div>
        <div id="introduction-div"></div>
        <div id="friendship-div"></div>
    </div>
    <div data-role="footer" data-position="fixed">
        <a style="width: 45px" href="#" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-phone">打电话</a>
        <a style="width: 45px"  href="#" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-right ui-icon-navigation">去这里</a>
        <a style="width: 45px"  href="#" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-right ui-icon-star">收藏</a>
    </div>
</div>

<script type="text/javascript">

    function loadDetail() {
        var factoryId = $("#factory-id-input").val();
        if(!!factoryId) {
            $.ajax({
                url : '/weichatshow/public/factory/detail?factory_id=' + factoryId,
                type : 'get',
                dataType : 'json',
                success : function(response) {
                    if(response && response.code==0) {
                        displayDetail(response.info);
                    } else {
                        alert("没有对应工厂记录")
                    }
                }
            })
        } else {
            alert('没有选择工厂')
        }
    }

    function displayDetail(factory) {
        $("#name").html(factory.name);
        $("#address").html(factory.address);
        $("#telephone").html(factory.telephone);
        var pictures = factory.pictures;
        if(!!pictures && pictures.length>0) {
            var firstPic = pictures[0].url;
            $("#pic").html("<img width='100%' src='/weichatshow/public/pictures"+ firstPic +"'/>")
        }
    }

    $(function(){
        loadDetail();
    })
</script>
</body>
</html>
