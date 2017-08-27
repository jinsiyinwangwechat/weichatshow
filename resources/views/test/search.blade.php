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
        <h2>主页</h2>
        <a href="{{env('CURRENT_SERVER')}}/factory/listPage" data-ajax="false" data-icon="home" data-iconpos="notext">Menu</a>
        <a href="{{env('CURRENT_SERVER')}}/factory/my" data-ajax="false" data-icon="user" data-iconpos="notext">User</a>
    </div>
    <div data-role="content" style="font-size: 10px;padding-top:0px">
        <div data-role="navbar" style="margin-top: 10px">
            <ul>
                <li><a href="/factory/listPage" data-theme="a">按乡镇</a></li>
                <li><a href="#" data-theme="a" class="ui-btn-active ui-state-persist">按小类</a>
                </li>
            </ul>
        </div>
        <div data-role="fieldcontain">
            <label for="class-input" style="font-size: 10px">小类:</label>
            <input id="class-input"/>
        </div>

        <div data-role="fieldcontain">
            <input type="button" onclick="search()" value="检索"/>
        </div>

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
        if (response.code == 0 && response.info && response.info.length > 0) {
            for (var i in response.info) {
                $("#village-div a").attr("href", "/factory/detailPage?factory_id=" + response.info[i].id);
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
        var classify = $("#class-input").val();
        $.ajax({
            url: "/factory/search?ts=" + new Date().getTime(),
            dataType: "json",
            data: {page: from, classify: classify},
            success: function (response) {
                displayTable(response);
            }
        })
    }

    function search() {
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
