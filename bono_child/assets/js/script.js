// TODO: Minify this file!

const translate = (text, selector, several = false) => {
    if (!several) {
        const element = document.querySelector(selector);

        if (element !== null && element !== undefined) {
            element.textContent = text;
        } else {
            return;
        }
    } else {
        // TODO: Implement translation of multiple elements with same selector
        // or with diferrent selectors but in the same page
    }
};

setTimeout(() => {
    const path = window.location.pathname[1];
    const el = document.querySelector('.button.checkout');
    const el2 = document.querySelector('.button.wc-forward');
    // Link to the cart in mobile burger menu
    const linkToCart = document.querySelectorAll('.js-header-cart-link');
    const mobileCart = document.querySelector('.site-header-cart-hidden');
    const hamburgerMenu = document.querySelector('.js-humburger');
    const mobileMenuPlaceholder = document.querySelector(
        '.js-mobile-menu-placeholder'
    );
    const shit = document.querySelector('.main-navigation');

    const siteHeaderCart = document.querySelector('.site-header-cart');
    const widget_shopping_cart_content = document.querySelector(
        '.widget_shopping_cart_content'
    );

    widget_shopping_cart_content.style.width = '100%';

    const woocommerceMiniCartTotal = document.querySelector(
        '.woocommerce-mini-cart__total'
    );

    switch (path) {
        case 'e':

            if (window.location.pathname.includes('order-received')) {
                console.log(true);
                document.querySelector(
                    '.woocommerce-order-details'
                ).children[2].children[0].textContent = 'Valeted terminal';
            } else {
                console.log(false);
            }

            translate('Vaata ostukorvi', '.button.wc-forward');

            translate('Maksma', '.button.checkout');
            el.href = 'https://grounison.com/ee/checkout';
            el2.href = 'https://grounison.com/ee/cart';



            linkToCart.forEach((element) => {
                element.href = 'https://grounison.com/ee/cart';
                element.addEventListener('click', (e) => {
                    if (window.innerWidth < 500) {
                        mobileCart.style.width = '100%';

                        if (hamburgerMenu.classList.contains('open')) {
                            hamburgerMenu.classList.remove('open');
                        }

                        if (mobileMenuPlaceholder.classList.contains('open')) {
                            mobileMenuPlaceholder.classList.remove('open');
                        }
                        if (shit.style.display === 'block') {
                            shit.style.display = 'none';
                        }

                        siteHeaderCart.hidden = false;
                    }
                });
            });
            woocommerceMiniCartTotal.children[0].textContent = 'Vahesumma:';
            break;
        case 'r':
            translate('Просмотр корзины', '.button.wc-forward');
            translate('Оформление заказа', '.button.checkout');
            el.href = 'https://grounison.com/ru/checkout';
            el2.href = 'https://grounison.com/ru/cart';
            linkToCart.forEach((element) => {
                element.href = 'https://grounison.com/ru/cart';
                element.addEventListener('click', (e) => {
                    if (window.innerWidth < 500) {
                        mobileCart.style.width = '100%';

                        if (hamburgerMenu.classList.contains('open')) {
                            hamburgerMenu.classList.remove('open');
                        }

                        if (mobileMenuPlaceholder.classList.contains('open')) {
                            mobileMenuPlaceholder.classList.remove('open');
                        }
                        if (shit.style.display === 'block') {
                            shit.style.display = 'none';
                        }

                        siteHeaderCart.hidden = false;
                    }
                });
            });
            woocommerceMiniCartTotal.children[0].textContent = 'Подытог:';
            break;
        default:
            break;
    }
}, 100);

// const swiper = new Swiper('.swiper-container', {
//     speed: 600,
//     autoplay: true,
//     slidesPerView: 1,
//     spaceBetween: 35,
//     loop: true,
//     pauseOnMouseEnter: true,
//     disableOnInteraction: true,
//     pagination: {
//         el: '.swiper-pagination',
//         clickable: true,
//     },
// });
// const swiperSlider = document.querySelector('.swiper-container');

// swiperSlider.addEventListener('mouseover', () => {
//     swiper.autoplay.stop();
// });
// swiperSlider.addEventListener('mouseleave', () => {
//     swiper.autoplay.start();
// });

// hide logo if search has been clicked
const searchIcon = document.querySelector('.js-header-search-ico');
const siteLogotype = document.querySelector('.site-logotype');

window.addEventListener('DOMContentLoaded', (event) => {
    let a = getComputedStyle(siteLogotype);
    searchIcon.addEventListener('click', (e) => {
        if (window.outerWidth <= 600) {
            if (a.visibility == 'visible') {
                siteLogotype.style.visibility = 'hidden';
            } else {
                siteLogotype.style.visibility = 'visible';
            }
        }
        //  ? siteLogotype.style.display = 'none'  : siteLogotype.style.display = 'block'
        // TODO: hide logo if click on the search
    });
});
