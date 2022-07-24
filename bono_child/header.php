<?php

use Wpshop\Core\Advertising;
use Wpshop\Core\Core;
use Wpshop\TheTheme\ThemeProvider;

$core        = theme_container()->get( Core::class );
$advertising = theme_container()->get( Advertising::class );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>


<script>

function jidfb6723() {
	if (document.getElementById('primary') !== null) {
		document.getElementById('primary').setAttribute('style', 'opacity: 1 !important;');
	} else {
		setTimeout(jidfb6723, 10);
	}
}
if (window.location.pathname.indexOf('/checkout/order-received/') == -1) {setTimeout(jidfb6723, 100);}

// function asd12() {
// 	if (document.getElementsByClassName('woocommerce-order-details__title')[0].innerHTML == 'Tellimuse info') {
// 		setTimeout(function(){document.getElementById('primary').setAttribute('style', 'opacity: 1 !important; transition: 200ms;');}, 500);
// 	}
// }
function edfjgniu3h() {
	if (document.getElementById('primary') !== null) {
		setTimeout(function(){document.getElementById('primary').setAttribute('style', 'opacity: 1 !important; transition: 200ms;');}, 500);
	} else {
		setTimeout(edfjgniu3h, 10);
	}
}
if (window.location.pathname.indexOf('/checkout/order-received/') !== -1) {setTimeout(edfjgniu3h, 100);}
</script>




<!-- 	<script>
		window.onerror = function (msg, url, line) {
			alert(msg + "\n" + url + "\n" + "\n" + line);
			return true;
		};
	</script> -->
    <style id="stylepood"></style>
    <script>
    if (window.location.pathname == '/en/shop/') {
    document.getElementById('stylepood').innerHTML = '.page-title {opacity: 0; transition: 500ms;}';
	document.onload = setTimeout(function(){
	        if (document.getElementsByClassName('page-title')[0].innerHTML == 'Магазин') {
	            document.getElementsByClassName('page-title')[0].innerHTML = 'Shop';
	    		document.getElementsByClassName('page-title')[0].setAttribute('style', 'opacity: 1 !important;');
	    	}
	}, 1200);}
    if (window.location.pathname == '/shop/') {
    document.getElementById('stylepood').innerHTML = '.page-title {opacity: 0; transition: 500ms;}';
	document.onload = setTimeout(function(){
	        if (document.getElementsByClassName('page-title')[0].innerHTML == 'Магазин') {
	    		document.getElementsByClassName('page-title')[0].setAttribute('style', 'opacity: 1 !important;');
	    	}
	}, 1200);}
        if (window.location.pathname.substr(0, 9) == '/ee/shop/') {
            document.getElementById('stylepood').innerHTML = '.page-title {opacity: 0; transition: 500ms;}';
	document.onload = setTimeout(function(){
	                for (var i = 0; i < document.getElementsByClassName('product-category').length; i++) {
                if (document.getElementsByClassName('product-category')[i].getElementsByTagName('img')[0].getAttribute('alt') == 'Second hand') {
                    document.getElementsByClassName('product-category')[i].outerHTML = '';
                }
            }
            for (var i = 0; i < document.getElementsByClassName('shop-item').length; i++) {
                if (document.getElementsByClassName('shop-item')[i].getElementsByTagName('a')[1].innerHTML == 'Life Clinic' || document.getElementsByClassName('shop-item')[i].getElementsByTagName('a')[1].innerHTML == 'Life clinic') {
                    document.getElementsByClassName('shop-item')[i].outerHTML = '';
                }
            }
	        if (document.getElementsByClassName('page-title')[0].innerHTML == 'Магазин') {
	    		document.getElementsByClassName('page-title')[0].innerHTML = 'Pood';
	    		document.getElementsByClassName('page-title')[0].setAttribute('style', 'opacity: 1 !important;');
	    	}
	}, 1200);
	function shopLoopEe() {

    for (var i = 0; i < document.getElementsByClassName('product-category').length; i++) {
        if (document.getElementsByClassName('product-category')[i].getElementsByTagName('img')[0].getAttribute('alt') == 'Second hand') {
            document.getElementsByClassName('product-category')[i].outerHTML = '';
        }
        if (document.getElementsByClassName('product-category')[i].getElementsByTagName('img')[0].getAttribute('alt') == 'Life clinic') {
            document.getElementsByClassName('product-category')[i].outerHTML = '';
        }
    }
    for (var i = 0; i < document.getElementsByClassName('product-category').length; i++) {
            if (document.getElementsByClassName('product-category')[i].getElementsByTagName('img')[0].getAttribute('alt') == 'Life clinic') {
                document.getElementsByClassName('product-category')[i].outerHTML = '';
            }
        }
		setTimeout(shopLoopEe, 50);
	}
	window.onload = setTimeout(shopLoopEe, 100);
}

if (window.location.pathname.substr(0, 9) == '/shop/') {
    function shopLoopRu() {
        if (document.getElementsByClassName('post-1017')[0] !== undefined) {
            if (document.getElementsByClassName('post-1017')[0].getElementsByClassName('shop-item__title')[0].getElementsByTagName('a')[0].innerHTML == 'Life Clinic') {
                document.getElementsByClassName('post-1017')[0].outerHTML = '';
            }
        }

        for (var i = 0; i < document.getElementsByClassName('product-category').length; i++) {
            if (document.getElementsByClassName('product-category')[i].getElementsByTagName('img')[0].getAttribute('alt') == 'Second hand') {
                document.getElementsByClassName('product-category')[i].outerHTML = '';
            }
        }
        for (var i = 0; i < document.getElementsByClassName('product-category').length; i++) {
            if (document.getElementsByClassName('product-category')[i].getElementsByTagName('img')[0].getAttribute('alt') == 'Life clinic') {
                document.getElementsByClassName('product-category')[i].outerHTML = '';
            }
        }
        for (var i = 0; i < document.getElementsByClassName('shop-item').length; i++) {
                if (document.getElementsByClassName('shop-item')[i].getElementsByTagName('a')[1].innerHTML == 'Life Clinic' || document.getElementsByClassName('shop-item')[i].getElementsByTagName('a')[1].innerHTML == 'Life clinic') {
                    document.getElementsByClassName('shop-item')[i].outerHTML = '';
                }
            }
        setTimeout(shopLoopRu, 10);
    }
    window.onload = setTimeout(shopLoopRu, 100);
}

if (window.location.pathname.substr(0, 9) == '/en/shop/') {
    function shopLoopEn() {
        if (document.getElementsByClassName('post-1920')[0] !== undefined) {
            if (document.getElementsByClassName('post-1920')[0].getElementsByClassName('shop-item__title')[0].getElementsByTagName('a')[0].innerHTML == 'Life Clinic') {
                document.getElementsByClassName('post-1920')[0].outerHTML = '';
            }
        }

        for (var i = 0; i < document.getElementsByClassName('product-category').length; i++) {
            if (document.getElementsByClassName('product-category')[i].getElementsByTagName('img')[0].getAttribute('alt') == 'Second hand') {
                document.getElementsByClassName('product-category')[i].outerHTML = '';
            }
        }
        for (var i = 0; i < document.getElementsByClassName('product-category').length; i++) {
            if (document.getElementsByClassName('product-category')[i].getElementsByTagName('img')[0].getAttribute('alt') == 'Life clinic') {
                document.getElementsByClassName('product-category')[i].outerHTML = '';
            }
        }
        for (var i = 0; i < document.getElementsByClassName('shop-item').length; i++) {
                if (document.getElementsByClassName('shop-item')[i].getElementsByTagName('a')[1].innerHTML == 'Life Clinic' || document.getElementsByClassName('shop-item')[i].getElementsByTagName('a')[1].innerHTML == 'Life clinic') {
                    document.getElementsByClassName('shop-item')[i].outerHTML = '';
                }
            }
        setTimeout(shopLoopEn, 10);
    }
    window.onload = setTimeout(shopLoopEn, 100);
}

function cartEmptyLoopEe() {
	if (document.getElementsByClassName('woocommerce-message').length > 0) {
		if (document.getElementsByClassName('woocommerce-message')[0].innerText.indexOf('удалён') !== -1) {
			document.getElementsByClassName('woocommerce-message')[0].innerHTML = document.getElementsByClassName('woocommerce-message')[0].innerHTML.replace('удалён', 'kustutatud');
		}
		if (document.getElementsByClassName('woocommerce-message')[0].innerText.indexOf('Отменить') !== -1) {
			document.getElementsByClassName('woocommerce-message')[0].innerHTML = document.getElementsByClassName('woocommerce-message')[0].innerHTML.replace('Отменить', 'Tühistama');
		}
	}
	if (document.getElementsByClassName('cart-empty woocommerce-info').length > 0) {
		if (document.getElementsByClassName('cart-empty woocommerce-info')[0].innerText == 'Your cart is currently empty.') {
			document.getElementsByClassName('cart-empty woocommerce-info')[0].innerText = 'Teie ostukorv on praegu tühi.';
		}
	}
	if (document.getElementsByClassName('button wc-backward').length > 0) {
		if (document.getElementsByClassName('button wc-backward')[0].innerText == 'Return to shop') {
			document.getElementsByClassName('button wc-backward')[0].innerText = 'Tagasi poodi';
		}
		if (document.getElementsByClassName('button wc-backward')[0].getAttribute('href').indexOf('/ee/shop/') == -1) {
			document.getElementsByClassName('button wc-backward')[0].setAttribute('href', document.getElementsByClassName('button wc-backward')[0].getAttribute('href').replace('/shop/', '/ee/shop/'));
		}
	}
	setTimeout(cartEmptyLoopEe, 10);
}
if (window.location.pathname == '/ee/cart/') {
	setTimeout(cartEmptyLoopEe, 100);
}

if (window.location.pathname == '/ee/cart/') {
	function eeCartLoop() {
		if (document.getElementsByClassName('product-name').length > 0) {
			setTimeout(function(){
				if (document.getElementsByClassName('woocommerce-message')[0] !== undefined) {
					if (document.getElementsByClassName('woocommerce-message')[0].innerHTML == '\n\t\tКорзина обновлена.\t') {
						document.getElementsByClassName('woocommerce-message')[0].innerHTML = 'Ostukorv uuendatud';
					}
				}
				document.getElementsByClassName('product-name')[0].innerHTML = 'Toode';
				document.getElementsByClassName('product-price')[0].innerHTML = 'Hind';
				document.getElementsByClassName('product-quantity')[0].innerHTML = 'Kogus';
				document.getElementsByClassName('product-subtotal')[0].innerHTML = 'vahesumma';

				for (var i = 1; i < document.getElementsByClassName('product-name').length; i++) {
					if (document.getElementsByClassName('product-name')[i].innerHTML.substr(0,23) !== '<div id="cartFirstElem"') {
					document.getElementsByClassName('product-name')[i].innerHTML = '<div id="cartFirstElem" class="cartCustomElem" style="display: inline-block;float: left; font-weight: bold;">Toode:</div>'+document.getElementsByClassName('product-name')[i].innerHTML;
					document.getElementsByClassName('product-price')[i].innerHTML = '<div class="cartCustomElem" style="display: inline-block;float: left; font-weight: bold;">Hind:</div>'+document.getElementsByClassName('product-price')[i].innerHTML;
					document.getElementsByClassName('product-quantity')[i].innerHTML = '<div class="cartCustomElem" style="display: inline-block;float: left; font-weight: bold;">Kogus:</div>'+document.getElementsByClassName('product-quantity')[i].innerHTML;
					document.getElementsByClassName('product-subtotal')[i].innerHTML = '<div class="cartCustomElem" style="display: inline-block;float: left; font-weight: bold;">Vahesumma:</div>'+document.getElementsByClassName('product-subtotal')[i].innerHTML;
					}
				}

                if (document.getElementsByClassName('woocommerce-shipping-totals shipping')[0].getElementsByTagName('th')[0] !== undefined) {
                	document.getElementsByClassName('woocommerce-shipping-totals shipping')[0].getElementsByTagName('th')[0].innerHTML = 'Tarne';
                }
				document.getElementsByClassName('cart_totals')[0].getElementsByTagName('h2')[0].innerHTML = 'Ostukorvi kogusumma';
				document.getElementsByClassName('cart-subtotal')[0].getElementsByTagName('th')[0].innerHTML = 'Vahesumma';
				document.getElementsByClassName('order-total')[0].getElementsByTagName('th')[0].innerHTML = 'Kokku';
				document.getElementsByClassName('checkout-button')[0].innerHTML = 'Jätka ostu vormistamisega';
				document.getElementsByClassName('checkout-button')[0].setAttribute('href', '/ee/checkout/');
			}, 10);
		}
		setTimeout(eeCartLoop, 50);
	}
	setTimeout(eeCartLoop, 100);
}

if (window.location.pathname == '/en/cart/') {
	function enCartLoop() {
		if (document.getElementsByClassName('product-name').length > 0) {
			setTimeout(function(){
				document.getElementsByClassName('checkout-button')[0].setAttribute('href', '/ee/checkout/');
			}, 10);
		}
		setTimeout(enCartLoop, 50);
	}
	setTimeout(enCartLoop, 100);
}

function checkoutLoopEe3() {
	if (window.location.pathname.substr(0, 13) == '/ee/checkout/') {
		if (document.getElementsByClassName('mp-please-select-location').length > 0) {
			if (document.getElementsByClassName('mp-please-select-location')[0].innerText.indexOf('Pickup') == 0) {
				document.getElementsByClassName('mp-please-select-location')[0].innerHTML = 'Tarne asukoht';
			}
		}
	}
	setTimeout(checkoutLoopEe3, 100);
}

setTimeout(checkoutLoopEe3, 100);

function descriptionOrder() {
	if (window.location.pathname.substr(0, 4) == '/ee/') {
		document.getElementById('order_comments').innerHTML = 'ee';
	}
	if (window.location.pathname.charAt(3) !== '/') {
		document.getElementById('order_comments').innerHTML = 'ru';
	}
	if (window.location.pathname.substr(0, 4) == '/en/') {
		document.getElementById('order_comments').innerHTML = 'en';
	}
}

function checkoutLoopGlobal() {
	if (document.getElementById('place_order') !== null) {
		if (document.getElementById('place_order').getAttribute('onmousedown') == null) {
			document.getElementById('place_order').setAttribute('onmousedown', 'descriptionOrder()');
		}
	}
	setTimeout(checkoutLoopGlobal, 1000);
}
setTimeout(checkoutLoopGlobal, 1000);

