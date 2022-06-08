'use strict';

import ScrollEffect from './ScrollEffect';

class Module{
  constructor(){
    this.main = document.querySelector('.m-main');
    this.detail = document.querySelector('.m-article-detail');
    this.side = document.querySelector('.m-side');
    this.inner = document.querySelector('.m-side__inner');
  }

  render(){
    // ScrollEffect
    _.each(document.querySelectorAll('.js-scrollEffect'), (el)=>{
      new ScrollEffect(el);
    });
    if( document.querySelector('.wp-block-anchorlink') ){
      const anchorlink = document.querySelectorAll('.wp-block-anchorlink');
      _.each(anchorlink, (anchor)=>{
        _.each(anchor.querySelectorAll('a'),(link)=>{
          link.classList.add('ss');
        });
      });
    }
    if( document.querySelector('.m-entry-sns') ){
      this.sns_fixed();
    }
    if( document.body.classList.contains('page-detail') && !(app.html.classList.contains('ie11')) ){
      this.position();
    }
    if( document.querySelector('.m-entry-share__link') ){
      this.share();
    }
  }

  sns_fixed(){
    let
      snsfixedNav = document.querySelector('.m-entry-sns'),
      snsVisible = false,
      snsBottom = false,
      snsVisiblePos,
      snsBottomPos;
    window.addEventListener('scroll', ()=>{
      snsVisiblePos = app.Util.offset(document.querySelector('.m-entry__body')).top - document.querySelector('.header').offsetHeight;
      snsBottomPos = app.Util.offset(document.querySelector('.m-entry__foot')).top - app.Util.wh();
      if( !snsBottom && !snsVisible && app.Util.sy() > snsVisiblePos ){
        snsVisible = true;
        app.html.classList.add('sns-visible');
      } else if( snsVisible && app.Util.sy() <= snsVisiblePos ){
        snsVisible = false;
        app.html.classList.remove('sns-visible');
      }
      if( !snsBottom && app.Util.sy() > snsBottomPos ){
        snsBottom = true;
        app.html.classList.remove('sns-visible');
      } else if ( snsVisible && snsBottom && app.Util.sy() <= snsBottomPos ) {
        snsBottom = false;
        app.html.classList.add('sns-visible');
      }
    });
  }

