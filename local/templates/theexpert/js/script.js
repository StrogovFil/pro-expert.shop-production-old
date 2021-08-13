(function (window, document, $) {
	var Layout = Layout || {};
	Layout.isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (App.isMobile.Android() || App.isMobile.BlackBerry() || App.isMobile.iOS() || App.isMobile.Opera() || App.isMobile.Windows());
		}
	};
	Layout.setup = function () {
		this.$doc = $(document);
		this.$window = $(window);
		this.scrollers = '.js-scroll';
		this.carousels1 = '.js-carousel-one';
		this.carousels2 = '.js-carousel-two';
		this.carouselsdef = '.js-carousel-def';
		this.carouselsdefabout = '.js-carousel-def-about';
		this.carousels2nospace = '.js-carousel-two-nospace';
		this.carousels3 = '.js-carousel-three';
		this.carouselsNoMobile = '.js-carousel-nomobile';
		this.carouselsAuto = '.js-carousel-auto';
		this.accordion = '.js-accordion';
	};
	Layout.initialize = function () {
		Layout.setup();
		Layout.carousels();
		Layout.accordions();
		this.$doc.find('.js-phone').mask('+7 (999) 999-99-99');
		this.$doc
			.on('click touchend', this.scrollers, function (e) {
				e.preventDefault();
				$(window).scrollTo($(this).attr('href'), 400, {
					// offset: -100
				});
			})
			.on('click', '.js-count-btn', function (e) {
				e.preventDefault();
				var $container = $(this).closest('.js-count'),
					$count = $container.find('.js-count-input'),
					num = $count.val();
				if (isNaN(num) === false) {
					num = parseInt(num, 10);
					if ($(this).hasClass('plus')) {
						num = num + 1;
						$count.val(num);
					} else if ($(this).hasClass('minus')) {
						if (num <= 1) return;
						num = num - 1;
						$count.val(num);
					}
				} else {
					return false;
				}
				$count.trigger('change');
			})
			.on('change keypress keyup', '.js-count-input', function() {
				if ($(this).val().match(/\D/)) this.value = $(this).val().replace(/\D/g,'');
				if (parseInt($(this).val(), 10) < 1) this.value = 1;
			})
			.on('click touchend', '.js-add-to-cart', function(e) {
				e.preventDefault();
				var $form = $(this).closest('form'),
					id = $form.find('[name="id"]').val(),
					count = $form.find('[name="count"]').val();

				return Layout.Cart.add(id, count);
			})
			.on('click touchend', '.js-cart', function (e) {
				e.preventDefault();
				$.fancybox.close();
				$.fancybox.open({
					src: 'popup/cart.html',
					type: 'ajax',
					animationEffect: 'fade',
					baseClass: 'modal-fullscreen',
					margin: [0, 0]
				});
			});
		this.$doc.find('[data-fancybox]').fancybox({
			animationEffect: 'zoom-in-out',
			buttons: ['thumbs', 'zoom', 'close']
		});
	};
	Layout.carousels = function () {
		var $slider = this.$doc.find('#slider'),
			$owlAuto = this.$doc.find(this.carouselsAuto),
			$owlOne = this.$doc.find(this.carousels1),
			$owlTwo = this.$doc.find(this.carousels2),
			$owlDef = this.$doc.find(this.carouselsdef),
			$owlDefAbout = this.$doc.find(this.carouselsdefabout),
			$owlTwoNospace = this.$doc.find(this.carousels2nospace),
			$owlThree = this.$doc.find(this.carousels3),
			$owlNoMobile = this.$doc.find(this.carouselsNoMobile),
			owlNoMobileOptions = {
				responsive: {
					0: {
						items: 1
					},
					768: {
						items: 2
					},
					1104: {
						items: 3
					}
				},
				rewind: true,
				dots: false,
				nav: true,
				navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>']
			},
			$productMain = this.$doc.find('#galleryMain'),
			$productThumbs = this.$doc.find('#galleryThumbs');
			$owlAuto.owlCarousel({
				responsive: {
					0: {
						items: 1,
						margin: 3
					},
					768: {
						items: 2,
						margin: 5
					},
					1104: {
						items: 3
					}
				},
				autoWidth: false,
				loop: false,
				//rewind: true, // Раскомментировать эту строку и закомментировать loop: true, если нужно, чтобы карусель не зацикливалась, а докручивалась до конца и возвращалась к началу
				dots: false,
				nav: true,
				navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>']
			});

		$("#myModal").owlCarousel({
			responsive: {
				0: {
					margin: 6
				},
				768: {
					margin: 10
				}
			},
			autoWidth: true,
			loop: $("#myModal").data("loop"),
			center: true,
			items:1,
			//rewind: false, // Раскомментировать эту строку и закомментировать loop: true, если нужно, чтобы карусель не зацикливалась, а докручивалась до конца и возвращалась к началу
			dots: true,
			nav: true,
			navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>']
		});

		$owlOne.owlCarousel({
			items: 1,
			rewind: true,
			dots: false,
			nav: true,
			navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>']
		});

		$owlTwo.owlCarousel({
			responsive: {
				0: {
					items: 1
				},
				768: {
					items: 2,
					margin: 24
				},
				1104: {
					items: 2,
					margin: 32
				}
			},
			rewind: true,
			dots: false,
			nav: true,
			navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>']
		});

		$owlDef.owlCarousel({
			responsive: {
				0: {
					margin: 6,
					items: 1,
				},
				768: {
					margin: 10,
					items: 2
				}
			},
			// rewind: true,
			dots: false,
			nav: true,
			loop:false,
			navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>'],
			onInitialized: function(e) {
				var items_length = this.items().length;
				if (items_length < 3) {
					$(this.$stage).addClass('maxwidth');
				}
			}
		});

		$owlDefAbout.owlCarousel({
			responsive: {
				0: {
					margin: 6,
					items: 1
				},
				768: {
					margin: 10,
					items: 2
				}
			},
			rewind: true,
			dots: false,
			nav: true,
			navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>']
		});

		$owlTwoNospace.owlCarousel({
			responsive: {
				0: {
					items: 1
				},
				768: {
					items: 2
				},
				1104: {
					items: 2
				}
			},
			rewind: true,
			dots: false,
			nav: true,
			navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>']
		});

		$owlThree.owlCarousel({
			responsive: {
				0: {
					items: 1
				},
				768: {
					items: 2,
					margin: 24
				},
				1104: {
					items: 3,
					margin: 32
				}
			},
			rewind: true,
			dots: false,
			nav: true,
			navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>']
		});

		if ($slider.length) {
			$slider
				.superslides({
					animation: 'fade',
					pagination: false,
					play: 5000
				})
				.touchwipe({
					wipeLeft: function () {
						$slider.find('.next').trigger('click');
					},
					wipeRight: function () {
						$slider.find('.prev').trigger('click');
					},
					min_move_x: 20,
					min_move_y: 20,
					preventDefaultEvents: false
				});
			$slider.find('.slides-item-nav a').on('click', function (e) {
				e.preventDefault();
				$slider.superslides('stop');
				if ($(this).hasClass('slides-item-prev-link')) {
					$slider.superslides('animate', 'prev');
				} else if ($(this).hasClass('slides-item-next-link')) {
					$slider.superslides('animate', 'next');
				}
			});
		}

		if (this.$window.width() < 768) {
			$owlNoMobile.addClass('off');
		} else {
			$owlNoMobile.owlCarousel(owlNoMobileOptions);
		}

		this.$window.on('resize', function () {
			var $owl;
			if (Layout.$window.width() < 768) {
				$owl = $owlNoMobile.not('.off');
				$owl.addClass('off').trigger('destroy.owl.carousel');
				$owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
			} else {
				$owl = $owlNoMobile.filter('.off');
				$owl.owlCarousel(owlNoMobileOptions);
				$owl.removeClass('off');
			}
		});

		if ($productMain.length || $productThumbs.length) {
			$productMain
				.owlCarousel({
					items: 1,
					dots:false,
					rewind: false,
					slideBy: 1,
					animateOut: 'fadeOut'
				})
				.on('changed.owl.carousel', function (e) {
					$productThumbs.trigger('to.owl.carousel', [e.item.index, 300, true]);
					$productThumbs.find('.owl-item').removeClass('current');
					$productThumbs.find('.owl-item').eq(e.item.index).addClass('current');
				});
			$productThumbs
				.owlCarousel({
					responsive: {
						0: {
							items: 3
						},
						768: {
							items: 4
						}
					},

					dots: false,
					rewind: false,
					mouseDrag: false,
					slideBy: 1,
					nav: true,
					navText: ['<i class="icon icon-triangle-left"></i>', '<i class="icon icon-triangle-right"></i>'],
					onInitialized: function () {
						$productThumbs.find('.owl-item:first').addClass('current');
					}
				})
				.on('click', '.owl-item', function () {
					$productMain.trigger('to.owl.carousel', [$(this).index(), 300, true]);
				})
				.on('click', '.owl-nav .owl-next', function () {
					$productThumbs.trigger('next.owl');
					$productMain.trigger('next.owl');
				})
				.on('click', '.owl-nav .owl-prev', function () {
					$productThumbs.trigger('prev.owl');
					$productMain.trigger('prev.owl');
				})
		}
	};
	Layout.accordions = function () {
		this.$doc.find('.js-accordion').each(function () {
			var $this = $(this),
				row = '.accordion-row',
				link = '.accordion-row-title',
				body = '.accordion-row-body';
			$this.find(link).on('click touchend', function (e) {
				e.preventDefault();
				var $row = $(this).closest(row);
				if ($row.hasClass('animating')) return;
				$row.addClass('animating');
				if ($row.hasClass('active')) {
					$row.find(body).stop().slideUp(300, function () {
						$row.removeClass('active animating');
					});
				} else {
					if ($this.data('single')) {
						$this.find(row + '.active').find(body).stop().slideUp(300, function () {
							$(this).closest(row).removeClass('active animating');
						});
					}
					$row.find(body).stop().slideDown(300, function () {
						$row.removeClass('animating');
						$row.addClass('active');
						this.style.height = 'auto';
					});
				}
			})
		});
	};
	/**
	 * Для разработчика
	 *
	 */
	Layout.Cart = {
		selector: '#addToCart',
		templates: {
			linked: '<div class="modal-buy-linked-item">\n' +
				'    <a href="__url__" class="modal-buy-linked-item-pic">\n' +
				'        <img src="__picture__" alt="">\n' +
				'    </a>\n' +
				'    <div class="modal-buy-linked-item-title"><a href="__url__">__title__</a></div>\n' +
				'    <div class="modal-buy-linked-item-bottom">\n' +
				'        <span class="modal-buy-linked-item-price">__price__ ₽</span>\n' +
				'        <div class="modal-buy-linked-item-buy">\n' +
				'            <a href=""><i class="icon icon-bag"></i></a>\n' +
				'        </div>\n' +
				'    </div>\n' +
				'</div>',
			inform: '<div class="infographic">\n' +
				'    <div class="infographic-col">\n' +
				'        <div class="h1 infographic-title">__title__</div>\n' +
				'        <div class="infographic-text">__text__</div>\n' +
				'        <a href="__url__" class="infographic-link btn btn-transparent"><i class="icon icon-arrow-left"></i> подробнее</a>\n' +
				'    </div>\n' +
				'</div>'
		},
		/**
		 * Здесь обрабатывается добавление товара в корзину.
		 * Если добавление удалось, возвращать массив данных для модалки
		 * Если нет, false
		 *
		 * @param id
		 * @param count
		 */
		add: function (id, count) {
			// data - временный объект! здесь должен быть код разработчика, формирующий data
			var data = {
				item: {
					id: id,
					title: 'Ваза модерн',
					price: '20 000',
					picture: 'assets/images/product-1.png',
					url: 'catalog_item.html',
					count: count
				},
				linked: [
					{id: 1, title: 'Членистоногий декор', price: '20 000', picture: 'assets/images/product-1.jpg', url: 'catalog_item.html'},
					{id: 1, title: 'Подставка', price: '20 000', picture: 'assets/images/product-3.jpg', url: 'catalog_item.html'},
					{id: 1, title: 'Черепаха', price: '20 000', picture: 'assets/images/product-2.jpg', url: 'catalog_item.html'},
					{id: 1, title: 'Пика', price: '20 000', picture: 'assets/images/product-1.png', url: 'catalog_item.html'}
				],
				inform: {
					title: 'Монтаж',
					text: 'Специалисты ProExpert могут быстро и качественно выполнить монтаж любого унастенного оборудования и оптимизировать его работу!',
					url: ''
				}
			};
			return Layout.Cart.showModal(data);
		},
		/**
		 *
		 */
		error: function () {
			// например, вывести сообщение об ошибке
		},
		/**
		 * Получаем объект из метода Layout.Cart.Add, парсим его и выводим модалку
		 *
		 * @param data
		 */
		showModal: function (data) {
			$.fancybox.close();
			var $modal = Layout.$doc.find(Layout.Cart.selector);
			$modal.find('[data-main-name]').text(data.item.title);
			$modal.find('[data-main-price]').text(data.item.price);
			$modal.find('[data-main-picture]').attr('src', data.item.picture);
			$modal.find('[data-main-url]').attr('href', data.item.url);
			$modal.find('[data-main-count]').val(data.item.count);
			if (data.linked !== undefined) {
				var linkedTpl = '';
				for (var i = 0; i < data.linked.length; i++) {
					var item = data.linked[i],
						itemTpl = Layout.Cart.templates.linked;
					for (var k in item) {
						if (!item.hasOwnProperty(k)) continue;
						itemTpl = itemTpl.replace('__' + k + '__', item[k]);
					}
					linkedTpl += itemTpl;
				}
				$modal.find('[data-add-linked]').html(linkedTpl);
				$modal.find('[data-add-title]').removeClass('hidden');
			}
			if (data.inform !== undefined) {
				var inform = data.inform,
					informTpl = Layout.Cart.templates.inform;
				for (var key in inform) {
					if (!inform.hasOwnProperty(key)) continue;
					informTpl = informTpl.replace('__' + key + '__', inform[key]);
				}
				$modal.find('[data-add-inform]').html(informTpl);
			}
			$.fancybox.open({
				src: $modal,
				type: 'inline',
				animationEffect: 'fade',
				baseClass: 'modal-fullscreen',
				margin: [0, 0],
				afterClose: Layout.Cart.resetModal
			});
		},
		/**
		 *
		 */
		resetModal: function () {
			var $modal = Layout.$doc.find(Layout.Cart.selector);
			$modal.find('[data-main-title], [data-main-price], [data-add-linked], [data-add-inform]').html('');
			$modal.find('[data-main-picture]').attr('src', '');
			$modal.find('[data-main-url]').attr('href', '');
			$modal.find('[data-main-count]').val(1);
			$modal.find('[data-add-title]').addClass('hidden');
		}
	};
	Layout.initialize();
	window.Layout = Layout;

	var	arCatalogTabs = document.querySelectorAll('.catalog-tabs');

	if (arCatalogTabs.length)
		for(var i = 0; i < arCatalogTabs.length; i++)
			arCatalogTabs[i].onclick = function() {
				var	arCatTab = document.querySelectorAll('.catalog-tabs'),
					arCatTabs = document.querySelectorAll('.catalog-tab'),
					curId = this.getAttribute('data-id');
				$.cookie('catab', curId);

				for(var j = 0; j < arCatTabs.length; j++) {
					if (curId == arCatTabs[j].getAttribute('data-id'))
						arCatTabs[j].style.display = '';
					else
						arCatTabs[j].style.display = 'none';
				}

				for(var j = 0; j < arCatTab.length; j++) {
					if (arCatTab[j] == this)
						arCatTab[j].classList.remove('btn-white');
					else
						arCatTab[j].classList.add('btn-white');
				}
			};

	$('#product_designer_more').on("click", function() {
		var	childs = $('#product_designer').children(),
			countProd = childs.length,
			countShow = 100,
			countCur = 0, countAll = 0;
		for(var i = 0; i < countProd; i++) {
			if (childs[i].style.display == 'none') {
				if (countAll <= countShow) {
					childs[i].style.display = '';
					countCur++;
				}

				countAll++;
			}
		}

		if (countAll <= countShow)
			this.style.display = 'none';

		return false;
	});
}) (window, document, jQuery);