var temp_l = 'ru';
function orderRecieved() {
	if (document.getElementsByClassName('page-title')[0].innerHTML.indexOf('Tellimus vastu võetud') == -1) {
		if (window.location.pathname.indexOf('/checkout/order-received/') == 0 && temp_l == 'ru') {
			if (document.getElementsByClassName('order_details')[1].innerHTML.indexOf('<td>ee</td>') !== -1) {
				window.location.pathname = '/ee/'+window.location.pathname+window.location.search;
				temp_l = 'ee';
			} else {
				if (document.querySelector('.woocommerce').innerHTML.indexOf('<th>Примечание:</th>' !== -1)) {
					document.querySelector('.woocommerce').innerHTML = document.querySelector('.woocommerce').innerHTML.replace('<th>Примечание:</th>', '');
					document.querySelector('.woocommerce').innerHTML = document.querySelector('.woocommerce').innerHTML.replace('<td>ru</td>', '');
				}
			}
		}

		if (window.location.pathname.indexOf('/ee/checkout/order-received/') !== -1) {
			document.querySelector('.page-title').innerHTML = 'Tellimus vastu võetud';
			document.querySelector('.woocommerce-thankyou-order-received').innerHTML = 'Aitäh. Teie tellimus on vastu võetud.';

			var temp = document.querySelector('.woocommerce').innerHTML;
			temp = temp.replace('Order number', 'Tellimuse number');
			temp = temp.replace('Date', 'Kuupäev');
			temp = temp.replace('Tota', 'Kokku');
			temp = temp.replace('Payment method', 'Makseviis');
			temp = temp.replace('Product', 'Toode');
			temp = temp.replace('Total', 'Kokku');
			temp = temp.replace('Subtotal', 'Vahesumma');
			temp = temp.replace('Shipping', 'Tarneviis');
			temp = temp.replace('Payment method', 'Makseviis');
			temp = temp.replace('Оплата через банк', 'Maksmine panga kaudu');
			temp = temp.replace('Total', 'Kokku');
			temp = temp.replace(`<th>Note:</th>`, '');
			temp = temp.replace(`<td>ee</td>`, '');
			temp = temp.replace(`<td>ru</td>`, '');
			temp = temp.replace('Billing address', 'Arveldusaadress');
			temp = temp.replace('Shipping address', 'Lähetusaadress');
			temp = temp.replace('Selected terminal', 'Valitud terminal');
			temp = temp.replace('Order details', 'Tellimuse info');
			temp = temp.replace('Оплата через банк', 'Maksmine panga kaudu');
			document.querySelector('.woocommerce').innerHTML = temp;

			// document.querySelector('.woocommerce-order-details').querySelector('section').outerHTML = '';
			document.querySelector('.woocommerce-order-overview__payment-method').querySelector('strong').innerHTML = 'Maksmine panga kaudu';

		}
	}
	setTimeout(orderRecieved, 100);
}
 setTimeout(orderRecieved, 300);

function checkoutLoopEe4() {
	if (window.location.pathname == '/ee/checkout/') {
		if (document.getElementById('place_order') !== undefined) {

		    if (document.getElementsByClassName('woocommerce-shipping-totals shipping')[0] !== undefined) {
		    	document.getElementsByClassName('woocommerce-shipping-totals shipping')[0].getElementsByTagName('th')[0].innerHTML = 'Tarne';
		    }

			if (document.getElementsByClassName('montonio-payments-country-dropdown')[0] !== undefined) {
				document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[0].innerHTML = 'Finland';
		    	document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[1].innerHTML = 'Latvia';
		    	document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[2].innerHTML = 'Estonia';
		    	document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[3].innerHTML = 'Lithuania';
			}

		    // document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[0].innerHTML = 'Finland';
		    // document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[1].innerHTML = 'Latvia';
		    // document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[2].innerHTML = 'Estonia';
		    // document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[3].innerHTML = 'Lithuania';

		    if (document.getElementsByClassName('wc_payment_method payment_method_montonio_payments')[0] !== undefined) {
		    	document.getElementsByClassName('wc_payment_method payment_method_montonio_payments')[0].getElementsByTagName('label')[0].innerHTML = 'Maksmine panga kaudu'+document.getElementById('montonio-payments-checkout-logo').outerHTML;
		    }
		    if (document.getElementById('montonio-payments-checkout-logo') !== null) {
		    	document.getElementById('montonio-payments-checkout-logo').setAttribute('style', 'transform: translate(10px, 0px);');
		    }
		    if (document.getElementsByClassName('product-name')[0] !== undefined) {
		    	document.getElementsByClassName('product-name')[0].innerHTML = 'Toode';
		    }
		    if (document.getElementsByClassName('product-total')[0] !== undefined) {
		    	document.getElementsByClassName('product-total')[0].innerHTML = 'Vahesumma';
		    }
			if (document.getElementsByClassName('woocommerce-billing-fields')[0] !== undefined) {
				document.getElementsByClassName('woocommerce-billing-fields')[0].getElementsByTagName('h3')[0].innerHTML = 'Tellija andmed';
			}
			if (document.getElementById('order_review_heading') !== null) {
				document.getElementById('order_review_heading').innerHTML = 'Sinu tellimus';
			}
			if (document.getElementsByClassName('cart-subtotal')[0] !== undefined) {
				document.getElementsByClassName('cart-subtotal')[0].getElementsByTagName('th')[0].innerHTML = 'Vahesumma';
			}
			if (document.getElementsByClassName('order-total')[0] !== undefined) {
				document.getElementsByClassName('order-total')[0].getElementsByTagName('th')[0].innerHTML = 'Kokku';
			}
			if (document.getElementsByClassName('woocommerce-terms-and-conditions-checkbox-text')[0] !== undefined) {
				document.getElementsByClassName('woocommerce-terms-and-conditions-checkbox-text')[0].innerHTML = 'Olen <a href="/ee/terms-of-sale/" class="woocommerce-terms-and-conditions-link" target="_blank">müügitingimustega</a> tutvunud ja täielikult nõus';
			}
			if (document.getElementById('place_order') !== null) {
				document.getElementById('place_order').innerHTML = 'Vormista ost';
			}
			if (document.getElementsByClassName('product-name')[0] !== undefined) {
				document.getElementsByClassName('product-name')[0].innerHTML = 'Toode'
			}
			if (document.getElementsByClassName('product-total')[0] !== undefined) {
				document.getElementsByClassName('product-total')[0].innerHTML = 'Vahesumma';
			}
		}
	}
	setTimeout(checkoutLoopEe4, 500);
}
setTimeout(checkoutLoopEe4, 500);

