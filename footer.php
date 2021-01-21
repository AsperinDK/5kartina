<footer class="footer-area section-gap">
	<div class="container">
		<div class="footer-bottom row align-items-center text-center text-lg-left">
			<p class="footer-text m-0 col-lg-7 col-md-12">
				<a href="/" class="d-inline-block">Главная</a>
				<a href="/#price" class="d-inline-block">Цены</a>
				<a href="/discount/" class="d-inline-block">Скидки</a>
				<a href="/delivery/" class="d-inline-block">Доставка</a>
				<a href="/contact/" class="d-inline-block">Контакты</a>
				<span class="d-block">
					<span class="d-inline-block mr-4">© <?= COMPANY_NAME ?>, <?= date('Y', strtotime(COMPANY_START_DATE)) ?> - <?= date('Y') ?> г.</span>
					<a href="/rules/" class="d-inline-block" style="color: #777; text-decoration: underline;">Пользовательское соглашение</a>
				</span>
			</p>
			<div class="col-lg-3 col-md-12 text-center text-lg-right">
				<div class="footer-contact">
					<a href="tel:<?= CONTACT_PHONE ?>" class="text"><?= CONTACT_PHONE_READABLE ?></a><br/>
					<a href="mailto:<?= CONTACT_EMAIL ?>" class="text"><?= CONTACT_EMAIL ?></a>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 text-center text-lg-right">
				<div class="footer-social">
					<a href="<?= CONTACT_VK_GROUP_URL ?>" target="_blank"><div class="vk-icon"></div></a>
					<a href="<?= CONTACT_INSTAGRAM_URL ?>" target="_blank"><i class="ti-instagram"></i></a>
				</div>
			</div>
		</div>
	</div>
</footer>

<script src="/vendors/jquery/jquery-3.2.1.min.js"></script>
<script src="/vendors/bootstrap/bootstrap.bundle.min.js"></script>
<script src="/vendors/owl-carousel/owl.carousel.min.js"></script>
<script src="/vendors/nice-select/jquery.nice-select.min.js"></script>
<script src="/vendors/Magnific-Popup/jquery.magnific-popup.min.js"></script>
<script src="/js/jquery.ajaxchimp.min.js"></script>
<script src="/js/mail-script.js"></script>
<script src="/js/main.js"></script>
<script type="text/javascript">
	// Событие загрузки VK api
	window.vkAsyncInit = function() {
	    VK.init({ apiId: '<?= CONTACT_VK_APP_ID ?>' });
	    document.dispatchEvent(new Event("VkApiLoad"));
  	};
  	setTimeout(function() {
		var el = document.createElement("script");
		el.type = "text/javascript";
		el.src = "https://vk.com/js/api/openapi.js?156";
		el.async = true;
		document.getElementsByTagName("head")[0].appendChild(el);
  	}, 0);
</script>