  position(){
    let
      windowBottom,
      mainOffset = app.Util.offset(this.main).top,
      mainHeight = this.main.offsetHeight,
      mainBottom = mainHeight + mainOffset,
      sideOffset = app.Util.offset(this.side).top,
      sideHeight = this.side.offsetHeight,
      sideBottom = sideHeight + sideOffset,
      detailOffset = app.Util.offset(this.detail).top,
      detailHeight = this.detail.offsetHeight,
      detailBottom = detailHeight + detailOffset,
      innerOffset = app.Util.offset(this.inner).top,
      innerHeight = this.inner.offsetHeight,
      innerBottom = innerOffset + innerHeight,
      bottomPos = 32,
      fixedTop = false,
      fixedBottom = false,
      isBottom = false,
      isMainScroll = false,
      isSideScroll = false;

    const
      sideScroll = ()=>{
        windowBottom = app.Util.wh() + app.Util.sy();
        innerHeight = this.inner.offsetHeight;
        innerBottom = innerOffset + innerHeight;
        // windowサイズより低い時
        if( app.Util.wh() > innerBottom ){
          if( fixedBottom ){
            fixedBottom = false;
            this.inner.classList.remove('fixed-bottom');
          }
          if( !fixedTop ){
            fixedTop = true;
            this.inner.classList.add('fixed-top');
          }
          sideHeight = this.side.offsetHeight;
          sideBottom = sideHeight + sideOffset;
          if( !isBottom && sideBottom < innerBottom + app.Util.sy() ){
            isBottom = true;
            this.inner.classList.add('is-bottom');
          } else if ( isBottom && sideBottom > innerBottom + app.Util.sy() ) {
            isBottom = false;
            this.inner.classList.remove('is-bottom');
          }
        }
        // windowサイズより高い時
        else if ( app.Util.wh() < innerBottom ) {
          if( fixedTop ){
            fixedTop = false;
            this.inner.classList.remove('fixed-top');
          }
          if( !fixedBottom && windowBottom > innerBottom + bottomPos ){
            fixedBottom = true;
            this.inner.classList.add('fixed-bottom');
          } else if (fixedBottom && windowBottom < innerBottom + bottomPos ) {
            fixedBottom = false;
            this.inner.classList.remove('fixed-bottom');
          }
          mainHeight = this.main.offsetHeight;
          mainBottom = mainHeight + mainOffset;
          if( !isBottom && windowBottom > mainBottom + bottomPos ){
            isBottom = true;
            this.inner.classList.add('is-bottom');
          } else if ( isBottom && windowBottom < mainBottom + bottomPos ) {
            isBottom = false;
            this.inner.classList.remove('is-bottom');
          }
        }
      },
      mainScroll = ()=>{
        windowBottom = app.Util.wh() + app.Util.sy();
        detailHeight = this.detail.offsetHeight;
        detailBottom = detailHeight + detailOffset;
        if( !fixedBottom && windowBottom > detailBottom ){
          fixedBottom = true;
          this.detail.classList.add('fixed-bottom');
        } else if (fixedBottom && windowBottom < detailBottom ) {
          fixedBottom = false;
          this.detail.classList.remove('fixed-bottom');
        }
        if( !isBottom && windowBottom > mainBottom ){
          isBottom = true;
          this.detail.classList.add('is-bottom');
        } else if ( isBottom && windowBottom < mainBottom ) {
          isBottom = false;
          this.detail.classList.remove('is-bottom');
        }
      };
    if( app.Util.layoutType() == 'PC' && detailBottom > innerBottom ){
      isSideScroll = true;
      window.addEventListener('scroll',sideScroll);
    } else if ( app.Util.layoutType() == 'PC' && detailBottom < innerBottom ) {
      isMainScroll = true;
      window.addEventListener('scroll',mainScroll);
    }
    app.Util.layoutChange(()=>{
      if( isSideScroll && app.Util.layoutType() != 'PC' ){
        isSideScroll = false;
        if( fixedTop ){
          fixedTop = false;
          this.inner.classList.remove('fixed-top');
        }
        if( fixedBottom ){
          fixedBottom = false;
          this.inner.classList.remove('fixed-bottom');
        }
        if( isBottom ){
          isBottom = false;
          this.inner.classList.remove('is-bottom');
        }
        window.removeEventListener('scroll',sideScroll);
      } else if ( isMainScroll && app.Util.layoutType() != 'PC' ) {
        isMainScroll = false;
        if( fixedBottom ){
          fixedBottom = false;
          this.detail.classList.remove('fixed-bottom');
        }
        if( isBottom ){
          isBottom = false;
          this.detail.classList.remove('is-bottom');
        }
        window.removeEventListener('scroll',mainScroll);
      } else if ( !isSideScroll && app.Util.layoutType() == 'PC' && detailBottom > innerBottom ) {
        isSideScroll = true;
        window.addEventListener('scroll',sideScroll);
      } else if ( !isMainScroll && app.Util.layoutType() == 'PC' && detailBottom < innerBottom ) {
        isMainScroll = true;
        window.addEventListener('scroll',mainScroll);
      }
    });
  }

  share(){
    const
      list = document.querySelector('.m-entry-share__link'),
      copy = list.querySelector('.copy');

    copy.addEventListener('click',(e)=>{
      e.preventDefault();
      let
        clipboard = new ClipboardJS('.clipboard',{
          text: ( trigger )=>{
            return trigger.getAttribute('href');
          }
        });
      clipboard.on('success', (e)=>{
        copy.classList.add('is-copy');
        setTimeout(()=>{
          copy.classList.remove('is-copy');
        },500);
        e.clearSelection();
      });
    });
  }
}
export default Module;
