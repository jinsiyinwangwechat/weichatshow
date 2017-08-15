<!DOCTYPE html>
<html>
<head>
    <meta charset="{CHARSET}" name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.css")}}">
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/jquery-1.8.3.min.js")}}"></script>
    <script type="text/javascript" src="{{URL::asset("/assets/jquery/mobile/jquery.mobile-1.4.5.js")}}"></script>
</head>
<body>
<div data-role="page" id="service-div">
    <div data-role="header" data-position="fixed" style="height: 42px">
        <h2>工厂列表</h2>
    </div>
    <div data-role="content" style="font-size: 10px">
        <div data-role="fieldcontain">
            <label for="village" style="font-size: 10px">乡镇:</label>
            <select id="village-input" onchange="doSearch()" style="font-size: 10px">
                <option value="">请选择...</option>
                @foreach($village as $v)
                    <option value="{{$v}}" style="font-size: 10px">{{$v}}</option>
                @endforeach
            </select>
        </div>
        <div data-role="fieldcontain">
            <input id="order-input" type="checkbox" onchange="doSearch()"/>
            <label for="order-input">按收藏数升序</label>
        </div>
        <div style="clear: both"></div>
        <div>
            <ul data-role="listview" id="village-list" data-count-theme="b" data-inset="true">
                <li data-role="list-divider">结果</li>
            </ul>
        </div>
        <div id="load-div" class="loading" style="text-align: center">
            <a id="load-a" href="javascript:void(0)" id="next-button" onclick="nextPage()">加载更多...</a>
        </div>
        <div id="finish-div" class="load-complete" style="text-align: center">
        </div>
    </div>
</div>

<div id="village-div" style="display: none">
    <li>
        <a href="#" data-ajax="false">
            <span style="display: inline;font-size: 10px">
                <span id="name" class="md-span" style="font-size: 12px"></span><br/>
                <span id="address" class="md-span" style="white-space: pre-wrap"></span><br/>
                <span id="contact1" class="md-span" style="float: left"></span>
                <span id="telephone1" class="md-span" style="float: right"></span><br/>
                <span id="town" class="md-span"></span><br/>
                <span id="village" class="md-span"></span>
            </span>
        </a>
    </li>
</div>

<script type="text/javascript">

    var page = 0;

    function displayTable(response) {
        if (response.code==0 && response.info && response.info.length > 0) {
            for (var i in response.info) {
                $("#village-div a").attr("href", "/weichatshow/public/factory/detailPage?factory_id=" + response.info[i].id);
                $("#village-div #name").html(response.info[i].name);
                $("#village-div #address").html(response.info[i].address);
                $("#village-div #contact1").html(response.info[i].connect1);
                $("#village-div #telephone1").html(response.info[i].telephone);
                $("#village-div #town").html(response.info[i].town);
                $("#village-div #village").html(response.info[i].village);

                var orderDiv = $("#village-div").html();
                $("#village-list").append(orderDiv);
            }
        } else {
            $(window).unbind('scroll');
            $("#load-div").html("");
            $("#finish-div").html("已加载完毕，没有更多!");
        }
        $("#village-list").listview('refresh');
    }

    function nextPage() {

        var from = ++page;
        page = from;
        var village = $("#village-input option:selected").val();
        var orderFlag = $("#order-input").attr("checked");
        var orderBy = (!!orderFlag)?'desc':'asc';
        $.ajax({
            url: "/weichatshow/public/factory/list?ts=" + new Date().getTime(),
            dataType: "json",
            data: {page: from, town: village, order_by: orderBy},
            success: function (response) {
                displayTable(response);
            }
        })
    }

    function doSearch() {
        page = -1;
        $("#village-list li:gt(0)").remove();
        nextPage();
    }

    function scrollPage() {
        $(window).scroll(function () {
            var scrollTop = $(this).scrollTop();
            var scrollHeight = $(document).height();
            var windowHeight = $(this).height();

            if (scrollTop + windowHeight >= scrollHeight) {
                if (page == 10) {
                    $(window).unbind('scroll');
                    return false;
                } else {
                    nextPage();
                }
            }
        });
    }

    $(function () {
        $(window).unbind('scroll');
        scrollPage();
    });

</script>
</body>
</html>
