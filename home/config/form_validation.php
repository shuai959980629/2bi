<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    /*------------------------用户------------------------*/
	'comm_login' => array(
		array(
			'field' => 'username',
			'label' => '用户名',
			'rules' => 'required'
		),
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'required'
		)
	),
	'auth_login' => array(
		array(
			'field' => 'username',
			'label' => '用户名',
			'rules' => 'required'
		),
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'required'
		),
		array(
			'field' => 'profile',
			'label' => '个性数据',
			'rules' => 'required'
		),
	),
    'register' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required|min_length[6]|max_length[24]'
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required'
        )
    ),
    'retrieve_0' => array(
        array(
            'field' => 'step',
            'label' => '步骤',
            'rules' => 'required|integer|less_than[3]'
        ),
    ),
    'retrieve_1' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required'
        ),
    ),
    'retrieve_2' =>array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'valicode',
            'label' => '验证码',
            'rules' => 'required'
        ),
        array(
            'field' => 'password',
            'label' => '新密码',
            'rules' => 'required'
        ),
    ),
    'profile' => array(
        array(
            'field' => 'nickname',
            'label' => '用户昵称',
            'rules' => 'min_length[6]|max_length[24]'
        ),
        array(
            'field' => 'gender',
            'label' => '性别',
            'rules' => 'alpha'
        ),
        array(
            'field' => 'birthday',
            'label' => '生日',
            'rules' => 'max_length[10]'
        ),
        array(
            'field' => 'sign',
            'label' => '个性签名',
            'rules' => 'max_length[24]'
        ),
    ),
    'bind_phone' => array(
        array(
            'field' => 'phonum',
            'label' => '手机号码',
            'rules' => 'required|exact_length[11]|callback_phone_check'
        ),
        array(
            'field' => 'valicode',
            'label' => '验证码',
            'rules' => 'required|exact_length[4]'
        ),
    ),
    'homepage' => array(
        array(
            'field' => 'uid',
            'label' => '用户',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'page',
            'label' => '当前页码',
            'rules' => 'integer'
        ),
    ),
    'modifypwd' => array(
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'required'
        ),
    ),
    /*------------------------朋友------------------------*/
    'deletefriend' => array(
        array(
            'field' => 'uid',
            'label' => '用户',
            'rules' => 'required|integer'
        ),
    ),
    'device_info' => array(
			array(
					'field' => 'devuniq',
					'label' => '设备码',
					'rules' => 'required'
			),
			array(
					'field' => 'brand',
					'label' => '品牌',
					'rules' => 'required'
			),
			array(
					'field' => 'modnum',
					'label' => '型号',
					'rules' => 'required'
			),
	),
    'addblack' => array(
        array(
            'field' => 'uid',
            'label' => '用户',
            'rules' => 'required|integer'
        ),
    ),
    'delblack' => array(
        array(
            'field' => 'uid',
            'label' => '用户',
            'rules' => 'required|integer'
        ),
    ),
    'blacklist' => array(
        array(
            'field' => 'page',
            'label' => '当前页码',
            'rules' => 'integer'
        ),
    ),
    'richlist' => array(
        array(
            'field' => 'page',
            'label' => '当前页码',
            'rules' => 'integer'
        ),
        array(
            'field' => 'type',
            'label' => '排行类型',//0世界排行（默认），1好友排行
            'rules' => 'integer'
        ),
    ),
    /*------------------------宝贝------------------------*/
    'addcowry' => array(
        array(
            'field' => 'number',
            'label' => '宝贝数量',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'desc',
            'label' => '宝贝描述',
            'rules' => 'required|min_length[6]|max_length[240]'
        ),
        array(
            'field' => 'aid',
            'label' => '宝贝地址id',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'price',
            'label' => '宝贝价格',
            'rules' => 'numeric'
        ),
        array(
            'field' => 'cowimg',
            'label' => '宝贝图片路径',
            'rules' => 'required'
        ),
    ),
    'deletecowry' => array(
        array(
            'field' => 'cid',
            'label' => '宝贝ID',
            'rules' => 'required|integer'
        ),
    ),
    'detailcowry' => array(
        array(
            'field' => 'cid',
            'label' => '宝贝ID',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'uid',
            'label' => '宝贝所有者ID',
            'rules' => 'required|integer'
        ),
    ),
    'delicatecowry' => array(
        array(
            'field' => 'cid',
            'label' => '宝贝ID',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'bid',
            'label' => '哔哔ID',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'number',
            'label' => '进贡数量',
            'rules' => 'required|integer'
        ),
    ),
    'donatecowry' => array(
        array(
            'field' => 'cid',
            'label' => '宝贝ID',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'uid',
            'label' => '好友ID',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'number',
            'label' => '进贡数量',
            'rules' => 'required|integer'
        ),
    ),
    /*------------------------哔哔------------------------*/
    'bbjoinlist' => array(
        array(
            'field' => 'page',
            'label' => '当前页码',
            'rules' => 'integer'
        ),
    ),
    'historymsg' => array(
        array(
            'field' => 'page',
            'label' => '当前页码',
            'rules' => 'integer'
        ),
        array(
            'field' => 'bid',
            'label' => '哔哔ID',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'timestamp',
            'label' => '时间戳',
            'rules' => 'required|integer|exact_length[10]'
        ),
    ),

    /*------------------------公用------------------------*/
    'check_update' =>array(
        array(
            'field' => 'version',
            'label' => '客户端使用的软件版本号',
            'rules' => 'required'
        ),
        array(
            'field' => 'type',
            'label' => '客户端平台类型',
            'rules' => 'integer'
        ),
    ),

    /*------------------------订单------------------------*/
    'add_order' =>array(
        array(
            'field' => 'cid',
            'label' => '宝贝ID',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'num',
            'label' => '宝贝数量',
            'rules' => 'integer'
        ),
    ),
    'modify_order' =>array(
        array(
            'field' => 'oid',
            'label' => '订单ID',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'cid',
            'label' => '宝贝ID',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'type',
            'label' => '类型',
            'rules' => 'required|alpha'
        ),
        array(
            'field' => 'price',
            'label' => '单价',
            'rules' => 'numeric'
        ),
        array(
            'field' => 'num',
            'label' => '数量',
            'rules' => 'integer'
        ),
    ),
    'add_address' =>array(
        array(
            'field' => 'name',
            'label' => '名字',
            'rules' => 'required|max_length[24]'
        ),
        array(
            'field' => 'phone',
            'label' => '电话',
            'rules' => 'required'
        ),
        array(
            'field' => 'lat',
            'label' => '纬度',
            'rules' => 'numeric'
        ),
        array(
            'field' => 'lon',
            'label' => '经度',
            'rules' => 'numeric'
        ),
        array(
            'field' => 'address',
            'label' => '地址',
            'rules' => 'required|max_length[200]'
        ),
    ),
    'manage_order' =>array(
        array(
            'field' => 'oid',
            'label' => '订单ID',
            'rules' => 'required|integer'
        ),
    ),
    'appraise' =>array(
        array(
            'field' => 'uid',
            'label' => '商家ID',
            'rules' => 'required|integer'
        ),
    ),

);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */
