<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><!-- Page --> <section class="page contact">
<div class="container">
	<div class="page-title-group">
		<h1 class="h1 page-title">Контакты</h1>
	</div>
	<div class="contact-contacts">
		<div class="contact-contacts-row">
			 <a href="tel:+78002007065" class="big-phone">8 (800) 200-70-65</a><br>
			<div>
				 Позвоните нам в рабочее время. Ответим на ваши вопросы, проконсультируем
			</div>
		</div>
		<div class="contact-contacts-row">
			 Будни — С 9:00 ДО 18:00 <br>
			 СБ, ВС — ВЫХОДНОЙ
		</div>
		<div class="contact-contacts-row">
 <a href="mailto:info@theexpert.pro">info@theexpert.pro</a>
		</div>
	</div>
	<div id="mapTabs" class="contact-places">
		<div class="contact-places-col active" data-map="office">
			<div class="h1 contact-places-title">
				 Офис
			</div>
			<p>
				 Санкт-Петербург, 191028, Литейный проспект, 26,
				 БЦ&nbsp;«Преображенский двор», офис. 211
			</p>
		</div>
		<div class="contact-places-col" data-map="stock">
			<div class="h1 contact-places-title">
				 Склад
			</div>
			<p>
				 в Европе, в России
			</p>
		</div>
	</div>
</div>
 </section>
<!-- Map -->
<div class="map-wrap">
	<div id="map" class="map">
	</div>
</div>
<section class="question question-dark" data-bleed="100" data-parallax="scroll" data-z-index="1" data-speed="0.5" data-image-src="<span id=" title="<?=SITE_TEMPLATE_PATH?>">
<div class="container">
	<div class="question-header">
		<div class="h2 question-title">
			 Задать<br>
			 вопрос
		</div>
		<div class="question-text">
			 Оставьте ваши контактные данные, и наш менеджер обязательно с вами свяжется
		</div>
	</div>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"form_1",
	Array(
		"AJAX_MODE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("RESULT_ID"=>"RESULT_ID","WEB_FORM_ID"=>"WEB_FORM_ID",),
		"WEB_FORM_ID" => "1"
	)
);?>
</div>
 </section>
<!--/ Question -->
<!--/ Page -->
<script src="//api-maps.yandex.ru/2.1/?lang=ru"></script>
<script>
	var mapPoints = {
		office: [
		{
			title: 'Офис',
			address: 'Санкт-Петербург. 191028 Литейный проспект, 26, офис. 206 БЦ «Преображенский двор»',
			gps: [59.941888, 30.349324]
		}
		],
		stock: [
		{
			title: 'Склад',
			address: 'Санкт-Петербург. 191028 Литейный проспект, 26, офис. 206 БЦ «Преображенский двор»',
			gps: [59.941888, 30.349324]
		}
			// Адресов может быть несколько
			]
		};
		ymaps.ready(function () {
			var $tabs = $('#mapTabs').find('[data-map]'),
			yMap = new ymaps.Map('map', {
				center: [0, 0],
				zoom: 10
			}),
			yMarks = new ymaps.GeoObjectCollection();
			yMap.behaviors.disable('scrollZoom');
			yMap.controls.remove('trafficControl');
            yMap.controls.remove("searchControl");
			yMap_processPlaces('office');
			window.onresize = function() {
				yMap.container.fitToViewport();
			// yMap.setBounds(yMarks.getBounds());
		};
		$tabs.on('click', function (e) {
			e.preventDefault();
			console.log($(this).data('map'));
			yMap_processPlaces($(this).data('map'));
			$(this).addClass('active');
			$tabs.not(this).removeClass('active');
		});
		function yMap_processPlaces(type) {
			if (mapPoints[type] === undefined) return;
			var places = mapPoints[type];
			yMarks.removeAll();
			for (var i = 0; i < places.length; i++) {
				var data = places[i];
				var placemark = new ymaps.Placemark(data.gps, {
					hintContent: data.title,
					balloonContent: data.address
				}, {
					iconLayout: 'default#image',
					iconImageHref: '<?=SITE_TEMPLATE_PATH?>/images/placemark.png',
					iconImageSize: [41, 56]
				});
				yMarks.add(placemark);
			}
			yMap.geoObjects.add(yMarks);
			yMap.setBounds(yMarks.getBounds());
			if (places.length === 1) {
				yMap.setZoom(14);
			}
		}
	});
</script><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
