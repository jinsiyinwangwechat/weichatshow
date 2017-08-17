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
<div data-role="page" id="service-div">

    <div data-role="header" data-position="right" style="height: 42px" data-display="overlay">
        <h2>工厂详情</h2>
        <a href="{{env('CURRENT_SERVER')}}/factory/listPage" data-icon="home" data-iconpos="notext">Menu</a>
        <a href="{{env('CURRENT_SERVER')}}/factory/my" data-icon="user" data-iconpos="notext">User</a>
    </div>
    <input type="hidden" id="factory-id-input" value="{{$factoryId}}"/>
    <div data-role="content" style="font-size: 10px;">
        <div id="preview-div" class="info-div">
            <div>
                <h3 class="ui-bar ui-bar-a ui-corner-all" style="margin-top: 0px">基本信息</h3>
                <div style="width: 40%;float:left">
                    <div id="pic" style="padding: 2px; border: solid 1px #EEEEEE"></div>
                </div>
                <div style="width: 60%;float: left;">
                    <table class="info-table" style="padding-left: 10px;">
                        <tr>
                            <td colspan="2">
                                <div id="name" style="font-size: 13px;font-weight: bold"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span id="town"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span id="contact"></span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="clear: both"></div>
                <table class="info-table" style="margin-top: 5px;">
                    <tr>
                        <td style="vertical-align: top" width="36px">地址：</td>
                        <td><span id="address"></span></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top">电话：</td>
                        <td>
                            <span id="telephone"></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top">微信：</td>
                        <td>
                            <span id="weixin"></span>
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <h3 class="ui-bar ui-bar-a ui-corner-all">位置信息</h3>
                <table class="info-table">
                    <tr>
                        <td style="vertical-align: top">编号：</td>
                        <td>
                            <span id="code"></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top">采集时间：</td>
                        <td>
                            <span id="collect_time"></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top">小类：</td>
                        <td>
                            <span id="small_classify"></span>
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <h3 class="ui-bar ui-bar-a ui-corner-all">友情链接</h3>
                <table class="info-table">
                <tr>
                    <td>
                        <span id="friend_link"></span>
                    </td>
                </tr>
                </table>
            </div>
            <div>
                <h3 class="ui-bar ui-bar-a ui-corner-all">实景照片</h3>
                <div id="image_div"></div>
            </div>
        </div>
    </div>
    <div data-role="footer" data-position="fixed">
        <div class="ui-grid-b">
            <div class="ui-block-a">
                <a href="#" id="make-phone" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-phone">打电话</a>
            </div>
            <div class="ui-block-b" style="text-align: center">
                <a href="http://m.amap.com/navi/?start=115.524137,38.242731&dest=115.519545,38.228472&destName=刘成测试地图选点&key=175cd59f097bc8498dd2e4e8f3868cd2" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-navigation">去这里</a>
            </div>
            <div class="ui-block-c" style="text-align: right">
                <a href="javascript:collection()" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-star">收藏&nbsp;&nbsp;&nbsp;</a>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">

    function collection() {
        var factoryId = $("#factory-id-input").val();
        $.ajax({
            url : '/do/collection?factory_id=' + factoryId,
            type : 'get',
            dataType : 'json',
            success : function(response) {
                if(response && response.code==0) {
                    alert("添加收藏成功")
                } else {
                    alert("添加收藏失败")
                }
            }
        })
    }
    function loadDetail() {
        var factoryId = $("#factory-id-input").val();
        if(!!factoryId) {
            $.ajax({
                url : '/factory/detail?factory_id=' + factoryId,
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
        $("#contact").html(factory.connect1 + ((!!factory.connect2)?"&nbsp;&nbsp;" + factory.connect2:""))
        $("#telephone").html(factory.telephone + ((!!factory.telephone2)?"<br/>" + factory.telephone2:""));
        $("#make-phone").attr("href", "tel:" + factory.telephone);
        $("#weixin").html(factory.weichat1);

        $("#code").html(factory.id);
        $("#town").html(factory.town + "&nbsp;&nbsp;" + factory.village);
        $("#collect_time").html(factory.createtime);

        var links = factory.friendLink;
        if(!!links && links.length>0) {
            for(var i in links) {
                $("#friend_link").append("<a data-ajax='false' href='{{env('CURRENT_SERVER')}}/factory/detailPage?factory_id=" + links[i].id + "'>"+ links[i].name +"</a>")
            }
        } else {
            $("#friend_link").html("暂无");
        }

        var classifys = factory.classify;
        if(!!classifys && classifys.length>0) {
            for(var i in classifys) {
                $("#small_classify").append("<span class='tag'>" + classifys[i].small_classify + "</span>&nbsp;&nbsp;");
            }
        } else {
            $("#small_classify").html("暂无");
        }

        var pictures = factory.pictures;
        if(!!pictures && pictures.length>0) {
            var firstPic = pictures[0].url;
            $("#pic").html("<a href='#pictures'><img width='100%' src='{{env('REMOTE_PIC_SERVER')}}" + firstPic +"'/></a>")
            for(var i in pictures) {
                $("#image_div").append("<a href='#'  style='width:45%;padding: 2px; border: solid 1px #EEEEEE;float:left'><img width='100%' src='{{env('REMOTE_PIC_SERVER') }}" + pictures[i].url +"'/></a>");
            }
        } else {
            $("#pic").html("<a href='#pictures'><img width='100%' src='{{env('PIC_SERVER')}}/no_picture.jpg'/></a>")
            $("#image_div").html("暂无");
        }


    }

    $(function(){
        loadDetail();
    })

</script>
</body>
</html>
