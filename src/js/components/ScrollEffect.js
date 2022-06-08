'use strict';

class ScrollEffect {
	constructor(el){
		this.el = el;
		this.init();
		this.render();
	}

	init(){
		let
			step = 1,
			ttl = this.el.querySelector('.js-scrollEffect__ttl'),
			groups = this.el.querySelectorAll('.js-scrollEffect__group');
		_.each(groups, (group)=>{
			let
				delay = ( ttl )? app.Config.duration/1000 : 0,
				obj = group.querySelectorAll('.js-chara');
			_.each(obj, (el, i)=>{
				el.style.animationDelay = `${delay + i * step}s`;
			});
		});
	}

	render(){
		let observer = new IntersectionObserver((entries)=>{
			_.each(entries, (entry)=>{
				if( entry.isIntersecting ) {
					this.el.classList.add('is-visible');
					observer.unobserve(this.el);
				}
			});
		}, {
			rootMargin: '0px 0px -30% 0px'
		});
		observer.observe(this.el);
	}
}

export default ScrollEffect;
