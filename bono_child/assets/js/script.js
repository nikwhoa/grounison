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
    switch (path) {
        case 'e':
            translate('Vaata ostukorvi', '.button.wc-forward');
            translate('Maksma', '.button.checkout');
            break;
        case 'r':
            translate('Просмотр корзины', '.button.wc-forward');
            translate('Оформление заказа', '.button.checkout');
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
