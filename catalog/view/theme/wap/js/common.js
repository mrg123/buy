$(function() {
    //	create the menus
	var js_url = $('#js_url');
    $('#menu').mmenu({
"navbar" : false, // 隐藏头部的导航
		"slidingSubmenus": true,  // false 向下展开, true向右展开
		"extensions": [
                  "fx-panels-zoom",		//向右展开带有缩收效果
				  "pagedim-black"		// 展开,右侧加黑影
               ],
		"navbars": [
                  {
                     "position": "bottom",
                     "content": [
                        "<a class='fa fa-envelope' href='/index.php?route=information/contact'></a>"
                       
                     ]
                  }
				  ] 
	});

    $('#shoppingbag').mmenu({
        navbar: {
            title: 'Shopping Cart'
        },
        extensions: [
            "pagedim-black"		// 展开,右侧加黑影
        ],
        offCanvas: {
            position: 'right'
        }
    });

    //	fire the plugin
    $('.mh-head.first').mhead({
        scroll: true
    });
    $('.mh-head.second').mhead({
        scroll: true
    });

    var api = $('#shoppingbag').data('mmenu');
    var open_validate = true;
    api.bind('open:start', function () {
		var url = 'index.php?route=common/cart/get_cart';
        if(open_validate) {
            $.ajax({
                type: 'post',
                url: url,
				beforeSend: function(){
                open_validate = false;
                var loading = '<div class="mm-navbar"><a class="mm-title">Loading...</a></div>';
                loading += '<div class="loaders"><div class="loader"> <div class="loader-inner ball-pulse"> <div></div> <div></div> <div></div> </div> </div> </div>';
                    $('#bag-content').html(loading);
				},
                dataType: 'json',
				complete: function(){
					open_validate = true;
				},
                success: function (json) {

var _html = '<div class="mm-navbar"><a class="mm-title">Shopping Cart</a></div>';
					if(json.state){
                        _html += '<div class="btn-group btn-block"> <ul id="cart">';
                        _html += '<div class="cart-bg"><div class="loaders"><div class="loader"> <div class="loader-inner ball-pulse"> <div></div> <div></div> <div></div> </div> </div> </div></div>';
$.each(json.products,function(k,v){
    _html += '<li>';
    _html += '<a href="'+v.href+'">';
    _html += '<img src="'+v.thumb+'" width="80" />';
    _html += '</a>';
    _html += '<div class="del" cart-id="'+v.cart_id+'" product-id="'+v.product_id+'"><i class="icon iconfont icon-lajitong"></i></div><div class="price">';
    _html += '<p>'+v.name+'</p>';
    _html += '<span class="price-new">'+v.price+'</span>';
    _html += '</div><div class="info"><span class="numless">&nbsp; </span><span class="numqty"><input name="quantity" value="'+v.quantity+'" size="2" class="input-quantity" type="text" readonly ></span><span class="numadd"> &nbsp; </span></div></li>';
});
						_html += '<div class="col-xs-12" id="cart-checkout"><div class="col-xs-7">Total <span class="total">'+json.total+'</span></div><div class="col-xs-5"><a href="'+js_url.attr('checkout')+'" >Checkout</a></div></div>';
						_html += '</ul></div>';

					}else{
						_html = '<div class="col-xs-12 empty"></div><a href="'+js_url.attr('home')+'" class="go-shopping">Go Shopping</a>';

					}
                    $('#bag-content').html(_html);
                }
            });
        }

		var validate1 = true;
        $('body').on('click','#cart .numadd',function(){
        	var qt = $(this).prev('.numqty').children('input[name=\'quantity\']');
            var quantity = qt.val();
            quantity++;
            qt.val(quantity);

            /* var price = $(this).parent().parent().find('.price-new').html().substr(1);
			var total = $('#cart-checkout').find('.total').html().substr(1);
			var currency = $('#cart-checkout').find('.total').html().substr(0,1);
			var new_total = currency + ((parseFloat(total)*100 + parseFloat(price)*100)/100).toFixed(2);
            $('#cart-checkout').find('.total').html(new_total);*/

            var product_id = $(this).parent().parent().find('.del').attr('product-id');

            if(validate1) {
                $.ajax({
                    url: 'index.php?route=common/cart/add',
                    type: 'post',
                    data: 'product_id=' + product_id + '&quantity=1',
                    dataType: 'json',
                    beforeSend: function () {
                        validate1 = false;
						$('.cart-bg').show();
                        $('#cart-checkout').find('.total').html('Loading');
                    },
                    complete: function () {
                        validate1 = true;
                        $('.cart-bg').hide();
                    },
                    success: function (json) {

                        if (json['redirect']) {
                            var location = json['redirect'];
                            window.location.href = location;
                        }

                        if (json['success']) {
                            // Need to set timeout otherwise it wont update the total
                            setTimeout(function () {
                                $('#cart-checkout').find('.total').html(json['total']);
                            }, 100);
							getTotal();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
				
            }
		});
		
		var validate2 = true;
        $('body').on('click','#cart .numless',function(){
            var qt = $(this).next('.numqty').children('input[name=\'quantity\']');
            var oldValue = qt.val();
            oldValue--;
            if(oldValue<1){
                oldValue = 1;
            }else{
                /* var price = $(this).parent().parent().find('.price-new').html().substr(1);
                var total = $('#cart-checkout').find('.total').html().substr(1);
                var currency = $('#cart-checkout').find('.total').html().substr(0,1);
                var new_total = currency + ((parseFloat(total)*100 - parseFloat(price)*100)/100).toFixed(2);
                $('#cart-checkout').find('.total').html(new_total); */


                var cart_id = $(this).parent().parent().find('.del').attr('cart-id');

                if(validate2) {
                    $.ajax({
                        url: 'index.php?route=common/cart/update',
                        type: 'post',
                        data: 'key=' + cart_id + '&quantity=' + (typeof(oldValue) != 'undefined' ? oldValue : 1),
                        dataType: 'json',
                        beforeSend: function () {
                            validate2 = false;
                            $('.cart-bg').show();
                            $('#cart-checkout').find('.total').html('Loading');
                        },
                        complete: function () {
                            validate2 = true;
                            $('.cart-bg').hide();
                        },
                        success: function (json) {
                           $('#cart-checkout').find('.total').html(json['total']);
						   getTotal();
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }

			}
            qt.val(oldValue);
			
        });
		
		var validate3 = true;
        $('body').on('click','#cart .del',function(){
            var price = $(this).parent().find('.price-new').html().substr(1);
			
            /* var total = $('#cart-checkout').find('.total').html().substr(1);
            var currency = $('#cart-checkout').find('.total').html().substr(0,1);
            var quantity = $(this).parent().find('.input-quantity').val();
            var new_total = currency + ((parseFloat(total)*100 - parseFloat(price)*100*quantity)/100).toFixed(2);
            $('#cart-checkout').find('.total').html(new_total);*/
			var total = '';
			$(this).parent().remove();

                $.ajax({
                    url: 'index.php?route=common/cart/remove',
                    type: 'post',
                    data: 'key=' + $(this).attr('cart-id'),
                    dataType: 'json',
                    beforeSend: function() {
                        validate3 = false;
                        $('.cart-bg').show();
                        $('#cart-checkout').find('.total').html('Loading');
                    },
                    complete: function() {
                        validate3 = true;
                        $('.cart-bg').hide();
                    },
                    success: function(json) {
						total = $json['total'];
                        $('#cart-checkout').find('.total').html($json['total']);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });

            if(total.substr(1)==0){
                var _html = '<div class="col-xs-12 empty"></div><a href="'+js_url.attr('home')+'" class="go-shopping">Go Shopping</a>';
                $('#bag-content').html(_html);
            }
			getTotal();
		});

    });

	$('.totop').click(function(){
		$('html,body').animate({
			scrollTop:'0px'
		},500);
	});
	
	getTotal();
});

		function getTotal(){
			$.post('index.php?route=common/cart/getCount',function(json){
			$('#count-cart').html(json['total']);		
			});
		}
		

function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

$(document).ready(function() {
	
	/* Search */
	$('#search input[name=\'search\']').parent().find('.fa-search').on('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';

		var value = $('#search input[name=\'search\']').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}
	
		location = url;
	});

	$('#search input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$('#search input[name=\'search\']').parent().find('.fa-search').trigger('click');
		}
	});
	
	// Currency
	$('#currency .currency-select').on('click', function(e) {
		e.preventDefault();

		$('#currency input[name=\'code\']').attr('value', $(this).attr('name'));

		$('#currency').submit();
	});

	// Language
	$('#language a').on('click', function(e) {
		e.preventDefault();

		$('#language input[name=\'code\']').attr('value', $(this).attr('href'));

		$('#language').submit();
	});
	
	
	// Menu
	$('#menu .dropdown-menu').each(function() {
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();

		var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});
	
	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();

		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});



	// Product List
	$('#list-view').click(function() {
		$('#content .product-grid > .clearfix').remove();

		//$('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');
		$('#content .row > .product-grid').attr('class', 'product-layout product-list col-xs-12');

		localStorage.setItem('display', 'list');
	});

	// Product Grid
	$('#grid-view').click(function() {
		// What a shame bootstrap does not take into account dynamically loaded columns
		cols = $('#column-right, #column-left').length;

		if (cols == 2) {
			$('#content .product-list').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
		} else if (cols == 1) {
			$('#content .product-list').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
		} else {
			$('#content .product-list').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
		}

		 localStorage.setItem('display', 'grid');
	});

	if (localStorage.getItem('display') == 'list') {
		$('#list-view').trigger('click');
	} else {
		$('#grid-view').trigger('click');
	}

	// Checkout
	$(document).on('keydown', '#collapse-checkout-option input[name=\'email\'], #collapse-checkout-option input[name=\'password\']', function(e) {
		if (e.keyCode == 13) {
			$('#collapse-checkout-option #button-login').trigger('click');
		}
	});

	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});

	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});
});

// Cart add remove functions
var cart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				$('.alert, .text-danger').remove();

				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					// Need to set timeout otherwise it wont update the total
					setTimeout(function () {
						$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
					}, 100);

					$('html, body').animate({ scrollTop: 0 }, 'slow');

					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	},
	'update': function(key, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	}
}

var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	}
}

var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();

				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				$('#wishlist-total span').html(json['total']);
				$('#wishlist-total').attr('title', json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	},
	'remove': function() {

	}
}

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('#compare-total').html(json['total']);

					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
		});
	},
	'remove': function() {

	}
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function(e) {
	e.preventDefault();

	$('#modal-agree').remove();

	var element = this;

	$.ajax({
		url: $(element).attr('href'),
		type: 'get',
		dataType: 'html',
		success: function(data) {
			html  = '<div id="modal-agree" class="modal">';
			html += '  <div class="modal-dialog">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">';
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
			html += '      </div>';
			html += '      <div class="modal-body">' + data + '</div>';
			html += '    </div';
			html += '  </div>';
			html += '</div>';

			$('body').append(html);

			$('#modal-agree').modal('show');
		}
	});
});

// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			}

			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}

					// Get all the ones with a categories
					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			}

			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

		});
	}
})(window.jQuery);