function checkoutLoopEe2() {
	if (window.location.pathname == '/ee/checkout/') {
		if (document.getElementsByClassName('woocommerce-billing-fields')[0] !== undefined && document.getElementById('billing_first_name_field').getElementsByTagName('label')[0].innerHTML.indexOf('First') == 0) {
			document.getElementById('billing_first_name_field').getElementsByTagName('label')[0].innerHTML = 'Nimi'+document.getElementById('billing_first_name_field').getElementsByTagName('label')[0].innerHTML.substr(10,100);
			document.getElementById('billing_last_name_field').getElementsByTagName('label')[0].innerHTML = 'Perekonnanimi'+document.getElementById('billing_last_name_field').getElementsByTagName('label')[0].innerHTML.substr(9,100);
			document.getElementById('billing_country_field').getElementsByTagName('label')[0].innerHTML = 'Riik / piirkond'+document.getElementById('billing_country_field').getElementsByTagName('label')[0].innerHTML.substr(16,100);
			document.getElementById('billing_phone_field').getElementsByTagName('label')[0].innerHTML = 'Telefon'+document.getElementById('billing_phone_field').getElementsByTagName('label')[0].innerHTML.substr(5,100);
			document.getElementById('billing_email_field').getElementsByTagName('label')[0].innerHTML = 'Email'+document.getElementById('billing_email_field').getElementsByTagName('label')[0].innerHTML.substr(13,100);
		}
	}
	setTimeout(checkoutLoopEe2, 100);
}
	setTimeout(checkoutLoopEe2, 500);

if (window.location.pathname.substr(0, 13) == '/ee/checkout/') {
	function checkoutLoopEe() {
	    setTimeout(checkoutLoopEe, 5);

            if  (document.getElementsByClassName('woocommerce-error').length > 0) {
                for (var i = 0; i < document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li').length; i++) {
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Выберите место для доставки.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'Valige kohaletoimetamise koht.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Чтобы продолжить оформление заказа, прочтите правила и условия и подтвердите своё согласие с ними.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'Tellimise jätkamiseks lugege palun tingimusi ja kinnitage nendega kokkulepet.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Имя для выставления счета является обязательным полем.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'Arvelduse nimi on kohustuslik väli.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Фамилия для выставления счета является обязательным полем.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'Arveldatav perekonnanimi on kohustuslik väli.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Телефон для выставления счета является обязательным полем.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'Arvelduse telefoninumber on kohustuslik väli.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Email для выставления счета является обязательным полем.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'Arvelduse e-post on kohustuslik väli.';
                    }

                }
            }

	    if  (document.getElementsByClassName('page-title').length > 0) {if  (document.getElementsByClassName('page-title')[0].innerHTML == 'Kassas') {document.getElementsByClassName('page-title')[0].innerHTML = 'Kassa'}}
        if (document.getElementById('select2-mp-wc-pickup-point-shipping-select-container') !== null) {
            if (document.getElementById('select2-mp-wc-pickup-point-shipping-select-container').innerHTML == 'Выберите место доставки') {
                document.getElementById('select2-mp-wc-pickup-point-shipping-select-container').innerHTML = 'Valige tarne asukoht';
            }
        }
        if (document.getElementsByClassName('select2-results__option').length > 0) {document.getElementsByClassName('select2-results__option')[0].getElementsByTagName('span')[0].innerHTML = 'Valige tarne asukoht';}

	}
	setTimeout(checkoutLoopEe, 100);
}