$('.owl-item-my').on('click', function() {
	$("#myModal").css("visibility", "visible");
	$(".close").css("display", "block");
});

$("span.close").click(function(){
	$("#myModal").css("visibility", "hidden");
	$(".close").css("display", "none");
});

const btnMenu = document.querySelector('.header-top-icons');
const menu = document.querySelector('.form-header-input');
const toggleMenu = function() {
	menu.classList.toggle('is-active');
};

if(btnMenu) {
	btnMenu.addEventListener('click', function(e) {
		e.stopPropagation();
		toggleMenu();
	});
}


document.addEventListener('click', function(e) {
	const target = e.target;
	const its_menu = target == menu || menu.contains(target);
	const its_btnMenu = target == btnMenu;
	const menu_is_active = menu.classList.contains('is-active');

	if (!its_menu && !its_btnMenu && menu_is_active) {
		toggleMenu();
		$(".header_input").val("");
		$(".live-search").remove();
	}
});

const mobileButtonMenu = document.querySelector('.is-mobile-menu-trigger');
const mobileMenu = document.querySelector('.header-menu-container');
const mobileTriggerMenu = document.querySelector('.header-menu-trigger');
const searchInputField = document.querySelector('.form-header-input');

const toggleMobileMenu = function() {
	 mobileMenu.classList.toggle('is-active');
	 mobileButtonMenu.classList.toggle('is-active');
	 mobileTriggerMenu.classList.toggle('is-active');
	 searchInputField.classList.remove('is-active');
};

