
<?php

function gen_uuid() {
	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		// 32 bits for "time_low"
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

		// 16 bits for "time_mid"
		mt_rand( 0, 0xffff ),

		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 4
		mt_rand( 0, 0x0fff ) | 0x4000,

		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		mt_rand( 0, 0x3fff ) | 0x8000,

		// 48 bits for "node"
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	);
}

function validatePhone($phone_text){
	$phone = preg_replace('/[^0-9]/', '', $phone_text);
	if(strlen($phone) === 10 || strlen($phone) === 11) {
		return true;
	}else{
		return false;
	}
}

$message="";
function validateEmail($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}


if(isset($_POST['submit_form'])) {
	$messages = [];
	$check_messages = [];

	if (!($_POST['name'])) {
		$check_messages['name'] = 'style="border: 2px solid red;"';
	}

	if (!validatePhone($_POST['phone'])) {
		$check_messages['phone'] = 'style="border: 2px solid red;"';
	}

	$email = $_POST['email'];
	if (!validateEmail($email)) {
		$check_messages['email'] = 'style="border: 2px solid red;"';
	}

	if (!($_POST['address'])) {
		$check_messages['address'] = 'style="border: 2px solid red;"';
	}

	if (!isset($_POST['agree_term'])) {
		$message = 'Đồng ý... là bắt buộc';
	}

	if (count($check_messages) == 0 && $message=="") {
		$t=time();
		$arr = array(
			'properties' => array(
				array(
					'property' => 'luong',
					'value' => $_POST['luong']
				),
				array(
					'property' => 'email',
					'value' => $_POST['email']
				),
				array(
					'property' => 'firstname',
					'value' => $_POST['name']
				),
				array(
					'property' => 'lastname',
					'value' => ''
				),
				array(
					'property' => 'phone',
					'value' => $_POST['phone']
				),
				array(
					'property' => 'address',
					'value' => $_POST['address']
				),
				array(
					'property' => 'note',
					'value' => $_POST['note']
				),
				array(
					'property' => 'aff_source',
					'value' => $_POST['aff_source']
				),
				array(
					'property' => 'aff_sid',
					'value' => $_POST['aff_sid']
				),
				array(
					'property' => 'identifier',
					'value' => gen_uuid()
				),
				array(
					'property' => 'hs_lead_status',
					'value' => "NEW"
				)
			)
		);

		$post_json = json_encode($arr);
		$endpoint = "https://api.hubapi.com/contacts/v1/contact/?hapikey=3f189c19-d757-485a-9882-7d9e504dec59";
		$ch = @curl_init();
		@curl_setopt($ch, CURLOPT_POST, true);
		@curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
		@curl_setopt($ch, CURLOPT_URL, $endpoint);
		@curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = @curl_exec($ch);

		$status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_errors = curl_error($ch);
		@curl_close($ch);
		if ($status_code == 200) {
			header('Location: thank.php');
			die();
		} else {
			$message = 'Email đã tồn tại';
		}
	}
}
?>


<!DOCTYPE html>
<!--[if IE 7 ]><body class="ie ie7"><![endif]-->
<!--[if IE 8 ]><body class="ie ie8"><![endif]-->
<!--[if IE 9 ]><body class="ie ie9"><![endif]-->
<html class='no-js' lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, maximum-scale=1.0">
	<title>Saccombank</title>
	<meta content="" name="keywords">
	<meta content="" name="description">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab&amp;subset=vietnamese" rel="stylesheet">
	<link type="image/x-icon" href="img/favicon.ico" rel="shortcut icon">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/font-awesome.css">
	<link rel="stylesheet" href="style.css">



</head>