if (window.location.pathname.substr(0, 13) == '/en/checkout/') {
	function checkoutLoopEn() {
	    setTimeout(checkoutLoopEn, 5);

	                if  (document.getElementsByClassName('woocommerce-error').length > 0) {
                for (var i = 0; i < document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li').length; i++) {
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Выберите место для доставки.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'Choose a place for delivery.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Чтобы продолжить оформление заказа, прочтите правила и условия и подтвердите своё согласие с ними.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'To continue ordering, please read the terms and conditions and confirm your agreement with it.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Имя для выставления счета является обязательным полем.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'The billing name is a required field.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Фамилия для выставления счета является обязательным полем.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'The billing surname is a required field.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Телефон для выставления счета является обязательным полем.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'Billing phone number is a required field.';
                    }
                    if  (document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText == 'Email для выставления счета является обязательным полем.') {
                        document.getElementsByClassName('woocommerce-error')[0].getElementsByTagName('li')[i].innerText = 'Email for invoicing is a required field.';
                    }

                }
            }

        if (document.getElementById('select2-mp-wc-pickup-point-shipping-select-container') !== null) {
            if (document.getElementById('select2-mp-wc-pickup-point-shipping-select-container').innerHTML == 'Выберите место доставки') {
                document.getElementById('select2-mp-wc-pickup-point-shipping-select-container').innerHTML = 'Select delivery location';
            }
        }
        if (document.getElementsByClassName('select2-results__option').length > 0) {document.getElementsByClassName('select2-results__option')[0].getElementsByTagName('span')[0].innerHTML = 'Select delivery location';}
        if (document.getElementById('place_order') !== null) {
			if (document.getElementById('place_order').innerHTML !== 'Confirm the order') {

			    document.getElementsByClassName('woocommerce-shipping-totals shipping')[0].getElementsByTagName('th')[0].innerHTML = 'Delivery';
			    document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[0].innerHTML = 'Finland';
			    document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[1].innerHTML = 'Latvia';
			    document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[2].innerHTML = 'Estonia';
			    document.getElementsByClassName('montonio-payments-country-dropdown')[0].getElementsByTagName('option')[3].innerHTML = 'Lithuania';

			    document.getElementsByClassName('wc_payment_method payment_method_montonio_payments')[0].getElementsByTagName('label')[0].innerHTML = 'Payment via bank'+document.getElementById('montonio-payments-checkout-logo').outerHTML;
			    document.getElementById('montonio-payments-checkout-logo').setAttribute('style', 'transform: translate(10px, 0px);');
			    document.getElementsByClassName('product-name')[0].innerHTML = 'Product';
			    document.getElementsByClassName('product-total')[0].innerHTML = 'Subtotal';
				document.getElementsByClassName('cart-subtotal')[0].getElementsByTagName('th')[0].innerHTML = 'Subtotal';
				document.getElementsByClassName('order-total')[0].getElementsByTagName('th')[0].innerHTML = 'Total';
				document.getElementsByClassName('woocommerce-terms-and-conditions-checkbox-text')[0].innerHTML = 'I have read and agree to the site <a href="/en/terms-of-sale/" class="woocommerce-terms-and-conditions-link" target="_blank">terms and conditions</a>';
				document.getElementById('place_order').innerHTML = 'Confirm the order';
				document.getElementsByClassName('product-name')[0].innerHTML = 'Product';
				document.getElementsByClassName('product-total')[0].innerHTML = 'Subtotal';
			}
		}
	}
	setTimeout(checkoutLoopEn, 100);
}


    </script>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
    <?php $core->the_option( 'code_head' ) ?>
		<script type="text/javascript">
			function getDateExpires(days) {
			  var date = new Date;
			  date.setDate(date.getDate() + days);
			  return date;
			}
			function setCookie(name, value, options = {}) {

			  options = {
			    path: '/',
			    ...options
			  };

			  if (options.expires instanceof Date) {
			    options.expires = options.expires.toUTCString();
			  }

			  let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

			  for (let optionKey in options) {
			    updatedCookie += "; " + optionKey;
			    let optionValue = options[optionKey];
			    if (optionValue !== true) {
			      updatedCookie += "=" + optionValue;
			   }
			  }

			  document.cookie = updatedCookie;
			}
			function getCookie(name) {
					  let matches = document.cookie.match(new RegExp(
					    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
					  ));
					  return matches ? decodeURIComponent(matches[1]) : undefined;
					}
					function deleteCookie(name) {
					  setCookie(name, "", {
					    'max-age': -1
					  })
					}












				</script>


