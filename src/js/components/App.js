'use strict';

import Config from '../util/Config';
import Util from '../util/Util';
import HtmlClass from '../util/HtmlClass';
import SmoothScroll from '../util/SmoothScroll';
import Module from './Module';
import Header from './Header';
import PageTop from './PageTop';
import Top from './Top';

class App {
	constructor(){
		this.html = document.querySelector('html');
		this.Config = Config;
		this.Util = new Util();
		this.Header = new Header();
		this.PageTop = new PageTop();
		this.Module = new Module();
	}

	render(){
		HtmlClass.render();
		this.Header.render();
		this.PageTop.render();
		this.Module.render();
		SmoothScroll.render('.ss');
		if( document.body.classList.contains('page-top') ){
			Top.render();
		}
		// ieスムーズスクロールoff
		if(navigator.userAgent.match(/MSIE 10/i) || navigator.userAgent.match(/Trident\/7\./)) {
			$('body').on("mousewheel", function (){
				event.preventDefault();
				var wd = event.wheelDelta;
				var csp = window.pageYOffset;
				window.scrollTo(0, csp - wd);
			});
		}
	}
}

export default App;