<body>
<section id="header">
	<div class="container">
		<div class="logo">
			<img src="img/logo.png" alt="logo" />
		</div>
		<div class="header-left col-lg-6 col-md-6 hidden-sm hidden-xs">
			<h1 class="under-logo">Thẻ tín dụng</h1>
			<p><span class="bold">tích dặm bay tốt nhất</span> <span class="normal">từ sacombank</span></p>
			<p class=""><strong>Tặng</strong></p>
			<div class="row">
				<div class="number-flight col-lg-4 col-md-4 col-sm-4 col-xs-4">

				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<span class="large-txt">chuyến bay(*)</span><br/>
					nhân sự kiện ra mắt
					ngày <img src="img/date-bay.png" alt="ngày 12 tháng 12 năm 2016" width="120"><br/>
					<p class="dk">* Điều kiện & điều khoản áp dụng</p>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="dk-bay"><a href="#">đăng ký ngay bay miễn phí</a></div>
				</div>
			</div>

		</div>
		<div class="header-right col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="form-reg col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-right">
				<form class='reg-now-visible' id='formIndex' action="index.php" method="post" accept-charset="utf-8" role="form">
					<?php if(isset($message)){	?>
							<p style="color: red; text-align: center;"> <?php echo $message; ?></p>
							<?php
					} ?>

					<p>Thẻ Sacombank nằm trong tầm tay bạn. Hãy điền thông tin của bạn và chúng tôi sẽ gọi ngay cho bạn trong 24 giờ để hỗ trợ bạn đăng ký.</p>
					<p>Bạn có Thẻ tín dụng Sacombank chưa?</p>


					<div class="radio-custom radio-danger fl mr-10">
						<input type="radio" id="yes" <?php if(isset($_POST['luong'])) { if($_POST['luong']=="yes"){ echo "checked"; }}?> name="luong" value="yes" required oninvalid="setCustomValidity('Xin vui lòng chọn một ô')" onclick="clearValidity()"/>
						<label for="yes">Có</label>
					</div>
					<div class="radio-custom radio-danger fl">
						<input type="radio" id="no" <?php if(isset($_POST['luong'])) { if($_POST['luong']=="no"){ echo "checked"; }}else{echo "checked"; }?> name="luong" value="no" required onclick="clearValidity()"/>
						<label for="no">Chưa có</label>
					</div>


					<div style="clear:both;"></div>
					<p>Thông tin cá nhân:</p>
					<input id="name" class="input-txt" name="name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; } ?>" type="text" required placeholder="Họ tên *" oninvalid="setCustomValidity('Họ tên không để trống')" oninput="setCustomValidity('')" <?php if(isset($check_messages['name'])) { echo $check_messages['name']; } ?>>
					<input id="phone" class="input-txt" name="phone" value="<?php if(isset($_POST['phone'])) { echo $_POST['phone']; } ?>" type="text" required placeholder="Số điện thoại di động *" pattern="^[0-9]{10,12}$" oninvalid="setCustomValidity('Số điện thoại di động không đúng')" oninput="setCustomValidity('')" <?php if(isset($check_messages['phone'])) { echo $check_messages['phone']; } ?>>
					<input id="email" class="input-txt" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>" type="text" required placeholder="Email *"  pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" oninvalid="setCustomValidity('Email không chính xác!')" oninput="setCustomValidity('')" <?php if(isset($check_messages['email'])) { echo $check_messages['email']; } ?>>
					<input id="address" class="input-txt" name="address" value="<?php if(isset($_POST['address'])) { echo $_POST['address']; } ?>" type="text" required placeholder="Khu vực sinh sống *" oninvalid="setCustomValidity('Khu vực sinh sống là bắt buộc')" oninput="setCustomValidity('')" <?php if(isset($check_messages['address'])) { echo $check_messages['address']; } ?>>
					<textarea id="note" name="note" class="input-txt" rows="8" style="height: 60px;" placeholder="Ghi chú"><?php if(isset($_POST['note'])) { echo $_POST['note']; } ?></textarea>

					<div style="clear:both; margin-bottom: 10px;"></div>
					<input type="checkbox" name="agree_term" <?php if(isset($_POST['agree_term'])) { echo "checked"; }?> value="agree" required="" oninvalid="setCustomValidity('Bạn phải đồng ý với điều khoản này')" onchange="setCustomValidity('')">  Tôi đồng ý rằng Sacombank có thể sử dụng thông tin trên đây để liên hệ với tôi nhằm giới thiệu những sản phẩm, dịch vụ và chương trình khuyến mãi của Sacombank từ nay trở về sau.<br>
					<input type="hidden" name="aff_source" id="aff_source" class="aff_source" value=""/>
					<input type="hidden" name="aff_sid" id="aff_sid" class="aff_sid" value=""/>
					<input type="hidden" name="submit_form"  value="1"/>
					<center><button type="submit" value="Register Now" class='btn submit sub-form' name="submit">Hoàn thành & gửi</button></center>

				</form>
			</div>
		</div>
	</div>
