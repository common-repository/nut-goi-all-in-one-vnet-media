<?php
/* 
Plugin Name: 	Nút gọi All In One - Vnet Media
Plugin URI: 	https://vnetmedia.com
Description: 	Tạo các nút gọi, nút chat Zalo, nút Chat messenger, nút để lại thông tin để tư vấn, nút chỉ đường. Trình bày các nút đẹp mắt ở góc phải dưới màn hình, ẩn các nút, khi bấm vào mới hiện ra. Tạo kênh liên hệ nhanh chóng và tiện lợi để quảng cáo web hiệu quả.
Tags: 			Nút gọi, nút call wordpress, call button, Vnet Media, VnetMedia nút gọi, call button , contact all in one
Author: 		Nguy Nhu An - Vnet Media
Author URI: 	https://vnetmedia.vn/
Version: 		1.0
License: 		GPLv3
Text Domain:    vnetmedia.vn
*/
	add_action('admin_menu', 'vnetmedia_adminPageConfig');
	
	// TẠO 1 TRANG VÀ MENU TRONG ADMIN DẪN ĐẾN TRANG ĐÓ
	if (!function_exists('vnetmedia_adminPageConfig')) { 
		function vnetmedia_adminPageConfig(){
				add_menu_page( 'Buttons Set up', 'Vnet Media All in One Button', 'manage_options', 'vnetmedia-click-to-action', 'vnetmedia_contentOfPageConfig' );
		}
	}
	// NỘI DUNG TRANG ĐÓ
	if (!function_exists('vnetmedia_contentOfPageConfig')) { 
		function vnetmedia_contentOfPageConfig() {
		?>
		<div class="wrap">
		<h1>vnetmedia Click to Action Setting</h1>

		<form method="post" action="options.php">
			<?php settings_fields( 'plugin_options' ); ?>
			<?php do_settings_sections( 'plugin_options' ); ?>
			<h2>Ẩn các chữ chú thích kế bên nút hay không?</h2>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Ẩn chữ chú thích kế bên nút</th>
				<td><input type="checkbox" name="hienchuthich" <?php if(get_option('hienchuthich') != "" ) echo 'checked'; ?> value="1" /></td>
				</tr>
			</table>
			<hr />
			<h2>Thiết lập nút gọi</h2>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Số điện thoại</th>
				<td><input type="text" name="phoneNumbervnetmedia" value="<?php echo esc_attr( get_option('phoneNumbervnetmedia') ); ?>" /></td>
				</tr>
				<tr valign="top">
				<th scope="row">Chữ hiện ra trên nút gọi</th>
				<td><input type="text" name="textOnButtonvnetmedia" value="<?php echo esc_attr( get_option('textOnButtonvnetmedia') ); ?>" /></td>
				</tr>
			</table>
			<hr />
			<h2>Thiết lập TawkTo</h2>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Tawkto Code</th>
				<td><textarea name="tawktocodevnetmedia"><?php echo esc_attr( get_option('tawktocodevnetmedia') ); ?></textarea></td>
				</tr>
			</table>
			<hr />
			<h2>Thiết lập Messenger</h2>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Page ID</th>
				<td><input type="text" name="fanpageIDvnetmedia" value="<?php echo esc_attr( get_option('fanpageIDvnetmedia') ); ?>" /></td>
				</tr>
			</table>
			<hr />
			<h2>Thiết lập Zalo</h2>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Số điện thoại Zalo</th>
				<td><input type="text" name="zaloPhonevnetmedia" value="<?php echo esc_attr( get_option('zaloPhonevnetmedia') ); ?>" /></td>
				</tr>
			</table>
			<hr />
			<h2>Thiết lập chỉ đường</h2>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Link Google Map</th>
				<td><input type="text" name="googlemap" value="<?php echo esc_attr( get_option('googlemap') ); ?>" /></td>
				</tr>
			</table>
			<hr />
			<h2>Để lại thông tin để tư vấn</h2>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Shortcode Contact Form 7</th>
				<td><input type="text" name="contactFormvnetmedia" value="<?php echo esc_attr( get_option('contactFormvnetmedia') ); ?>" /></td>
				</tr>
			</table>
			<?php submit_button(); ?>

		</form>
		</div>
		<?php } 
	}
	// XỬ LÝ CÁC BIẾN POS, CHO VÀO BẢNG WP-OPTIONS TRONG DATABASE VÀ BAY LẠI TRANG ĐÓ
	add_action('admin_init', 'vnetmedia_plugin_admin_init');
	if (!function_exists('vnetmedia_plugin_admin_init')) { 
		function vnetmedia_plugin_admin_init(){
			register_setting( 'plugin_options', 'phoneNumbervnetmedia', 'vnetmedia_only_number_validate' );
			register_setting( 'plugin_options', 'textOnButtonvnetmedia');
			register_setting( 'plugin_options', 'tawktocodevnetmedia');
			register_setting( 'plugin_options', 'fanpageIDvnetmedia');
			register_setting( 'plugin_options', 'contactFormvnetmedia');
			register_setting( 'plugin_options', 'googlemap');
			register_setting( 'plugin_options', 'hienchuthich');
			register_setting( 'plugin_options', 'zaloPhonevnetmedia', 'vnetmedia_only_number_validate' );
		}
	}
	// validate our options
	if (!function_exists('vnetmedia_only_number_validate')) { 
		function vnetmedia_only_number_validate($input) {
			if( !preg_match( '/[^a-zA-Z]/', $input ) ){ // CHỈ CHO PHÉP LÀ CON SỐ
				add_settings_error(
					'plugin_options',
					esc_attr( 'plugin_options' ), //becomes part of id attribute of error message
					__( 'Number must be a positive integer', 'wordpress' ), //default text zone
					'error'
				);
				$input = get_option( 'plugin_options' ); //keep old value
			}
		
			return $input;
			
		}
	}
	if (!function_exists('vnetmedia_only_text_validate')) { 
		// validate our options
		function vnetmedia_only_text_validate($input) {
			if( !preg_match( '/[^0-9]/', $input ) ){ // CHỈ CHO PHÉP LÀ CHỮ
				add_settings_error(
					'plugin_options',
					esc_attr( 'plugin_options' ), //becomes part of id attribute of error message
					__( 'Number must be a positive integer', 'wordpress' ), //default text zone
					'error'
				);
				$input = get_option( 'plugin_options' ); //keep old value
			}
		
			return $input;
			
		}
	}
	// SHOW RA TRANG WEB Ở NGOÀI
	add_action('template_redirect', 'vnetmedia_showRaNutDienthoai'); // template_redirect nghĩa la chỉ show ra trong template, ko show trong admin
	if (!function_exists('vnetmedia_showRaNutDienthoai')) { 
		function vnetmedia_showRaNutDienthoai(){
			// Thêm CSS vào Header Web
			wp_register_style( 'callNowvnetmedia',  plugin_dir_url( __FILE__ ) . 'css/callNow.css' );
			wp_enqueue_style( 'callNowvnetmedia' );
			add_action('wp_footer', 'vnetmedia_footerContent');
		}
	}
	if (!function_exists('vnetmedia_footerContent')) { 
		function vnetmedia_footerContent() {
			if(get_option('phoneNumbervnetmedia') != "") {
				echo '<div onclick="window.location.href= \'tel:'.esc_attr( get_option('phoneNumbervnetmedia') ).'\'" class="hotline-phone-ring-wrap">
					<div class="hotline-phone-ring">
					<div class="hotline-phone-ring-circle"></div>
					<div class="hotline-phone-ring-circle-fill"></div>
					<div class="hotline-phone-ring-img-circle">
					<a href="tel:'.esc_attr( get_option('phoneNumbervnetmedia') ).'" class="pps-btn-img">
						<img src="'.plugin_dir_url( __FILE__ ) .'phone.png" alt="Gọi điện thoại" width="50">
					</a>
					</div>
				</div>
				<a href="tel:'.esc_attr( get_option('phoneNumbervnetmedia') ).'">
				<div class="hotline-bar">
						<a href="tel:'.esc_attr( get_option('phoneNumbervnetmedia') ).'">
						<span class="text-hotline">'.esc_attr( get_option('textOnButtonvnetmedia') ).'</span>
						</a>
				</div>
				</a>
			</div>';
			}
			
			//echo esc_attr( get_option('new_option_name') );
		}
	}
	/** SHOW TAWKTO **/
	add_action('template_redirect', 'vnetmedia_showRaTawkTo'); 
	if (!function_exists('vnetmedia_showRaTawkTo')) { 
		function vnetmedia_showRaTawkTo(){
			add_action('wp_footer', 'vnetmedia_tawktoFooter');
		}
	}
	if (!function_exists('vnetmedia_tawktoFooter')) { 
		function vnetmedia_tawktoFooter() {
			echo wp_specialchars_decode( get_option('tawktocodevnetmedia') );
		}
	}
	/** SHOW RA CAC NUT **/
	add_action('template_redirect', 'vnetmedia_showRaCacNut'); 
	if (!function_exists('vnetmedia_showRaCacNut')) { 
		function vnetmedia_showRaCacNut(){
			wp_register_script( 'vnetmediaScript', plugin_dir_url( __FILE__ ) . 'main.js','','1.1', true );
			wp_enqueue_script( 'vnetmediaScript' );
				
			wp_register_style( 'floatingbutton',  plugin_dir_url( __FILE__ ) . 'css/style.css' );
			wp_enqueue_style( 'floatingbutton' );
			
			add_action('wp_footer', 'vnetmedia_codeCacNut');
		}
	}
	if (!function_exists('vnetmedia_codeCacNut')) {
		function vnetmedia_codeCacNut() {
			
		if(get_option('hienchuthich') != ""){
			echo '<style>.inner-fabs.show .fab::before {display: none;} </style>';
		}  	
			
			echo '<!-- Fab Buttons -->
		<div class="inner-fabs">';
		if(get_option('fanpageIDvnetmedia') != "") {
			echo '<a target="blank" href="https://m.me/'.esc_attr( get_option('fanpageIDvnetmedia') ).'" class="fab roundCool" id="activity-fab" data-tooltip="Nhắn tin Messenger">
			<img class="inner-fab-icon"  src="'.plugin_dir_url( __FILE__ ) .'messenger.png" alt="icons8-exercise-96" border="0">
		  </a>';
		}
		if(get_option('googlemap') != ""){
			echo '<a target="blank" href="'.wp_specialchars_decode( get_option('googlemap') ).'" class="fab roundCool" id="challenges-fab" data-tooltip="Chỉ đường bản đồ">
			<img class="inner-fab-icon" src="'.plugin_dir_url( __FILE__ ) .'map.png" alt="challenges-icon" border="0">
		  </a>';
		}
		if(get_option('zaloPhonevnetmedia') != ""){
			echo '<a target="blank" href="https://zalo.me/'.esc_attr( get_option('zaloPhonevnetmedia') ).'" class="fab roundCool" id="chat-fab" data-tooltip="Nhắn tin Zalo">
			<img class="inner-fab-icon" src="'.plugin_dir_url( __FILE__ ) .'zalo.png" alt="chat-active-icon" border="0">
		  </a>';
		}  
		if(get_option('contactFormvnetmedia') != ""){
			echo '<div id="myBtnn" class="fab roundCool" id="ok" data-tooltip="Để lại SĐT Tư vấn">
			<img class="inner-fab-icon" src="'.plugin_dir_url( __FILE__ ) .'support.png" alt="chat-active-icon" border="0">
		  </div>';
		}  
		  
		  
		  
		echo '</div>
		<div class="fab roundCool call-animation" id="main-fab">
		 <img class="img-circle" src="'.plugin_dir_url( __FILE__ ) .'lienhe.png" alt="" width="135"/>
		</div>';
		}
	
	}
	
	
	
	/** show nut de lai tu van **/
	add_action('template_redirect', 'vnetmedia_showRaNutTuvan');
	if (!function_exists('vnetmedia_showRaNutTuvan')) { 
		function vnetmedia_showRaNutTuvan(){
			// Thêm CSS vào Header Web
			wp_register_style( 'modal',  plugin_dir_url( __FILE__ ) . 'css/modal.css' );
			wp_enqueue_style( 'modal' );
			

			add_action('wp_footer', 'vnetmedia_footerNutTuvan');
		}
	}
	if (!function_exists('vnetmedia_footerNutTuvan')) {
		function vnetmedia_footerNutTuvan() {
			
			echo '
			<!-- The Modal -->
			<div id="myModal" class="modal">

			  <!-- Modal content -->
			  <div class="modal-content">
				<div class="modal-header">
				  <span onclick="closeModal()" class="close">&times;</span>
				  </div>
				 <BR />
				<div class="modal-body">';
				echo do_shortcode(wp_specialchars_decode( get_option('contactFormvnetmedia') ));
			echo '</div>
				<div class="modal-footer">
				</div>
			  </div>

			</div>';
			
			echo '<script>
			// Get the modal
			var modal = document.getElementById("myModal");

			// Get the button that opens the modal
			var btn = document.getElementById("myBtnn");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks the button, open the modal 
			btn.onclick = function() {
			  modal.style.display = "block";
			}

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
			  modal.style.display = "none";
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
			  if (event.target == modal) {
				modal.style.display = "none";
			  }
			}
			</script>';
			//echo esc_attr( get_option('new_option_name') );
		}
	}