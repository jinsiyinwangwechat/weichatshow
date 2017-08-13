<!DOCTYPE html>
<html>
	<head>
		<meta charset="{CHARSET}">
		<title></title>
	</head>
	<body>
		<h1>企业信息测试版(前端不是这样，这是为测试)</h1>
		<h2>尊敬的用户:  {{$userName}}</h2>

		<extend name="Public/base"/>


		<block name="main">
    <span style="float: right;margin-right:100px">
        <button class="btn btn-default" type="button" onclick="print()">打印表格</button>
    </span>
			<div class="container" id="detail-info">
				<form action="{:U('Map/add')}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data"
					  method="post">
					<legend class="text-center" style="padding-bottom: 10px;margin-top: 20px">
						生产商备案信息表

					</legend>
					<div class="col-md-12" style="padding-left: 0px">
						<div style="width:15%; float: left">
							<h4>存档条形码</h4>
						</div>
						<div style="width:35%; float: left">
							<img src="data:image/png;base64,  {$barPic} ">
						</div>
						<div style="width:15%; float: left">
							<h4>登记编号：</h4>
						</div>
						<div style="width:35%; float: left">
							<h4>{{$id}}</h4>
						</div>
					</div>
					<table class="table table-bordered">
						<tbody>
						<tr>
							<td width="15%">第一联系人</td>
							<td width="18%">{{$connect1}}</td>
							<td width="12%">联系电话</td>
							<td width="20%">{{$telephone}}</td>
							<td width="8%">微信1</td>
							<td width="27%">{{$weichat1}}</td>
						</tr>
						<tr>
							<td>第二联系人</td>
							<td>{{$connect2}}</td>
							<td>联系电话</td>
							<td>{{$telephone2}}</td>
							<td>微信1</td>
							<td>{{$weichat2}}</td>
						</tr>
						<tr>
							<td>所在乡镇</td>
							<td>{{$town}}</td>
							<td>所在村庄</td>
							<td>{{$village}}</td>
							<td>QQ</td>
							<td>{{$qq1}}</td>
						</tr>
						<tr>
							<td>地址描述</td>
							<td colspan="5">{{$address}}</td>
						</tr>
						<tr>
							<td>生产商名称</td>
							<td colspan="5">{{$name}}</td>
						</tr>

						@foreach ($classify as $vo)
							<tr>
								<td>行业归类</td>
								<td colspan="2">{{$vo}}</td>
								<td>生产设备名称（台、套）A</td>
								<td colspan="2"></td>
							</tr>
						@endforeach

						<tr>
							<td height="100px">企业签字或盖章</td>
							<td colspan="2" style="vertical-align: bottom; text-align: right">
								年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日
							</td>
							<td>经办人章</td>
							<td colspan="2" style="vertical-align: bottom; text-align: right">
								年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日
							</td>
						</tr>
						</tbody>
					</table>
					<div class="col-md-12" style="padding-left: 0px">
						<div style="float: left; width: 33%">
							<h5>微信平台联系电话:<span></span></h5>
						</div>
						<div style="float: left; width: 33%">
							<h5>客服微信二维码：<span></span></h5>
						</div>
						<div style="float: left; width: 33%">
							<h5>平台微信二维码：<span></span></h5>
						</div>
					</div>
				</form>
			</div>


		</block>
	</body>
</html>
