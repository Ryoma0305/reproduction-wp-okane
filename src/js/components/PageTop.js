'use strict';

class PageTop {
	constructor(){
		this.pagetop = document.querySelector('.footer__pagetop');
		this.isVisible = false;
		this.isBottom = false;
	}

	render(){
		if( !this.pagetop ) return;
		this.onScroll();
	}

	onScroll(){
		let
			visiblePos,
			bottomPos;
		window.addEventListener('scroll', ()=>{
			visiblePos = app.Util.wh() / 2;
			bottomPos = app.Util.offset(document.querySelector('.footer__foot')).top - app.Util.wh();
			if( !this.isVisible && app.Util.sy() > visiblePos ) {
				this.isVisible = true;
				this.pagetop.classList.add('is-visible');
			} else if( this.isVisible && app.Util.sy() <= visiblePos ) {
				this.isVisible = false;
				this.pagetop.classList.remove('is-visible');
			}
			if( !this.isBottom && app.Util.sy() > bottomPos ){
				this.isBottom = true;
				this.pagetop.classList.add('is-bottom');
			} else if ( this.isBottom && app.Util.sy() <= bottomPos ) {
				this.isBottom = false;
				this.pagetop.classList.remove('is-bottom');
			}
		}, false);
	}
}

export default PageTop;