if (mobileButtonMenu) {
	mobileButtonMenu.addEventListener('click', function(e) {
		e.stopPropagation();
		toggleMobileMenu();
	});
}

$(".header_input").on('change keyup paste', function() {
	if($(".header_input").val().length >= 3){
		$(".input_search_change").css({display:'block'})
	}else{
		$(".input_search_change").css({display:'none'})
	}
});

$(".search_input_close").on("click",function(){
	$(".header_input").val("");
	$(".header-top-icons-search").addClass("is-active");
});

if (jQuery(window).width() > 1103 ) {
	const childBtnMenuDesctop = document.querySelector('.js-submenu');
	const childMenuDesctop = document.querySelector('.child-menu');
	const childMenuDesctopDropdownIcon = document.querySelector('.menu-dropdown');

	const toggleChildMenuDesctop = function() {
		childMenuDesctop.classList.toggle('is-active');
		childMenuDesctopDropdownIcon.classList.toggle('is-active');
		childBtnMenuDesctop.classList.toggle('is-active');
	};

	if (childBtnMenuDesctop) {
		childBtnMenuDesctop.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			toggleChildMenuDesctop();
			childBtnMenuDesctop.addEventListener('click', function(e) {
				if(!childMenuDesctop.classList.contains('is-active')) {
					location.href = '/catalog/';
				}
			});
		});
	}

	document.addEventListener('click', function(e) {
		const target = e.target;
		const its_menu = target == childMenuDesctop || childMenuDesctop.contains(target);
		const its_btnMenu = target == childBtnMenuDesctop;
		const menu_is_active = childMenuDesctop.classList.contains('is-active');

		if (!its_menu && !its_btnMenu && menu_is_active) {
			toggleChildMenuDesctop();
		}
	});
} else {
	const childBtnMenu = document.querySelector('.js-submenu');
	const childMenu = document.querySelector('.child-menu');
	const childMenuMobileDropdownIcon = document.querySelector('.menu-dropdown');
	const toggleChildMenu = function() {
		childMenu.classList.toggle('is-active');
		childMenuMobileDropdownIcon.classList.toggle('is-active');
	};

	childBtnMenu.addEventListener('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		toggleChildMenu();
		childBtnMenu.addEventListener('click', function(e) {
			location.href = '/catalog/';
		});
	});
}

