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
    <div data-role="content">
        <div data-role="navbar">
            <ul>
                <li><a href="#" class="ui-btn-active ui-state-persist" data-icon="star">服务响应</a></li>
            </ul>
        </div>
        <div data-role="fieldcontain">
            <label for="village">乡镇:</label>
            <select id="status" onchange="doSearch()">
                <option value="0"></option>
                <option value="1"></option>
            </select>
        </div>
        <div style="clear: both"></div>
        <div style="margin-top: 30px">
            <ul data-role="listview" id="order-list" data-count-theme="b" data-inset="true">
                <li data-role="list-divider">结果</li>
            </ul>
        </div>
        <div id="load-div" class="loading">
            <a id="load-a" href="javascript:void(0)" id="next-button" onclick="nextPage()">加载更多...</a>
        </div>
        <div id="finish-div" class="load-complete">
        </div>
    </div>
</div>

<div id="order-div" style="display: none">
    <li>
        <a href="#" onclick="changeStatus(this)" data-transition="slide">
            <span style="display: inline">
                <span id="order-code" class="md-span"></span>&nbsp;
                <span id="product-name" class="md-span grey"></span><br>
                <span id="car-code" class="md-span blue"></span>&nbsp;
                <span id="order-time" class="sm-span grey"></span>
            </span>
        </a>
    </li>
</div>

<script type="text/javascript">

    var page = -1;
    var orderCode;
    var carCode;
    var serviceName;
    var serviceTime;

    function changeStatus(obj) {
        orderCode = $(obj).find("#order-code").html();
        carCode = $(obj).find("#car-code").html();
        serviceTime = $(obj).find("#order-time").html();
        serviceName = $(obj).find("#product-name").html();
        $("#order-code-p").html(orderCode);
        $("#car-code-p").html(carCode);
        $("#service-time-p").html(serviceTime);
        $("#service-name-p").html(serviceName);
        location.href = "#confirm-div";
    }

    function doCancel() {
        location.href = "#service-div";
    }

    function doConfirm() {
        if (orderCode) {
            $.ajax({
                url: "${ctx}/service/changeStatus?orderCode=" + orderCode,
                dataType: 'json',
                success: function (response) {
                    if (response.flag) {
                        alert("服务响应成功!")
                        window.location.href = "${ctx}/service/serviceResponse?ts=" + new Date().getTime();
                    } else {
                        alert("服务确认失败，错误信息:" + response.message);
                    }
                }
            })
        }
    }

    function displayTable(response) {
        if (response.aaData && response.aaData.length > 0) {
            for (var i in response.aaData) {
                $("#order-div #order-code").html(response.aaData[i].orderCode);
                $("#order-div #product-name").html(response.aaData[i].productName);
                $("#order-div #order-time").html(getFormatDate(response.aaData[i].createTime));
                $("#order-div #car-code").html(response.aaData[i].carCode);
                var orderDiv = $("#order-div").html();
                $("#order-list").append(orderDiv);
            }
            page = response.sEcho;
        } else {
            $(window).unbind('scroll');
            $("#load-div").html("");
            $("#finish-div").html("已加载完毕，没有更多!");
        }
        $("#order-list").listview('refresh');
    }

    function nextPage() {
        var from = ++page;
        page = from;
        var orderCode = $("#order-code-input").val();
        var status = $("#status option:selected").val();
        $.ajax({
            url: "${ctx}/service/list?ts=" + new Date().getTime(),
            dataType: "json",
            data: {page: from, orderCode: orderCode, status: status},
            success: function (response) {
                displayTable(response);
            }
        })
    }

    function getFormatDate(date) {
        if (!date) {
            return "";
        } else {
            var formatDate = new Date(date);
            var year = formatDate.getFullYear();
            var month = formatDate.getMonth() + 1;
            var day = formatDate.getDate();
            var hour = formatDate.getHours();
            var minite = formatDate.getMinutes();
            var second = formatDate.getSeconds();
            return year + "-"
                + (month * 1 < 10 ? '0' + month : month) + "-"
                + (day * 1 < 10 ? '0' + day : day) + " " +
                (hour * 1 < 10 ? '0' + hour : hour) + ":" +
                (minite * 1 < 10 ? '0' + minite : minite) + ":" +
                (second * 1 < 10 ? '0' + second : second);
        }
    }

    function doSearch() {
        page = -1;
        $("#order-list li:gt(0)").remove();
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
