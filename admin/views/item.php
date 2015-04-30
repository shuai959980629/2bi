<div class="page-sidebar nav-collapse collapse">

	<!-- BEGIN SIDEBAR MENU -->        

	<ul class="page-sidebar-menu">

		<li>

			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

			<div class="sidebar-toggler hidden-phone"></div>

			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

		</li>
        <!--后台首页icon-home-->
        <li <?php if($curentID===0 && $current==='home'){?> class="active "<?php }?>>
            <a href="javascript:void(0);" class="remove">
    			<i class="icon-user"></i> 
    			<span class="title"><?php echo $user['realname'];?></span>
                <span class="selected"></span>
    			<span class="arrow open"></span>
			</a>
            <ul class="sub-menu">
				<li><a href="<?php echo $url_prefix;?>home/passwd">修改密码</a></li>
                <li ><a href="<?php echo $url_prefix;?>user/logout">注销登录</a></li>
			</ul>
        </li>
        
        <?php foreach($menu as $key =>$vals){?>
            <li <?php if($curentID==$vals['id_right']){?> class="active "<?php }?> >
    			<a href="javascript:void(0);" class="remove">
        			<i class="<?php echo $vals['icon'];?>"></i> 
        			<span class="title"><?php echo $vals['name'];?></span>
                    <span class="selected"></span>
        			<span class="arrow open"></span>
    			</a>
    			<ul class="sub-menu">
                   <?php foreach($vals['children'] as $item => $val){?>
    				<li><a href="<?php echo $url_prefix.$val['menu_url'];?>"><?php echo $val['name'];?></a></li>
                  <?php }?>  
    			</ul>
    		</li>
        <?php }?>
        
      <?php if(intval($user['id_profile'])===1){?>
         <li <?php if($curentID==='S01' && $current==='super'){?> class="active "<?php }?> >
    			<a href="javascript:void(0);" class="remove">
        			<i class="icon-super"></i> 
        			<span class="title">邻售管理</span>
                    <span class="selected"></span>
        			<span class="arrow open"></span>
    			</a>
    			<ul class="sub-menu">
                <li><a href="<?php echo $url_prefix;?>super">Super管理</a></li>
                   <li><a href="<?php echo $url_prefix;?>super/adminMysql">数据库管理</a></li>
               </ul>
    		</li>
      <?php }?>
	</ul>

	<!-- END SIDEBAR MENU -->
</div>