</section>
<section id="tienich">
	<div class="container">
		<h2>Lợi ích vượt trội</h2>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-right">
			<img src="img/card.png" width="100%" alt="card"/>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right">
			<ul class="list-ich">
				<li> Tích lũy 01 dặm Sacombank với mỗi <span style="font-weight: bold; font-size: 20px;">20.000 đồng</span> chi tiêu bằng thẻ Sacombank Visa Signature.</li>
				<li>  Linh hoạt quy đổi dặm Sacombank sang vé máy bay nhiều hãng hàng không
					(gồm Vietnam Airlines, Vietjet Air, Jetstar Pacific), dặm xét hạng Vietnam Airlines,
					phí thường niên hoặc tiền mặt.</li>
				<li>Miễn phí thẻ Priority Pass để sử dụng hơn 1.000 phòng chờ tại các sân bay toàn cầu.</li>
				<li> Bảo hiểm du lịch lên đến 10,5 tỷ VNĐ</li>
				<li>Tận hưởng đầy đủ các tiện ích của thẻ tín dụng quốc tế Sacombank như:
					mua trước trả sau miễn lãi 55 ngày, thanh toán và rút tiền mặt
					trong nước và quốc tế, mua sắm online và trả góp lãi suất 0%.

				</li>
			</ul>
		</div>
	</div>
</section>
<section id="uu-dai">
	<div class="container">
		<h2>Ưu đãi đặc biệt</h2>
		<div id="content-shape">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="shape-two"><div class="shape-one"><img src="img/may-bay-mat-troi.jpg" alt="máy bay mặt trời" /></div></div>
				<div style="clear:both;"></div>
				<p class="uu-dai-txt">
					- Gói thưởng dặm cho khách hàng mở thẻ lần đầu:
					<br>&nbsp;&nbsp;+ Tặng ngay 500 dặm Sacombank khi phát sinh bất kỳ chi tiêu nào trong 03 tháng đầu tiên mở thẻ
					<br>&nbsp;&nbsp;+ Tặng thêm 4.500 dặm Sacombank khi chi tiêu tối thiểu 100 triệu trong 03 tháng đầu tiên mở thẻ
					<br/> <span class="yellow-txt"> (*)Tặng đến 3.000.00 đồng cho chuyến bay đầu tiên của 100 khách hàng mở thẻ sớm nhất</span></p>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="shape-two"><div class="shape-one"><img src="img/may-bay-troi-xanh.jpg" alt="máy bay trời xanh" /></div></div>
				<div style="clear:both;"></div>
				<p class="uu-dai-txt">
					Hoàn tiền cho 100 giao dịch mua vé máy bay online trên website chính thức của Vietnam Airlines, Vietjet Air và Jetstar Pacific đầu tiên đến hết 28/02/2016 bằng thẻ Sacombank Visa Signature.
					<br/> <span class="yellow-txt"> (*) Mỗi chủ thẻ được hoàn 1 lần, tối đa 1.000.000 VNĐ/vé nội địa hoặc 3.000.000 VNĐ/vé quốc tế</span></p>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
</section>
<div style="clear:both;"></div>
<section id="dieu-kien" style="padding-bottom: 20px;">
	<div class="container">
		<h2>điều kiện áp dụng</h2>
		<ul>
			<li class="list-over-18 col-lg-6 col-md-6 col-sm-12 col-xs-12">Từ 18 tuổi trở lên</li>
			<li class="list-income col-lg-6 col-md-6 col-sm-12 col-xs-12">Thu nhập hàng tháng tối thiểu 60 triệu</li>
		</ul>
		<span class="dark-txt pull-right">Thưởng thêm dặm Sacombank cho khách hàng mở thẻ lần đầu:<br/>
			-       500 dặm cho giao dịch đầu tiên (*)<br/>
			-       4.5                                  00 dặm khi đạt 100.000.00 VND doanh số giao dịch (*)<br/>
			(*) Áp dụng với giao dịch thanh toán, mua sắm trong 03 tháng đầu sử dụng thẻ
		</span>
	</div>
