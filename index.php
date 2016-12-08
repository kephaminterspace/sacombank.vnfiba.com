
<?php
$message = '';
$t=time();
$day = date('d');

$count_down_sale = (31-$day);
if($count_down_sale<=20){
	$count_down_sale = 20;
}

if(isset($_POST['name'])) {
	$arr = array(
		'properties' => array(
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
				'property' => 'region',
				'value' => $_POST['region']
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
				'value' => (string)$t
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
	}else{
		$message = 'Email đã tồn tại';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>BỆNH VIỆN THẨM MỸ KANGNAM</title>
	<meta charset="utf-8">
	<link rel="SHORTCUT ICON" href="media/images/st.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link id="pagestyle" rel="stylesheet" type="text/css" href="" />
</head>
<script type="text/javascript">
	function layoutHandler(){
		var styleLink = document.getElementById("pagestyle");
		if(window.innerWidth < 441){
			styleLink.setAttribute("href", "media/css/mb/style_mb.css");
		} else if(window.innerWidth > 1000){
			styleLink.setAttribute("href", "media/css/pc/style.css");
		} else {
			styleLink.setAttribute("href", "media/css/pc/style.css");
		}
	}
	window.onresize = layoutHandler;
	layoutHandler();
</script>
<body id="landingPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<nav class="navbar navbar-default navbar-fixed-top header ">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#landingPage"><img src="media/images/logomb.png" alt=""></a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav menu">
				<li><a href="#home">Trang chủ</a></li>
				<li><a href="#reason">Công nghệ</a></li>
				<li><a href="#process">Quy trình</a></li>
				<li><a href="#customer">Khách Hàng</a></li>
				<li><a href="#sale">Khuyến Mãi</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right dktop">

				<li><a class="btn" href="#register">Đăng ký </a></li>
			</ul>
		</div>
	</div>
</nav>
<div class="page1" id="home">
	<div class="fixwidth">
		<div class="headline slide"></div>
		<div class="right">
			<div class="top">ƯU ĐÃI NGAY  HÔM NAY!</div>
			<div class="countdown">
				<span id="started"></span>
			</div>
			<div class="percent">
				<span>-<?php echo $count_down_sale; ?>%</span>
			</div>
			<div class="text">
				<i>Chương trình Count Down Sale với <b>ưu đãi thay đổi theo từng ngày</b>  cho dịch vụ Bấm Mí Dove Eyes. <span><b>Đăng ký ngay hôm nay</b> để được nhận ưu đãi lớn nhất.</i></span>
			</div>
		</div>

		<a href="#register" class="btn reg slide btnkn1km">Đăng ký ngay <span class="icon-angle-double-right "></span></a>
	</div>
</div>
<div class="page2" id="reason">
	<div class="fixwidth">
		<div class="row">
			<div class="col-sm-6 left">
				<div class="title"><span></span>CÔNG NGHỆ BẤM MÍ DOVE EYES<span></span></div>
				<div class="content">
					<ul>
						<li>Xu hướng bấm mí được sao Hàn ưa chuộng </li>
						<li>Áp dụng đối với tình trạng mắt 1 mí, mắt mí lót, mắt không rõ mí, mắt lệch mí</li>
						<li>Không phẫu thuật, không xâm lấn, an toàn</li>
						<li>Nếp mí rõ nét, kết quả 10 năm - lâu dài hẳn so với phương pháp bấm mí thông thường </li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6 right">
				<div class="title"><span></span>Video khách hàng<span></span></div>
				<div class="row">
					<div class="col-sm-6">
						<div class="video">
							<a href="https://www.youtube.com/watch?v=bYK1HZZyRHc&list=PLROTewhS4-MaGUlT3cCOLmkkYZxoZxOKV&index=1" class="fancybox-media clip"></a>
						</div>
					</div>
					<div class="col-sm-6">
						<p>Video khách hàng bấm mí <br/>
							Dove Eyes</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="video">
							<a href="https://www.youtube.com/watch?v=hs2Q0th38p0&list=PLROTewhS4-MaGUlT3cCOLmkkYZxoZxOKV&index=7" class="fancybox-media clip1"></a>
						</div>
					</div>
					<div class="col-sm-6">
						<p>Video khách hàng bấm mí <br/>
							Dove Eyes</p>
					</div>
				</div>
				<a href="#register" class="btn reg slide ">Đăng ký tư vấn <span class="icon-angle-double-right "></span></a>
			</div>
		</div>
	</div>
</div>
<div class="page3" id="dif">
	<div class="fixwidth">
		<div class="row desk">
			<div class="col-sm-5">
				<div class="title1">
					ĐIỀU GÌ LÀM NÊN SỰ KHÁC BIỆT?
					<span class="icon-right-5"></span>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-6">
						<figure>
							<img src="media/images/page3-1.jpg" class="slide">
							<figcaption>
								<span>Chuyên khoa thẩm mỹ mắt </span>
								Với các Chuyên gia giỏi, tu nghiệp tại  Hàn Quốc. Cơ sở vật chất & phòng tiểu phẫu được vô trùng tiêu chuẩn Hàn Quốc
							</figcaption>
						</figure>
					</div>
					<div class="col-sm-6">
						<figure>
							<img src="media/images/page3-2.jpg" class="slide">
							<figcaption>
								<span>Đo vẽ thẩm mỹ </span>
								Chuẩn xác tạo 2 mí đều đẹp chuẩn  tỉ lệ vàng
							</figcaption>
						</figure>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<figure>
							<img src="media/images/page3-3.jpg" class="slide">
							<figcaption>
								<span>Kỹ thuật</span>
								Không phẫu thuật, không cắt rạch (đính sụn mi với da mi mắt tạo liên kết chắc chắn)
							</figcaption>
						</figure>
					</div>
					<div class="col-sm-6">
						<figure>
							<img src="media/images/page3-4.jpg" class="slide">
							<figcaption>
								<span> Công nghệ Hàn Quốc</span>
								Sử dụng chỉ đôi xoắn chéo rất mảnh, có đặc tính bền bỉ, độ đàn hồi cao
							</figcaption>
						</figure>
					</div>
				</div>

			</div>
		</div>
		<div class="title1 mb">
			ĐIỀU GÌ LÀM NÊN SỰ KHÁC BIỆT?
		</div>
		<div class="carousel slide mb" id="slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#slide" data-slide-to="0" class="active"></li>
				<li data-target="#slide" data-slide-to="1" class=""></li>
				<li data-target="#slide" data-slide-to="2" class=""></li>
				<li data-target="#slide" data-slide-to="3" class=""></li>
			</ol>
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<figure>
						<img src="media/images/page3-1.jpg">
						<figcaption>
							<span>Chuyên khoa thẩm mỹ mắt </span>
							Với các Chuyên gia giỏi, tu nghiệp tại Hàn Quốc. Cơ sở vật chất & phòng tiểu phẫu được vô trùng tiêu chuẩn Hàn Quốc
						</figcaption>
					</figure>
				</div>
				<div class="item ">
					<figure>
						<img src="media/images/page3-2.jpg">
						<figcaption>
							<span>Đo vẽ thẩm mỹ </span>
							Chuẩn xác tạo 2 mí đều đẹp chuẩn  tỉ lệ vàng
						</figcaption>
					</figure>
				</div>
				<div class="item ">
					<figure>
						<img src="media/images/page3-3.jpg">
						<figcaption>
							<span>Kỹ thuật</span>
							Không phẫu thuật, không cắt rạch (đính sụn mi với da mi mắt tạo liên kết chắc chắn)
						</figcaption>
					</figure>
				</div>
				<div class="item ">
					<figure>
						<img src="media/images/page3-4.jpg">
						<figcaption>
							<span> Công nghệ Hàn Quốc</span>
							Sử dụng chỉ đôi xoắn chéo rất mảnh, có đặc tính bền bỉ, độ đàn hồi cao
						</figcaption>
					</figure>
				</div>
			</div>
			<div class="video">
				<a href="https://www.youtube.com/watch?v=r338HfXYds4" class="fancybox-media clip slide">Xem video Korean Beauty Triangle</a>
			</div>
			<a href="#register" class="btn reg slide ">Đăng ký tư vấn <span class="icon-angle-double-right "></span></a>
		</div>

	</div>
</div>
<div class="page4" id="process">
	<div class="fixwidth">
		<div class="title">
			<span></span>QUY TRÌNH THỰC HIỆN<span></span>
		</div>
		<div class="text">
			<div class="row">
				<div class="col-sm-2"><span>1</span>Thăm khám, tư vấn, <br/> kiểm tra sức khỏe</div>
				<div class="col-sm-2"><span>2</span>Đo vẽ <br/> thẩm mỹ</div>
				<div class="col-sm-2"><span>3</span>Gây tê <br/>tại chỗ</div>
				<div class="col-sm-2"><span>4</span>Tiến hành  <br/>bấm mí</div>
				<div class="col-sm-2"><span>5</span>Chăm sóc <br/> sau bấm mí</div>
				<div class="col-sm-2"><span>6</span>Tái khám</div>
			</div>
		</div>
		<div class="ck">( Thời gian thực hiện: 20p )</div>
	</div>
</div>
<div class="page5" id="customer">
	<div class="fixwidth">
		<div class="st slideanim">
			<figure>
				<figcaption>
					HỌ TỎA SÁNG VÀ NỔI BẬT
					<span>NHỜ <b>BẤM MÍ DOVE EYES</b></span>
				</figcaption>
				<img src="media/images/st.png">
			</figure>
		</div>
	</div>
</div>
<div class="page6" id="sale">
	<div class="fixwidth">
		<div class="right">
			<div class="countdown">
				<span id="started1"></span>
			</div>
			<div class="percent">
				<span>-<?php echo $count_down_sale; ?>%</span>
			</div>
			<div class="text">
				<i>Chương trình Count Down Sale với <b>ưu đãi thay đổi theo từng ngày</b>  cho dịch vụ Bấm Mí Dove Eyes. <br/><b>Đăng ký ngay hôm nay</b> để được nhận ưu đãi lớn nhất.</i>
			</div>
		</div>
		<div class="form slide" id="register">
			<div>
				<h3> Đăng ký tham gia <b>Nhận ưu đãi lên tới <?php echo $count_down_sale; ?>%</b></h3>
				<h4>Áp dụng cho 50 khách hàng đăng kí sớm nhất</h4>
				<article>
					<form class="contact-form" id="contactform" method="post" action="index.php#register">
						<?php if(isset($message)){ ?>
							<p style="color: red; "> <?php echo $message; ?></p>
						<?php } ?>
						<div class="fct">
							<input id="name" name="name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; } ?>" type="text" required placeholder="Họ tên *:" required oninvalid="setCustomValidity('Họ tên không để trống')" oninput="setCustomValidity('')">
							<input id="email" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>" type="text" required placeholder="Email *:" required pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" oninvalid="setCustomValidity('Email không chính xác!')" oninput="setCustomValidity('')">
							<input id="phone" name="phone" value="<?php if(isset($_POST['phone'])) { echo $_POST['phone']; } ?>" type="text" required placeholder="Điện thoại *:" required pattern="^[0-9]{10,12}$" oninvalid="setCustomValidity('Số điện thoại không đúng')" oninput="setCustomValidity('')">
							<select id="region" name="region" required oninvalid="setCustomValidity('Đăng ký tư vấn tại không để trống')" oninput="setCustomValidity('')">
								<option value="" style="color:#ccc">Đăng ký tư vấn tại</option>
								<option value="1" style="color:blue" <?php if(isset($_POST['region'])){if($_POST['region']==1) { ?> selected <?php } }?> >TP Hồ Chí Minh</option>
								<option value="2" style="color:red" <?php if(isset($_POST['region'])){if($_POST['region']==2) { ?> selected <?php } }?>>Hà Nội</option>
							</select>
							<!--					<textarea name="itext" id="itext" cols="30" rows="10" placeholder="Dịch vụ quan tâm *:"></textarea>-->
							<input type="hidden" name="aff_source" id="aff_source" class="aff_source" value=""/>
							<input type="hidden" name="aff_sid" id="aff_sid" class="aff_sid" value=""/>
						</div>
						<div class="dkbt">
							<input class="target fbt bmk submit_s" type="submit" value="Đăng ký">
						</div>
					</form>
				</article>
			</div>
		</div>

	</div>
</div>


<div class="kq">
	<div class="container">
		<p>(*) Kết quả tùy thuộc cơ địa của mỗi người</p>
	</div>
</div>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="ftbox col1">
					<div class="logocenter"><img src="media/images/logoft.png"></div>
					<p>Giấy phép hoạt động số 181/BYT-GPHĐ <br>Chứng chỉ hành nghề số 003474/HNO-CCHN</p>
					<!--  <div><b>Website : <a href="http://benhvienthammykangnam.vn/">www.benhvienthammykangnam.vn</a></b></div> -->
					<!--  <div class="bstv-hl">Bác sĩ tư vấn (24/7) <b></b>
                     </div> -->
				</div>
			</div>
			<div class="col-sm-4">
				<div class="ftbox col2">
					<div class="place">Hà Nội</div>
					<!-- <div>
                      Tel: <a href="tel:0473006466">04.73.00.64.66</a><br>Mobile:<a class="zalovb" href="tel:0968999777" rel="nofollow">0968.999.777</a>
                      <hr>
                    </div> -->
					<div><a class="chidan" rel="nofollow" target="_blank" href="https://www.google.com/maps/place/Th%E1%BA%A9m+M%E1%BB%B9+Vi%E1%BB%87n+Kangnam+T%E1%BA%A1i+H%C3%A0+N%E1%BB%99i/@21.0189961,105.8516408,16z/data=!4m2!3m1!1s0x3135ab920d07ad6b:0xaeafc086533191b">38 - Nguyễn Du - Q. Hai Bà Trưng - HN</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="ftbox col2">
					<div class="place">Tp. Hồ Chí Minh </div>
					<!-- <div>
                      Tel: <a href="tel:0873066466">08.73.06.64.66</a><br>Mobile: <a class="zalovb" href="tel:0948449988" id="callme" rel="nofollow">0948.44.99.88</a>
                      <hr>
                    </div> -->
					<div>
						<a class="chidan" rel="nofollow" target="_blank" href="https://maps.google.com/maps?q=Th%E1%BA%A9m+m%E1%BB%B9+vi%E1%BB%87n+Kangnam+T%E1%BA%A1i+H%E1%BB%93+Ch%C3%AD+Minh&amp;hl=vi&amp;ie=UTF8&amp;sll=10.773004,106.675208&amp;sspn=0.012521,0.021136&amp;hq=Th%E1%BA%A9m+m%E1%BB%B9+vi%E1%BB%87n+Kangnam+T%E1%BA%A1i&amp;hnear=Th%C3%A0nh+ph%E1%BB%91+H%E1%BB%93+Ch%C3%AD+Minh,+H%E1%BB%93+Ch%C3%AD+Minh,+Vi%E1%BB%87t+Nam&amp;t=m&amp;z=12">Số 84A - Bà Huyện Thanh Quan, P.9- Q.3- TP HCM</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<script src="media/js/jquery.min.js"></script>
<script src="media/js/bootstrap.min.js"></script>
<script src="media/js/slide_touch.js"></script>
<script src="media/js/jquery.fancybox.pack.js"></script>
<script src="media/js/jquery.fancybox-media.js"></script>
<script src="media/js/jquery.countdown.js"></script>
<script src="media/js/setup.js"></script>

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

