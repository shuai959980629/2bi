   <!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->

<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

	<meta charset="utf-8" />

	<title>邻售商家管理平台</title>

	<meta content="width=device-width, initial-scale=1.0" name="viewport" />

	<meta content="" name="description" />

	<meta content="" name="author" />
    <base  href="<?php echo $url_prefix;?>"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->

	<link href="media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

	<link href="media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

	<link href="media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

	<link href="media/css/style-metro.css" rel="stylesheet" type="text/css"/>

	<link href="media/css/style.css" rel="stylesheet" type="text/css"/>

	<link href="media/css/style-responsive.css" rel="stylesheet" type="text/css"/>

	<link href="media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>

	<link href="media/css/uniform.default.css" rel="stylesheet" type="text/css"/>

	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- BEGIN PAGE LEVEL STYLES -->

	<link rel="stylesheet" type="text/css" href="media/css/bootstrap-tree.css" />

	<!-- END PAGE LEVEL STYLES -->

	<link rel="shortcut icon" href="media/image/favicon.ico" />

</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="page-header-fixed">

	<!-- BEGIN HEADER -->

	<div class="header navbar navbar-inverse navbar-fixed-top">

		<!-- BEGIN TOP NAVIGATION BAR -->

		<div class="navbar-inner">

			<div class="container-fluid">

				<a class="brand" href="#"><img src="media/image/logo.png" alt="logo" /></a>
				<ul class="nav pull-right">
					<!-- BEGIN USER LOGIN DROPDOWN -->

			  <li class="dropdown user">

						<a href="#" class="dropdown-toggle" data-toggle="dropdown">

						<span class="username">东大店</span>

						<i class="icon-angle-down"></i>

						</a>

						<ul class="dropdown-menu">
							<li><a href="#">东大店</a></li>
                            <li><a href="#">东大店</a></li>
						</ul>

					</li>

					<!-- END USER LOGIN DROPDOWN -->

				</ul>

				<!-- END TOP NAVIGATION MENU --> 

			</div>

		</div>

		<!-- END TOP NAVIGATION BAR -->

	</div>

	<!-- END HEADER -->

	<!-- BEGIN CONTAINER -->   

	<div class="page-container row-fluid">

		<!-- 左边开始 -->

		<div class="page-sidebar nav-collapse collapse">

			<!-- BEGIN SIDEBAR MENU -->        

			<ul class="page-sidebar-menu">

				<li>

					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

					<div class="sidebar-toggler hidden-phone"></div>

					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

				</li>
                <li class="user">
                	<a href="javascript:;" class="remove"><i class="icon-user"></i><span class="title">假如我不是静妃<em>注销登录</em></span></a>
                </li>
                <!--商品管理-->
				<li class="">
					<a href="javascript:;">
					<i class="icon-bookmark-empty "></i> 
					<span class="title">商品管理</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li ><a href="#">商品审核</a></li>
					</ul>

				</li>
                
                <!--商户管理-->
				<li class="active ">

					<a href="javascript:;">

					<i class="icon-user"></i> 

					<span class="title">商户管理</span>

					<span class="selected"></span>

					<span class="arrow open"></span>

					</a>

					<ul class="sub-menu">
						<li >
							<a href="#">商户查询</a>
						</li>
					</ul>

				</li>
                
                <!--APP管理-->
				<li class="">

					<a href="javascript:;">

					<i class="icon-gift"></i> 

					<span class="title">app管理</span>

					<span class="arrow "></span>

					</a>

					<ul class="sub-menu">
						<li >
							<a href="#">版本管理</a>
						</li>
					</ul>

				</li>


			</ul>

			<!-- END SIDEBAR MENU -->

		</div>

		<!-- 左边结束 -->

		<!-- BEGIN PAGE -->

		<div class="page-content">

			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<div id="portlet-config" class="modal hide">

				<div class="modal-header">

					<button data-dismiss="modal" class="close" type="button"></button>

					<h3>portlet Settings</h3>

				</div>

				<div class="modal-body">

					<p>Here will be a configuration form</p>

				</div>

			</div>

			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<!-- 右边开始-->

			<div class="container-fluid" >

				<!--右边标题导航开始-->
				<div class="row-fluid">

					<div class="span12">

						<!-- BEGIN PAGE TITLE & BREADCRUMB-->

						<h3 class="page-title">
                           歌曲管理<small>Song management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="#">东大店</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li>

								<a href="#">歌曲管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="#">列表</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中间内容开始-->
                <div class="content" >
                	<!--商品详情开始-->
                	<div class="product clearfix portlet box grey">
                    	<table>
                        	<tbody>
                            	<tr class="title">
                                	<td class="describe">宝贝描述</td>
                                    <td class="site">宝贝地址</td>
                                    <td>价格</td>
                                    <td>库存</td>
                                    <td class="handle">操作</td>
                                </tr>
                                <tr>
                                	<td class="describe">糖糖的糖果屋里装满了满满的糖果，各种各样的棒棒糖啊什么什么来着的糖糖的糖果屋里装满了满满的糖果，各种各样的棒棒糖啊什么什么来着的</td>
                                    <td class="site">四川省成都市青羊区什么什么来着的来着的来着</td>
                                    <td>895</td>
                                    <td>9999</td>
                                    <td class="handle"><a class="btn green" href="#">进入商户</a><a class="btn grey" href="#">删除</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--商品详情结束-->
                    <!--点击商品详情删除开始-->
                    	<div id="show_div">
                        	<p class="alone">确定是否删除该宝贝的信息</p>
                            <p><a class="btn green" href="#">确认</a><a class="btn grey" href="#">取消</a></p>
                        </div>
                    	<div id="pop_up"></div>
                    <!--点击商品详情删除结束-->
                </div>
                <!--右边中间内容结束-->
			</div>

			<!-- 右边结束--> 

		</div>

		<!-- END PAGE -->    

	</div>

	<!-- END CONTAINER -->

	<!-- BEGIN FOOTER -->

	<div class="footer">

		<div class="footer-inner">

			2013 &copy; Metronic by keenthemes.

		</div>

		<div class="footer-tools">

			<span class="go-top">

			<i class="icon-angle-up"></i>

			</span>

		</div>

	</div>

	<!-- END FOOTER -->

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

	<!-- BEGIN CORE PLUGINS -->

	<script src="media/js/jquery-1.10.1.min.js" type="text/javascript"></script>

	<script src="media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

	<script src="media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      

	<script src="media/js/bootstrap.min.js" type="text/javascript"></script>

	<!--[if lt IE 9]>

	<script src="media/js/excanvas.min.js"></script>

	<script src="media/js/respond.min.js"></script>  

	<![endif]-->   

	<script src="media/js/jquery.slimscroll.min.js" type="text/javascript"></script>

	<script src="media/js/jquery.blockui.min.js" type="text/javascript"></script>  

	<script src="media/js/jquery.cookie.min.js" type="text/javascript"></script>

	<script src="media/js/jquery.uniform.min.js" type="text/javascript" ></script>

	<!-- END CORE PLUGINS -->

	<!-- BEGIN PAGE LEVEL PLUGINS -->

	<script src="media/js/bootstrap-tree.js"></script>

	<!-- END PAGE LEVEL PLUGINS -->

	<!-- BEGIN PAGE LEVEL SCRIPTS -->

	<script src="media/js/app.js"></script>

	<script src="media/js/ui-tree.js"></script>     

	<!-- END PAGE LEVEL SCRIPTS -->

	<script>

		jQuery(document).ready(function() {       

		   // initiate layout and plugins

		   App.init();

		   UITree.init();

		});

	</script>

	<!-- END JAVASCRIPTS -->

<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script></body>

<!-- END BODY -->

</html>