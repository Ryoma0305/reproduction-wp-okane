'use strict';

/**
 easing 参考
 jquery: http://semooh.jp/jquery/cont/doc/easing/
 tweenmax: https://greensock.com/ease-visualizer
 tween: https://github.com/chenglou/tween-functions
*/

const Config = {
	breakPoint: {
		tb: 1200,
		sp: 767
	},
	duration: 400,
	ease: {
		jquery: 'easeOutQuint',
		// tweenmax: Power0.easeNone,
		tween: 'easeOutQuint'
	}
}

export default Config;
