'use strict';

class Header {
	constructor(){
		this.header = document.querySelector('.header');
		this.menu = this.header.querySelector('.header__menu');
		this.nav = this.header.querySelector('.header__nav');
		this.txt = this.menu.querySelector('.txt');
		this.isOPEN = false;
		this.isSearch = false;
		this.ps;
	}

	render(){
		this.touch();
		// this.hide();
		this.scrolled();
		this.search();
		this.menu.addEventListener('click', (e)=>{
			e.preventDefault();
			if( this.isOPEN ) {
				this.isOPEN = false;
				app.html.classList.remove('nav-open');
				this.txt.innerHTML = 'MENU';
				this.nav.scrollTo(0, 0);
				this.ps.destroy();
			} else {
				this.isOPEN = true;
				this.ps = new PerfectScrollbar(this.header);
				app.html.classList.add('nav-open');
				this.txt.innerHTML = 'CLOSE';
			}
		});
		app.Util.layoutChange(()=>{
			this.reset();
		});
	}

	reset(){
		this.isOPEN = false;
		app.html.classList.remove('nav-open');
		this.txt.innerHTML = 'MENU';
		this.isSearch = false;
		app.html.classList.remove('is-search');
	}

	// hide(){
	// 	let
	// 		isScroll = false,
	// 		isHide = false,
	// 		scrollPos = app.Util.sy(),
	// 		scroll = ()=>{
	// 			if( scrollPos > 1 && !this.isOPEN && !isHide && scrollPos < app.Util.sy() ){
	// 				app.html.classList.add('header-hide');
	// 				isHide = true;
	// 			} else if( isHide && scrollPos > app.Util.sy() ) {
	// 				app.html.classList.remove('header-hide');
	// 				isHide = false;
	// 			}
	// 			scrollPos = app.Util.sy();
	// 		};
	//
	// 	if( app.Util.layoutType() != 'PC' ){
	// 		isScroll = true;
	// 		window.addEventListener('scroll',scroll);
	// 	}
	//
	// 	app.Util.layoutChange(()=>{
	// 		if( !isScroll && app.Util.layoutType() != 'PC' ){
	// 			isScroll = true;
	// 			window.addEventListener('scroll',scroll);
	// 		} else if ( isScroll && app.Util.layoutType() == 'PC' ) {
	// 			isScroll = false;
	// 			window.removeEventListener('scroll',scroll);
	// 			if( isHide ){
	// 				app.html.classList.remove('header-hide');
	// 				isHide = false;
	// 			}
	// 		}
	// 	});
	// }

	scrolled(){
		let
			isScrolled = false,
			scrollPos,
			change = ()=>{
				if( !isScrolled && app.Util.sy() > scrollPos ){
					isScrolled = true;
					app.html.classList.add('header-scrolled');
				} else if ( isScrolled && app.Util.sy() <= scrollPos ){
					isScrolled = false;
					app.html.classList.remove('header-scrolled');
				}
			};
		if( document.body.classList.contains('page-top') ){
			scrollPos = 1000;
		} else {
			scrollPos = 1;
		}
		document.addEventListener('DOMContentLoaded', change);
		window.addEventListener('scroll', change);
	}

	search(){
		const	icon = this.header.querySelector('.header__search__icon');
		icon.addEventListener('click', (e)=>{
			e.preventDefault();
			if( !this.isSearch ){
				this.isSearch = true;
				app.html.classList.add('is-search');
				this.header.querySelector('.search__input').focus();
			} else if( this.isSearch ) {
				this.isSearch = false;
				app.html.classList.remove('is-search');
			}
		});
		document.addEventListener('click', (e)=>{
			if( this.isSearch ){
				if( !(e.target.classList.contains('header__search__icon') || e.target.classList.contains('search__input')) ){
					this.isSearch = false;
					app.html.classList.remove('is-search');
				}
			}
		});
	}

	touch(){
		let touchStartY, touchMoveY, diff;
		this.header.addEventListener('touchstart', (e)=>{
			touchStartY = e.touches[0].pageY;
		});
		this.header.addEventListener('touchmove', (e)=>{
			if( app.Util.layoutType() != 'SP' ) return;
			touchMoveY = e.changedTouches[0].pageY;
			diff = touchStartY - touchMoveY;
			if(
				( this.header.scrollTop == 0 && diff < 0 )
				|| ( this.header.scrollTop + this.header.offsetHeight >= this.header.scrollHeight && diff > 0 )
			) {
				e.preventDefault();
			}
		});
	}
}

export default Header;