</section>
<section id="faq">
	<div class="container">
		<h2>faq</h2>
		<div class="tab-content">
			<div class="tab-pane fade in active">
				<div class="panel-group">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Tỷ lệ quy đổi dặm Sacombank thành các tiện ích khác như thế nào?</a>
							</h4>
						</div>
						<div id="collapse1" class="panel-collapse collapse">
							<div class="panel-body">
								Khách hàng có thể linh động quy đổi dặm Sacombank tích lũy được sang các tiện ích khác với tỷ lệ như sau: <br/>
								-	01 dặm Sacombank quy đổi 01 dặm Vietnam Airlines<br/>
								-	10 dặm Sacombank quy đổi 01 dặm xét hạng Vietnam Airlines<br/>
								-	01 dặm Sacombank quy đổi 100 VNĐ tiền mặt hoặc phí thường niên<br/>
								Tỷ lệ này sẽ thay đổi theo từng thời kỳ. <br/>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Khách hàng muốn quy đổi dặm Sacombank thì làm như thế nào?</a>
							</h4>
						</div>
						<div id="collapse2" class="panel-collapse collapse">
							<div class="panel-body">Để quy đổi dặm Sacombank, khách hàng liên hệ tổng đài VIP Sacombank 1 800 5858 23.</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Thẻ tín dụng Visa Signature có được tích điểm đổi quà chương trình “Thế giới điểm thưởng” không?</a>
							</h4>
						</div>
						<div id="collapse3" class="panel-collapse collapse">
							<div class="panel-body">Thẻ tín dụng Visa Signature chỉ sử dụng để tích lũy dặm Sacombank, không tích diểm đổi quà chương trình “Thế giới điểm thưởng”. </div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Chủ thẻ tín dụng quốc tế hiện hữu chuyển đổi sang thẻ Visa Signature thì điểm “Thế giới điểm thưởng” tích lũy được có được chuyển sang thẻ mới không?</a>
							</h4>
						</div>
						<div id="collapse4" class="panel-collapse collapse">
							<div class="panel-body">Chủ thẻ tín dụng hiện hữu đủ điều kiện chuyển đổi sang thẻ Visa Signature sẽ được quy đổi điểm “Thế giới điểm thưởng” đã tích lũy được sang dặm Sacombank theo tỷ lệ: 20 điểm Thế giới điểm thưởng = 01 dặm Sacombank.

								Việc quy đổi này chỉ áp dụng 01 lần duy nhất tại thời điểm chuyển đổi thẻ Visa Signature.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion2" href="#collapse5">Thẻ tín dụng hiện hữu của khách hàng được miễn/giảm phí thường niên, khi chuyển đổi sang thẻ Visa Signature có giữ nguyên chính sách PTN cũ?</a>
							</h4>
						</div>
						<div id="collapse5" class="panel-collapse collapse">
							<div class="panel-body">
								Mức phí thường niên 1.499.000 VNĐ áp dụng cho tất cả các đối tượng khách hàng (ngoại trừ khách hàng dịch vụ ngân hàng cao cấp). Theo đó, khi khách hàng chuyển đổi thẻ tín dụng hiện hữu sang thẻ Visa Signature thì PTN sẽ được điều chỉnh thành thu phí thường niên các năm (Fee code 2).

								Ví dụ:
								Khách hàng mở thẻ tín dụng Visa Platinum vào tháng 08/2015 với fee code 4 – miễn phí thường niên năm 1. Đến tháng 08/2016 khách hàng bị thu 999.000 VNĐ PTN năm 2. Ngày 15/12/2016, thẻ được chuyển đổi sang thẻ Visa Signature:
								-	Tại thời điểm chuyển đổi: fee code của khách hàng sẽ được chuyển đổi thành fee code 2 – thu PTN các năm
								-	Thời gian thu PTN lần đầu của thẻ Signature (tương đương PTN năm 1 của thẻ Signature): tháng 08/2017
								-	Tại thời điểm chuyển đổi, khách hàng không bị thu các khoản phí liên quan đến việc chuyển đổi, ngoại trừ phí nâng hạn mức (nếu có)

							</div>
						</div>
					</div>
				</div>
				<div class="panel-group">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion2" href="#collapse6">Đối tượng hưởng ưu đãi chương trình khuyến mãi”?</a>
							</h4>
						</div>
						<div id="collapse6" class="panel-collapse collapse">
							<div class="panel-body">Khách hàng sở hữu thẻ tín dụng Visa Signature (không áp dụng cho CBNV Sacombank & Cty trực thuộc) từ ngày 12.12.2016 và có mã đóng phí thường niên 100% năm đầu thực hiện mua vé máy bay online từ ngày 12.12.2016 – 28.02.2017 trên trang web: www.vietnamairlines.com hoặc www.jetstar.com hoặc www.vietjetair.com</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion2" href="#collapse7">Thẻ phụ Visa Signature có được tham gia chương trình hoàn tiền 100 chuyến bay đầu tiên khi mở và sử dụng thẻ sớm nhất không?</a>
							</h4>
						</div>
						<div id="collapse7" class="panel-collapse collapse">
							<div class="panel-body">Doanh số giao dịch từ thẻ phụ sẽ được ghi nhận cho thẻ chính Visa Signature. Sacombank thực hiện hoàn tiền trên tài khoản thẻ của chủ thẻ chính.</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion2" href="#collapse8">Chủ thẻ chỉ cần mở thẻ và giao dịch mua vé online sớm nhất trong số 100 KH được hưởng ưu đãi từ chương trình là chủ thẻ sẽ được nhận hoàn tiền?</a>
							</h4>
						</div>
						<div id="collapse8" class="panel-collapse collapse">
							<div class="panel-body">đúng
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion3" href="#collapse9">Số lần, số tiền chủ thẻ được hoàn tiền trong thời gian chương trình?</a>
							</h4>
						</div>
						<div id="collapse9" class="panel-collapse collapse">
							<div class="panel-body">
								Mỗi chủ thẻ chính được hoàn tiền 1 lần duy nhất cho giao dịch đầu tiên thỏa điều kiện trong suốt thời gian chương trình. Số tiền hoàn: 3 triệu đồng/vé quốc tế, 1 triệu đồng/vé nội địa nhưng không vượt quá số tiền chủ thẻ đã mua vé máy bay.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion3" href="#collapse10">Nếu khách hàng nằm trong danh sách 100 KH mua vé thỏa điều kiện sớm nhất của chương trình? Trình tự hoàn tiền như thế nào?</a>
							</h4>
						</div>
						<div id="collapse10" class="panel-collapse collapse">
							<div class="panel-body">Khách hàng sở hữu thẻ tín dụng Visa Signature (không áp dụng cho CBNV Sacombank & Cty trực thuộc) từ ngày 12.12.2016 và có mã đóng phí thường niên 100% năm đầu thực hiện mua vé máy bay online từ ngày 12.12.2016 – 28.02.2017 trên trang web: www.vietnamairlines.com hoặc www.jetstar.com hoặc www.vietjetair.com</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>
<section id="footer">
	<div class="container">
		<div class="footer-txt col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left">
			Copyright (C) 2016 Accesstrade VN & Sacombank
		</div>
		<div class="footer-logo col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
			<img src="img/logo-accesstrade.png" alt="logo accesstrade"/><img src="img/logo-saccom.png" alt="logo saccombank"/><img src="img/logo-norton.png" alt="logo norton secure"/>
		</div>

	</div>
</section>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.validate.min.js"></script>

<script src="//cdn.accesstrade.vn/js/tracking.js" ></script>
<script type="text/javascript">
	AT.track();
	function clearValidity() {
		document.getElementById('yes').setCustomValidity('');
	}

	function onInvalidCustom(idstr) {
		var me = document.getElementById(idstr);
		me.setCustomValidity('Số điện thoại không chính xác');
		//me.setCustomValidity('');
	}

	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length,c.length);
			}
		}
		return "";
	}
	$("#aff_source").val(getCookie("_aff_network"));
	$("#aff_sid").val(getCookie("_aff_sid"));
</script>

</body>
</html>