<!-- <script>
if (window.location.pathname == '/ee/checkout/') {
	setCookie('eeCheck', 'ee');
}
function jiasd() {
	if (document.getElementsByClassName('lang-item-49')[0] !== null && document.getElementsByClassName('lang-item-49')[1] !== null) {
		document.getElementsByClassName('lang-item-49')[0].setAttribute('onclick', 'deleteCookie(\'eeCheck\')');
		document.getElementsByClassName('lang-item-49')[1].setAttribute('onclick', 'deleteCookie(\'eeCheck\')');
	} else {
		setTimeout(jiasd, 100);
	}
}
setTimeout(jiasd, 500);
if (getCookie('eeCheck') == 'ee' && window.location.pathname == '/checkout/') {
	document.location.pathname = '/ee/checkout/';
}
</script> -->


				<script>
				    if (window.location.pathname.substr(0,4) == '/en/') {
				        setCookie('pll_language', 'ee');
				        document.location = 'http://easycutfor.com/ee/';
				    }
				</script>
<script src="/wp-content/themes/bono_child/newfunctions.js"></script>
<link
  rel="stylesheet"
  href="https://unpkg.com/swiper@8/swiper-bundle.min.css"
/>
</head>
<body <?php body_class(); ?>>

<div id="styleLife"></div>
<script>if (document.location.pathname == '/product/life-clinic/' || document.location.pathname == '/ee/product/life-clinic/' || document.location.pathname == '/en/product/life-clinic/') {document.getElementById('styleLife').innerHTML = '<style>.woocommerce-notices-wrapper {display: none !important;}</style>'}</script>
<div id="cartHead"></div>
<div id="cartHeadEe"></div>
<script>
    	if (window.location.pathname.substr(3, 6) == '/cart/' || window.location.pathname.substr(0, 6) == '/cart/') {
        document.getElementById('cartHead').outerHTML = '<style>.header-search {display: none;}</style>';
    	}
    	if (window.location.pathname == '/ee/cart/') {
        document.getElementById('cartHeadEe').outerHTML = '<style>.woocommerce-cart-form table.shop_table_responsive tr td:before {display: none !important;}</style>';
    	}
</script>
<script>
window.onload = setTimeout(function () {
	if (document.getElementById('masthead') !== null) {
		sessionStorage['cart-header'] = document.getElementById('masthead').outerHTML;
	}
}, 100);

