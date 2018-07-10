<?php
	// Hàm thiết lập là đã đăng nhập
	function set_logged($id_member, $ID_UG, $name,$balance){
			// setcookie("ss_user_token", "Logged", time() + 10, "/");
	    session_set('ss_user_token', array(
	        'id_member' => $id_member,
	        'ID_UG'		=> $ID_UG,
	        'name'		=> $name,
	        'balance'	=> $balance
	    ));
	}
	function is_key(){
        // Gán hàm addslashes để chống sql injection
        $search = addslashes($_POST['search']);
        set_search($search);
        echo $search;
    }
	//Ham thiet lap da search
	function set_search($search){
	    session_set('ss_search',$search);

	}

	//ham kiem tra search
	function is_search(){
	    $search = session_get('ss_search');
	    return $search;
	}

	// Hàm thiết lập xóa search
	function set_searchout(){
	    session_delete('ss_search');
	}

	// Hàm thiết lập đăng xuất
	function set_logout(){
	    session_delete('ss_user_token');
	}

	// Hàm kiểm tra trạng thái người dùng đã đăng nhập chưa
	function is_logged(){
	    $user = session_get('ss_user_token');
	    return $user;
	}

	// Hàm kiểm tra có phải là admin hay không
	function is_admin(){
	    $user  = is_logged();
	    if (!empty($user['ID_UG']) && (($user['ID_UG'] == '1') or $user['ID_UG'] == '2')){
	        return true;
	    }
	    return false;
	}

	// Hàm kiểm tra có phải là student hay không
	function is_student(){
	    $user  = is_logged();
	    if (!empty($user['ID_UG']) && ($user['ID_UG'] == '5')){
	        return true;
	    }
	    return false;
	}

	// Hàm kiểm tra có phải là Deposit staff hay không
	function is_deposit(){
	    $user  = is_logged();
	    if (!empty($user['ID_UG']) && ($user['ID_UG'] == '3')){
	        return true;
	    }
	    return false;
	}

	// Hàm kiểm tra có phải là service staff hay không
	function is_service(){
	    $user  = is_logged();
	    if (!empty($user['ID_UG']) && ($user['ID_UG'] == '4')){
	        return true;
	    }
	    return false;
	}

	// Lấy name người dùng hiện tại
	function get_current_name(){
	    $user  = is_logged();
	    return isset($user['name']) ? $user['name'] : '';
	}

	// Lấy id người dùng hiện tại đang đăng nhập
	function get_current_id(){
	    $user  = is_logged();
	    return isset($user['id_member']) ? $user['id_member'] : '';
	}

	// Lấy user group người dùng hiện tại
	function get_current_level(){
	    $user  = is_logged();
	    return isset($user['ID_UG']) ? $user['ID_UG'] : '';
	}

	// Lấy balance người dùng hiện tại
	function get_current_balance(){
	    $user  = is_logged();
	    return isset($user['balance']) ? $user['balance'] : '';
	}
	// Hàm kiểm tra là supper admin
	function is_supper_admin(){
	    $user = is_logged();
	    if (!empty($user['ID_UG']) && $user['ID_UG'] == '1'){
	        return true;
	    }
	    false;
	}
?>