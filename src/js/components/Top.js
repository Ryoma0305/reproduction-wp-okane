'use strict';

class Top {
  constructor(){}

  render(){
		this.FV = new FV();
		this.FV.render();
  }
}

class FV {
  constructor() {
    this.fv = document.querySelector('.fv');
    this.slider = this.fv.querySelector('.fv-article__slider');
    this.length = this.slider.querySelectorAll('.item').length;
    this.progress;
  }

  render(){
    this.scroll();
    if( this.length > 1 ){
      this.slide();
      this.pointer();
    }
    if( document.querySelector('.top-article') ){
      this.article();
    }
  }

  scroll(){
    const
      observer =  new IntersectionObserver((entries)=>{
        _.each(entries, (entry)=>{
          if( !entry.isIntersecting ){
            document.querySelector('.fv__scroll').classList.remove('is-fixed');
          } else {
            document.querySelector('.fv__scroll').classList.add('is-fixed');
          }
        });
      }, {
        rootMargin: '-100% 0px 0px 0px'
      });
    observer.observe(this.fv);
  }

  slide(){
    let
      items = this.slider.querySelectorAll('.item'),
      length = items.length;
      items[length - 1].classList.add('is-prev');
      items[1].classList.add('is-next');

    $(this.slider).slick({
        centerMode: true,
        slidesToShow: 1,
        centerPadding: '0',
        autoplay: true,
        autoplaySpeed: 3000,
        speed: 400,
        pauseOnFocus: false,
        pauseOnHover: false,
        pauseOnDotsHover: false,
        appendArrows: $('.fv-article__nav'),
        prevArrow: '<div class="fv-article__prev"></div>',
        nextArrow: '<div class="fv-article__next"></div>',
        dots:true,
        appendDots: $('.fv-article__nav'),
        dotsClass: 'fv-article__dots'
      });

    const
      all = this.slider.querySelectorAll('.slick-slide'),
      dots = document.querySelector('.fv-article__dots');

    _.each(dots.querySelectorAll('li'), (dot)=>{
      dot.innerHTML = '<svg class="circle" viewBox="0 0 20 20"><circle class="st0" cx="10" cy="10" r="9"></svg>';
    });

    let
      start = new Date().getTime(),
      tick = ()=>{
        let
          now = new Date().getTime(),
          status = now - start;
        dots.querySelector('.slick-active').querySelector('.circle').style.strokeDashoffset = 60 - status/100 *2;
        this.progress = window.requestAnimationFrame(tick);
        if( status >= 3000 ){
          window.cancelAnimationFrame(this.progress);
        }
      };
    tick();

    // beforeChange
    $(this.slider).on('beforeChange', (event, slick, currentSlide, nextSlide)=>{
      let
        start = new Date().getTime(),
        tick = ()=>{
          let
            now = new Date().getTime(),
            status = now - start;
          dots.querySelector('.slick-active').querySelector('.circle').style.strokeDashoffset = 60 - status/100 * 2;
          this.progress = window.requestAnimationFrame(tick);
          if( status >= 3000 ){
            window.cancelAnimationFrame(this.progress);
          }
        };
      tick();
      if( nextSlide == slick.slideCount - 1 && currentSlide == 0 ){
        items[currentSlide].classList.add('is-next');
        _.each(all, (item)=>{
          if( item.dataset.slickIndex == '-1' ){
            item.classList.add('is-reset');
          }
          if( item.classList.contains('is-reset') ){
            if( item.previousElementSibling.querySelector('.item').classList.contains('is-next') ){
              item.previousElementSibling.querySelector('.item').classList.remove('is-next');
            }
          }
          if( item.dataset.slickIndex == slick.slideCount ){
            item.querySelector('.item').classList.add('is-next');
          }
          if( item.dataset.slickIndex == '-2' ){
            item.querySelector('.item').classList.add('is-prev');
          }
          if( item.dataset.slickIndex == slick.slideCount - 2 ){
            if(item.querySelector('.item').classList.contains('is-next')){
              item.querySelector('.item').classList.remove('is-next');
            }
            item.querySelector('.item').classList.add('is-prev');
          }
        });
      } else if( nextSlide == slick.slideCount - 1 ){
        items[currentSlide].classList.add('is-prev');
        if( items[nextSlide-1].classList.contains('is-next') ){
          items[nextSlide-1].classList.remove('is-next');
          items[nextSlide-1].classList.add('is-prev');
        }
        if( !items[nextSlide-1].classList.contains('is-prev') ){
          items[nextSlide-1].classList.add('is-prev');
        }
        if( !items[nextSlide-2].classList.contains('is-prev') ){
          items[nextSlide-2].classList.add('is-prev');
        }
        _.each(all, (item)=>{
          if( item.dataset.slickIndex == slick.slideCount ){
            item.querySelector('.item').classList.add('is-next');
          }
        });
      } else if ( nextSlide == 0 ) {
        items[currentSlide].classList.add('is-prev');
        _.each(all, (item)=>{
          if( item.dataset.slickIndex == slick.slideCount ){
            item.classList.add('is-reset');
          }
          if( item.dataset.slickIndex == slick.slideCount + 1 ){
            item.querySelector('.item').classList.add('is-next');
          }
          if( item.dataset.slickIndex == '-1' ){
            item.querySelector('.item').classList.add('is-prev');
          }
          if( item.dataset.slickIndex == nextSlide + 1 ){
            item.querySelector('.item').classList.add('is-next');
          }
        });
      } else {
        items[nextSlide+1].classList.add('is-next');
        if( !items[nextSlide-1].classList.contains('is-prev') ){
          items[nextSlide-1].classList.add('is-prev');
        }
        if( items[nextSlide-1].classList.contains('is-next') ){
          items[nextSlide-1].classList.remove('is-next');
        }
      }
    });

    // afterChange
    $(this.slider).on('afterChange',(event, slick, currentSlide)=>{
      _.each(all, (item)=>{
        if(item.classList.contains('is-reset') ){
          item.classList.remove('is-reset');
        }
      });
      if( items[currentSlide].classList.contains('is-next') ){
        items[currentSlide].classList.remove('is-next');
      }
      if( items[currentSlide-2] && items[currentSlide-2].classList.contains('is-next') ){
        items[currentSlide-2].classList.remove('is-next');
      }
      if( items[currentSlide].classList.contains('is-prev') ){
        items[currentSlide].classList.remove('is-prev');
      }
      if( items[currentSlide+2] && items[currentSlide+2].classList.contains('is-prev') ){
        items[currentSlide+2].classList.remove('is-prev');
      }
    });

    const clickarea = this.fv.querySelectorAll('.fv-article__clickarea');
    _.each(clickarea, (area)=>{
      area.addEventListener('click', (e)=>{
        if( e.target.classList.contains('fv-article__slider__left') ){
          $(this.slider).slick('slickPrev');
        } else if ( e.target.classList.contains('fv-article__slider__right') ) {
          $(this.slider).slick('slickNext');
        }
      });
    });
  }