$(".search_input_close,.fon_input").on("click",function(){
	$(".fon_input").css({display:'none'})
});

$(".header-menu-trigger").on("click",function(){
	$(".header-base-logo").css({zIndex:'-1'});
	$(".header-top-cart,.header-top-icons").css({zIndex:'-1'});
});

$(".header-menu-close").on("click",function(){
	$(".header-base-logo").css({zIndex:'30'});
	$(".header-top-cart,.header-top-icons").css({zIndex:'28'});
});

$(function() {
	// Открыть/закрыть категории на мобильных устройствах
	var widthWindow = $(window).width();

	$(window).on('resize', function(){
		widthWindow = $(window).width();
	});

	if($('.js-catalog-category-default').length){
		$('.js-catalog-category-default').on('click', function(e) {
			if(widthWindow < 768){
				e.preventDefault();
				$('.js-catalog-category').removeClass('active');
				$(this).closest('.js-catalog-category').addClass('active');
			}
		});
	}

	$(document).on('click', function(event) {
		if ($(event.target).closest(".js-catalog-category").length) return;
		$('.js-catalog-category').removeClass('active');
		event.stopPropagation();
	});

	// Прокрутка страницы после сортировки
	if($('.js-filters-sort').length){
		if($('.js-filters-sort').data('sort') == true){
			var posSort = $('.js-filters-sort').offset().top - $('.header').outerHeight() - 40;

			$(window).on('resize', function(){
				posSort = $('.js-filters-sort').offset().top - $('.header').outerHeight() - 40;
			});
		
			$(document).scrollTop(posSort);
		}
	}

	// Прокрутка страницы после показать по
	if($('.js-cat-page-count').length){
		if($('.js-cat-page-count').hasClass('is-active')){
			var posPageCount = $('.js-cat-page-count').offset().top - $('.header').outerHeight() - 80;

			$(window).on('resize', function(){
				posPageCount = $('.js-cat-page-count').offset().top - $('.header').outerHeight() - 80;
			});
		
			$(document).scrollTop(posPageCount);
		}
	}
});

// Закрыть fancybox по тени
// $('[data-fancybox="carousel"]').on('click', function(event) {

// 	console.log('22222');
// 	console.log($('.fancybox-slide--image').length);

// 	$('.fancybox-slide--image').on('touchend', function(event) {
// 		if(widthWindow < 768){
// 			if ($(event.target).closest(".fancybox-slide--image").length) return;
// 			$.fancybox.close();
// 			event.stopPropagation();
// 		}
// 	});
	
	
// 	// $('.fancybox-slide--image').on('click touchend', function(event) {
// 	// 	console.log('11111');
// 	// 	// $.fn.fancybox.close();
// 	// 	$.fancybox.close();
// 	// });

// 	// $('.fancybox-image-wrap').on('touchend', function(event) {
// 	// 	console.log('3333');
// 	// 	event.preventDefault();
// 	// });
// });
