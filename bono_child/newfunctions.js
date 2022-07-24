setTimeout(function(){

if (window.location.pathname.charAt(1) == 'e' && window.location.pathname.charAt(2) == 'e' && window.location.pathname.charAt(3) == '/') {
	for (var i = 0; i <= document.getElementsByClassName('search-field').length - 1; i++) {
		document.getElementsByClassName('search-field')[i].setAttribute('placeholder', 'Otsing...');
	}
	if (document.getElementsByClassName('error-404 not-found') > 0) {
		document.getElementsByClassName('error-404 not-found')[0].getElementsByClassName('page-title')[0].innerHTML = 'Seda lehte ei leitud.';
		document.getElementsByClassName('error-404 not-found')[0].getElementsByClassName('page-content')[0].getElementsByTagName('p')[0].innerHTML = 'Tundub, et selles asukohas ei leitud midagi. Võib-olla proovida mõnda allolevat linki või otsida?';
	}
}

if (window.location.pathname.charAt(3) !== '/') {
	if (document.getElementsByClassName('error-404 not-found') > 0) {
		document.getElementsByClassName('error-404 not-found')[0].getElementsByClassName('page-title')[0].innerHTML = 'Страница не найдена.';
		document.getElementsByClassName('error-404 not-found')[0].getElementsByClassName('page-content')[0].getElementsByTagName('p')[0].innerHTML = 'Похоже, в этом месте ничего не было найдено. Может быть, попробуйте одну из ссылок ниже или поиск?';
	}
}


}, 1);