window.onload = setTimeout(function(){
    if (window.location.pathname.substr(3, 6) == '/cart/' || window.location.pathname.substr(0, 6) == '/cart/') {
		if (document.getElementById('masthead') == null) {document.getElementById('cart-header').outerHTML = sessionStorage['cart-header'];}
	}
}, 100);
</script>
<div id="cart-header"></div>
<?
    if ($_GET['s']) {
        echo '<script>if (document.location.pathname.substr(0, 4) == \'/ee/\') {
            window.onload = setTimeout(function(){
                if (document.getElementsByClassName(\'page-title\').length > 0) {
                    if (document.getElementsByClassName(\'page-title\')[0].innerHTML.substr(0,18) == \'Search Results for\') {
                        document.getElementsByClassName(\'page-title\')[0].innerHTML = document.getElementsByClassName(\'page-title\')[0].innerHTML.replace(\'Search Results for\', \'Otsingu tulemus\');
                    }
                }
                if (document.getElementsByClassName(\'next page-numbers\').length > 0) {
                    if (document.getElementsByClassName(\'next page-numbers\')[0].innerHTML == \'Next\') {
                        document.getElementsByClassName(\'next page-numbers\')[0].innerHTML = \'Järgmine\';
                    }
                }
                if (document.getElementsByClassName(\'prev page-numbers\').length > 0) {
                    if (document.getElementsByClassName(\'prev page-numbers\')[0].innerHTML == \'Previous\') {
                        document.getElementsByClassName(\'prev page-numbers\')[0].innerHTML = \'Eelmine\';
                    }
                }
                if (document.getElementsByClassName(\'page-title\')[0].innerHTML == \'Nothing Found\') {
                    document.getElementsByClassName(\'page-title\')[0].innerHTML = \'Midagi pole leitud\';
                }
                if (document.getElementsByClassName(\'page-content\')[0].getElementsByTagName(\'p\')[0].innerHTML == \'Sorry, but nothing matched your search terms. Please try again with some different keywords.\') {
                    document.getElementsByClassName(\'page-content\')[0].getElementsByTagName(\'p\')[0].innerHTML = \'Vabandust, kuid miski ei vastanud teie otsingule. Proovige uuesti mõne muu märksõnaga.\';
                }
            }, 1);
        }</script><style>
        .site-content-inner {justify-content: center;}
        #secondary, .related-posts.fixed {display: none !important;}
        .page-content p:before {position: absolute;}
        .page-content p {display: flex;justify-content: center;}
        </style>';
    }
?>
<?php theme_container()->get( ThemeProvider::class )->check(); ?>

<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
} ?>

<?php do_action( THEME_SLUG . '_after_body' ) ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', THEME_TEXTDOMAIN ); ?></a>

    <?php
    if ( $core->get_option( 'super_header_show' ) || $core->get_option( 'super_header_show_mob' ) ): ?>
        <?php get_template_part( 'template-parts/header/super-header' ) ?>
    <?php endif ?>

    <?php
    if ( $core->is_show_element( 'header' ) ): ?>
        <?php get_template_part( 'template-parts/header/header' ) ?>
    <?php endif ?>

    <?php
    if ( $core->is_show_element( 'header_menu' ) ): ?>
        <?php get_template_part( 'template-parts/navigation/header' ) ?>
    <?php endif ?>

    <?php do_action( THEME_SLUG . '_before_site_content' ) ?>

    <div id="content" class="site-content <?php echo apply_filters( 'bono_site_content_classes', 'fixed' ) ?>">

        <?php echo $advertising->show_ad( 'before_site_content' ); ?>

        <div class="site-content-inner">
<script>
    setTimeout(function(){
        if (window.location.pathname.substr(0, 4) == '/ee/') {
            document.getElementsByClassName('header-cart')[0].getElementsByTagName('a')[0].setAttribute('href', '/ee/cart/');
        }
        if (window.location.pathname.substr(0, 4) == '/en/') {
            window.onload = function() {if (document.getElementsByClassName('header-cart__link header-favorite header-favorite--vis js-header-favorite').length > 0) {document.getElementsByClassName('header-cart__link header-favorite header-favorite--vis js-header-favorite')[0].setAttribute('href', '/en/favorite/')}}
            window.onload = function() {if (document.getElementsByClassName('header-cart__link header-compare header-compare--vis js-header-compare').length > 0) {document.getElementsByClassName('header-cart__link header-compare header-compare--vis js-header-compare')[0].setAttribute('href', '/en/compare/')}}
            document.getElementsByClassName('header-cart')[0].getElementsByTagName('a')[0].setAttribute('href', '/en/cart/');
        }
    }, 100);

if (window.location.pathname.substr(0, 4) == '/ee/') {
    window.onload = function() {
        if (document.getElementsByClassName('header-cart__link header-favorite header-favorite--vis js-header-favorite').length > 0) {document.getElementsByClassName('header-cart__link header-favorite header-favorite--vis js-header-favorite')[0].setAttribute('href', '/ee/favorite/')};
        if (document.getElementsByClassName('header-cart__link header-compare header-compare--vis js-header-compare').length > 0) {document.getElementsByClassName('header-cart__link header-compare header-compare--vis js-header-compare')[0].setAttribute('href', '/ee/compare/')};

    }
	function eeItemLoop() {
	    if (document.getElementsByClassName('breadcrumb-item').length > 0) {
	        if (document.getElementsByClassName('breadcrumb-item')[0].getElementsByTagName('a')[0].getElementsByTagName('span')[0].innerHTML == 'Home') {
	            document.getElementsByClassName('breadcrumb-item')[0].getElementsByTagName('a')[0].getElementsByTagName('span')[0].innerHTML = 'Koju';
	        }
	    }
	    if (document.getElementsByClassName('woocommerce-breadcrumb').length > 0) {
	        if (document.getElementsByClassName('woocommerce-breadcrumb')[0].getElementsByTagName('a')[0].innerHTML == 'Home') {
	            document.getElementsByClassName('woocommerce-breadcrumb')[0].getElementsByTagName('a')[0].innerHTML = 'Koju';
	        }
	    }
		if (document.getElementsByClassName('single_add_to_cart_button').length > 0) {
				document.getElementsByClassName('single_add_to_cart_button')[0].innerHTML = 'Lisa ostukorvi';
		}
		if (document.getElementsByClassName('bono_buy_one_click').length > 0) {
				document.getElementsByClassName('bono_buy_one_click')[0].innerHTML = 'Osta üks klõps';
		}
		if (document.getElementsByClassName('stock available-on-backorder').length > 0) {
				document.getElementsByClassName('product-container')[0].getElementsByClassName('available-on-backorder')[0].innerHTML = 'Saadaval ettetellimisel';
		}
		if (document.getElementsByClassName('related-products__header')[0] !== undefined) {
				document.getElementsByClassName('related-products__header')[0].innerHTML = 'Seotud tooted';
		}
		if (document.getElementsByClassName('related-products__header')[1] !== undefined) {
				document.getElementsByClassName('related-products__header')[1].innerHTML = 'Hiljuti vaadatud tooted';
		}
		for (var i = 0; i < document.getElementsByClassName('shop-item__buttons-cart').length; i++) {
			if (document.getElementsByClassName('shop-item__buttons-cart')[i].innerHTML == 'Read more') {
				document.getElementsByClassName('shop-item__buttons-cart')[i].innerHTML = 'Loe rohkem';
			}
		}
		setTimeout(eeItemLoop, 50);
	}
	setTimeout(eeItemLoop, 100);
}
</script>