  pointer(){
    let
      article = this.fv.querySelector('.fv-article'),
      isLeft = false,
      isRight = false,
      point_left = article.querySelector('.fv-article__slider__left'),
      point_right = article.querySelector('.fv-article__slider__right'),
      point_prev = this.fv.querySelector('.fv-article__slider__prev'),
      point_next = this.fv.querySelector('.fv-article__slider__next');
    const
      hidden = ()=>{
        if( isLeft ){
          isLeft = false;
          point_prev.classList.add('is-hidden');
        }
        if( isRight ){
          isRight = false;
          point_next.classList.add('is-hidden');
        }
      },
      visible = (e)=>{
        let
          x = e.clientX,
          y = e.clientY,
          pos = app.Util.ww()/2;
        if( pos > x && e.target == point_left ){
          point_prev.style.top = `${y}px`;
          point_prev.style.left = `${x}px`;
          if( !isLeft ){
            isLeft = true;
            point_prev.classList.remove('is-hidden');
          }
        } else {
          if( isLeft ){
            isLeft = false;
            point_prev.classList.add('is-hidden');
          }
        }
        if( pos <= x && e.target == point_right ){
          point_next.style.top = `${y}px`;
          point_next.style.left = `${x}px`;
          if( !isRight ){
            isRight = true;
            point_next.classList.remove('is-hidden');
          }
        } else {
          if( isRight ){
            isRight = false;
            point_next.classList.add('is-hidden');
          }
        }
      },
      init =()=> {
        if( this.isPoint ){
          this.isPoint = false;
          article.removeEventListener('mouseleave',hidden);
          article.removeEventListener('mousemove',visible);
        }
        if( !(app.Util.layoutType() == 'PC') ) return;

        if( !this.isPoint ){
          this.isPoint = true;
          article.addEventListener('mouseleave',hidden);
          article.addEventListener('mousemove',visible);
        }
      };

    init();
    app.Util.layoutChange(()=>{
      init();
    });
  }

  article(){
    let
      section = document.querySelector('.top-article'),
      list = document.querySelector('.top-article__list'),
      items = list.querySelectorAll('.item'),
      head = document.querySelector('.top-article__head'),
      isMove = false,
      isFixed = false,
      isBottom = false,
      fixedPos,
      bottomPos,
      bottomTop,
      fixed = ()=>{
        fixedPos = app.Util.offset(section).top - 125;
        bottomPos = app.Util.offset(list.children[items.length - 3]).top - 125;
        bottomTop = bottomPos - fixedPos;
        if( !isFixed && app.Util.sy() > fixedPos ){
          isFixed = true;
          head.classList.add('is-fixed');
        } else if ( isFixed && app.Util.sy() <= fixedPos ){
          isFixed = false;
          head.classList.remove('is-fixed');
        }
        if( !isBottom && app.Util.sy() > bottomPos ){
          isBottom = true;
          head.classList.add('is-bottom');
          head.classList.remove('is-fixed');
          head.style.top = `${bottomTop}px`;
        } else if ( isBottom && app.Util.sy() <= bottomPos ){
          isBottom = false;
          head.style.top = '0';
          head.classList.add('is-fixed');
          head.classList.remove('is-bottom');
        }
      };
    if( app.Util.layoutType() == 'PC' && items.length > 3 ){
      isMove = true;
      window.addEventListener('load', fixed);
      window.addEventListener('scroll', fixed);
    }
    app.Util.layoutChange(()=>{
      if( isMove ){
        isMove = false;
        window.removeEventListener('load', fixed);
        window.removeEventListener('scroll', fixed);
        if( isFixed ){
          isFixed = false;
          head.classList.remove('is-fixed');
        }
        if( isBottom ){
          head.style.top = '0';
          isBottom = false;
          head.classList.remove('is-bottom');
        }
      } else if( app.Util.layoutType() == 'PC' && !isMove && items.length > 3 ) {
        isMove = true;
        window.addEventListener('load', fixed);
        window.addEventListener('scroll', fixed);
      }
    });
  }
}

export default new Top();
