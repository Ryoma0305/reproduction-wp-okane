'use strict';

import Ease from './Ease';

class SmoothScroll {
	constructor(){
		this.scrollEl = ()=>{
			if('scrollingElement' in document) return document.scrollingElement;
			if(navigator.userAgent.indexOf('WebKit') != -1) return document.body;
			return document.documentElement;
		};
		this.duration = {
			normal: 500,
			fast: 100
		};
	}

	render(els){
		_.each(document.querySelectorAll(els), (el)=>{
			let anc = el.getAttribute('href');
			el.addEventListener('click', (e)=>{
				e.preventDefault();
				this.scroll(anc);
			}, false);
		});
	}

	scroll(anc, speed='normal'){
		let target = document.querySelector(anc);
		if( !target ) return;
		let
			timerID,
			offset = ( app.Util.layoutType() == 'PC' )? app.Util.fontsize() * 12.5 : app.Util.fontsize() * 7,
			pos = app.Util.offset(target).top - offset,
			startTime = Date.now(),
			currentTime,
			startPos = app.Util.sy(),
			tick = ()=>{
				timerID = window.requestAnimationFrame(tick);
				currentTime = Date.now() - startTime;
				if( currentTime < this.duration[speed] ) {
					scrollTo(0, Ease(currentTime, startPos, pos, this.duration[speed], app.Config.ease.tween));
				} else {
					scrollTo(0, pos);
					window.cancelAnimationFrame(timerID);
				}
			};
		pos = ( pos < 0 )? 0 : pos;
		tick();
	}
};

export default new SmoothScroll();
