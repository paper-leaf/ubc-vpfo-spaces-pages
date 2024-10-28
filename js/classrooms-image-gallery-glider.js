/*! For license information please see classrooms-image-gallery-glider.js.LICENSE.txt */
(()=>{var e,t={185:(e,t,o)=>{"use strict";var i=o(443),r=o.n(i);window.addEventListener("load",(function(){var e=new(r())(document.querySelector(".classroom-image-gallery .glider"),{slidesToShow:1,slidesToScroll:1,draggable:!1,dots:!1,arrows:{prev:document.querySelector(".glider-prev"),next:document.querySelector(".glider-next")}}),t=document.querySelectorAll(".classroom-image-gallery .glider-thumbnails .glider-thumbnail img");function o(e){t.forEach((function(t,o){t.parentElement.classList.toggle("active",o===e)}))}o(0),t.forEach((function(t,i){t.addEventListener("click",(function(){e.scrollItem(i),o(i)}))})),e.ele.addEventListener("glider-slide-visible",(function(e){o(e.detail.slide)}))}))},443:(e,t,o)=>{var i,r;void 0===(r="function"==typeof(i=function(){var e="undefined"!=typeof window?window:this,t=e.Glider=function(t,o){var i=this;if(t._glider)return t._glider;if(i.ele=t,i.ele.classList.add("glider"),i.ele._glider=i,i.opt=Object.assign({},{slidesToScroll:1,slidesToShow:1,resizeLock:!0,duration:.5,passiveListeners:!1,easing:function(e,t,o,i,r){return i*(t/=r)*t+o}},o),i.animate_id=i.page=i.slide=0,i.arrows={},i._opt=i.opt,i.opt.skipTrack)i.track=i.ele.children[0];else for(i.track=document.createElement("div"),i.ele.appendChild(i.track);1!==i.ele.children.length;)i.track.appendChild(i.ele.children[0]);i.track.classList.add("glider-track"),i.init(),i.resize=i.init.bind(i,!0),i.event(i.ele,"add",{scroll:i.updateControls.bind(i)},{passive:i.opt.passiveListeners}),i.event(e,"add",{resize:i.resize})},o=t.prototype;return o.init=function(e,t){var o=this,i=0,r=0;o.slides=o.track.children,[].forEach.call(o.slides,(function(e,t){e.classList.add("glider-slide"),e.setAttribute("data-gslide",t)})),o.containerWidth=o.ele.clientWidth;var s=o.settingsBreakpoint();if(t||(t=s),"auto"===o.opt.slidesToShow||void 0!==o.opt._autoSlide){var l=o.containerWidth/o.opt.itemWidth;o.opt._autoSlide=o.opt.slidesToShow=o.opt.exactWidth?l:Math.max(1,Math.floor(l))}"auto"===o.opt.slidesToScroll&&(o.opt.slidesToScroll=Math.floor(o.opt.slidesToShow)),o.itemWidth=o.opt.exactWidth?o.opt.itemWidth:o.containerWidth/o.opt.slidesToShow,[].forEach.call(o.slides,(function(e){e.style.height="auto",e.style.width=o.itemWidth+"px",i+=o.itemWidth,r=Math.max(e.offsetHeight,r)})),o.track.style.width=i+"px",o.trackWidth=i,o.isDrag=!1,o.preventClick=!1,o.move=!1,o.opt.resizeLock&&o.scrollTo(o.slide*o.itemWidth,0),(s||t)&&(o.bindArrows(),o.buildDots(),o.bindDrag()),o.updateControls(),o.emit(e?"refresh":"loaded")},o.bindDrag=function(){var e=this;e.mouse=e.mouse||e.handleMouse.bind(e);var t=function(){e.mouseDown=void 0,e.ele.classList.remove("drag"),e.isDrag&&(e.preventClick=!0),e.isDrag=!1};const o=function(){e.move=!0};var i={mouseup:t,mouseleave:t,mousedown:function(t){t.preventDefault(),t.stopPropagation(),e.mouseDown=t.clientX,e.ele.classList.add("drag"),e.move=!1,setTimeout(o,300)},touchstart:function(t){e.ele.classList.add("drag"),e.move=!1,setTimeout(o,300)},mousemove:e.mouse,click:function(t){e.preventClick&&e.move&&(t.preventDefault(),t.stopPropagation()),e.preventClick=!1,e.move=!1}};e.ele.classList.toggle("draggable",!0===e.opt.draggable),e.event(e.ele,"remove",i),e.opt.draggable&&e.event(e.ele,"add",i,{passive:e.opt.passiveListeners})},o.buildDots=function(){var e=this;if(e.opt.dots){if("string"==typeof e.opt.dots?e.dots=document.querySelector(e.opt.dots):e.dots=e.opt.dots,e.dots){e.dots.innerHTML="",e.dots.setAttribute("role","tablist"),e.dots.classList.add("glider-dots");for(var t=0;t<Math.ceil(e.slides.length/e.opt.slidesToShow);++t){var o=document.createElement("button");o.dataset.index=t,o.setAttribute("aria-label","Page "+(t+1)),o.setAttribute("role","tab"),o.className="glider-dot "+(t?"":"active"),e.event(o,"add",{click:e.scrollItem.bind(e,t,!0)}),e.dots.appendChild(o)}}}else e.dots&&(e.dots.innerHTML="")},o.bindArrows=function(){var e=this;e.opt.arrows?["prev","next"].forEach((function(t){var o=e.opt.arrows[t];o&&("string"==typeof o&&(o=document.querySelector(o)),o&&(o._func=o._func||e.scrollItem.bind(e,t),e.event(o,"remove",{click:o._func}),e.event(o,"add",{click:o._func}),e.arrows[t]=o))})):Object.keys(e.arrows).forEach((function(t){var o=e.arrows[t];e.event(o,"remove",{click:o._func})}))},o.updateControls=function(e){var t=this;e&&!t.opt.scrollPropagate&&e.stopPropagation();var o=t.containerWidth>=t.trackWidth;t.opt.rewind||(t.arrows.prev&&(t.arrows.prev.classList.toggle("disabled",t.ele.scrollLeft<=0||o),t.arrows.prev.setAttribute("aria-disabled",t.arrows.prev.classList.contains("disabled"))),t.arrows.next&&(t.arrows.next.classList.toggle("disabled",Math.ceil(t.ele.scrollLeft+t.containerWidth)>=Math.floor(t.trackWidth)||o),t.arrows.next.setAttribute("aria-disabled",t.arrows.next.classList.contains("disabled")))),t.slide=Math.round(t.ele.scrollLeft/t.itemWidth),t.page=Math.round(t.ele.scrollLeft/t.containerWidth);var i=t.slide+Math.floor(Math.floor(t.opt.slidesToShow)/2),r=Math.floor(t.opt.slidesToShow)%2?0:i+1;1===Math.floor(t.opt.slidesToShow)&&(r=0),t.ele.scrollLeft+t.containerWidth>=Math.floor(t.trackWidth)&&(t.page=t.dots?t.dots.children.length-1:0),[].forEach.call(t.slides,(function(e,o){var s=e.classList,l=s.contains("visible"),a=t.ele.scrollLeft,n=t.ele.scrollLeft+t.containerWidth,d=t.itemWidth*o,c=d+t.itemWidth;[].forEach.call(s,(function(e){/^left|right/.test(e)&&s.remove(e)})),s.toggle("active",t.slide===o),i===o||r&&r===o?s.add("center"):(s.remove("center"),s.add([o<i?"left":"right",Math.abs(o-(o<i?i:r||i))].join("-")));var u=Math.ceil(d)>=Math.floor(a)&&Math.floor(c)<=Math.ceil(n);s.toggle("visible",u),u!==l&&t.emit("slide-"+(u?"visible":"hidden"),{slide:o})})),t.dots&&[].forEach.call(t.dots.children,(function(e,o){e.classList.toggle("active",t.page===o)})),e&&t.opt.scrollLock&&(clearTimeout(t.scrollLock),t.scrollLock=setTimeout((function(){clearTimeout(t.scrollLock),Math.abs(t.ele.scrollLeft/t.itemWidth-t.slide)>.02&&(t.mouseDown||t.trackWidth>t.containerWidth+t.ele.scrollLeft&&t.scrollItem(t.getCurrentSlide()))}),t.opt.scrollLockDelay||250))},o.getCurrentSlide=function(){var e=this;return e.round(e.ele.scrollLeft/e.itemWidth)},o.scrollItem=function(e,t,o){o&&o.preventDefault();var i=this,r=e;++i.animate_id;var s,l=i.slide;if(!0===t)s=(e=Math.round(e*i.containerWidth/i.itemWidth))*i.itemWidth;else{if("string"==typeof e){var a="prev"===e;if(e=i.opt.slidesToScroll%1||i.opt.slidesToShow%1?i.getCurrentSlide():i.slide,a?e-=i.opt.slidesToScroll:e+=i.opt.slidesToScroll,i.opt.rewind){var n=i.ele.scrollLeft;e=a&&!n?i.slides.length:!a&&n+i.containerWidth>=Math.floor(i.trackWidth)?0:e}}e=Math.max(Math.min(e,i.slides.length),0),i.slide=e,s=i.itemWidth*e}return i.emit("scroll-item",{prevSlide:l,slide:e}),i.scrollTo(s,i.opt.duration*Math.abs(i.ele.scrollLeft-s),(function(){i.updateControls(),i.emit("animated",{value:r,type:"string"==typeof r?"arrow":t?"dot":"slide"})})),!1},o.settingsBreakpoint=function(){var t=this,o=t._opt.responsive;if(o){o.sort((function(e,t){return t.breakpoint-e.breakpoint}));for(var i=0;i<o.length;++i){var r=o[i];if(e.innerWidth>=r.breakpoint)return t.breakpoint!==r.breakpoint&&(t.opt=Object.assign({},t._opt,r.settings),t.breakpoint=r.breakpoint,!0)}}var s=0!==t.breakpoint;return t.opt=Object.assign({},t._opt),t.breakpoint=0,s},o.scrollTo=function(t,o,i){var r=this,s=(new Date).getTime(),l=r.animate_id,a=function(){var n=(new Date).getTime()-s;r.ele.scrollLeft=r.ele.scrollLeft+(t-r.ele.scrollLeft)*r.opt.easing(0,n,0,1,o),n<o&&l===r.animate_id?e.requestAnimationFrame(a):(r.ele.scrollLeft=t,i&&i.call(r))};e.requestAnimationFrame(a)},o.removeItem=function(e){var t=this;t.slides.length&&(t.track.removeChild(t.slides[e]),t.refresh(!0),t.emit("remove"))},o.addItem=function(e){var t=this;t.track.appendChild(e),t.refresh(!0),t.emit("add")},o.handleMouse=function(e){var t=this;t.mouseDown&&(t.isDrag=!0,t.ele.scrollLeft+=(t.mouseDown-e.clientX)*(t.opt.dragVelocity||3.3),t.mouseDown=e.clientX)},o.round=function(e){var t=1/(this.opt.slidesToScroll%1||1);return Math.round(e*t)/t},o.refresh=function(e){this.init(!0,e)},o.setOption=function(e,t){var o=this;o.breakpoint&&!t?o._opt.responsive.forEach((function(t){t.breakpoint===o.breakpoint&&(t.settings=Object.assign({},t.settings,e))})):o._opt=Object.assign({},o._opt,e),o.breakpoint=0,o.settingsBreakpoint()},o.destroy=function(){var t=this,o=t.ele.cloneNode(!0),i=function(e){e.removeAttribute("style"),[].forEach.call(e.classList,(function(t){/^glider/.test(t)&&e.classList.remove(t)}))};t.opt.skipTrack||(o.children[0].outerHTML=o.children[0].innerHTML),i(o),[].forEach.call(o.getElementsByTagName("*"),i),t.ele.parentNode.replaceChild(o,t.ele),t.event(e,"remove",{resize:t.resize}),t.emit("destroy")},o.emit=function(t,o){var i=this,r=new e.CustomEvent("glider-"+t,{bubbles:!i.opt.eventPropagate,detail:o});i.ele.dispatchEvent(r)},o.event=function(e,t,o){var i=e[t+"EventListener"].bind(e);Object.keys(o).forEach((function(e){i(e,o[e])}))},t})?i.call(t,o,t,e):i)||(e.exports=r)},770:()=>{}},o={};function i(e){var r=o[e];if(void 0!==r)return r.exports;var s=o[e]={exports:{}};return t[e](s,s.exports,i),s.exports}i.m=t,e=[],i.O=(t,o,r,s)=>{if(!o){var l=1/0;for(c=0;c<e.length;c++){for(var[o,r,s]=e[c],a=!0,n=0;n<o.length;n++)(!1&s||l>=s)&&Object.keys(i.O).every((e=>i.O[e](o[n])))?o.splice(n--,1):(a=!1,s<l&&(l=s));if(a){e.splice(c--,1);var d=r();void 0!==d&&(t=d)}}return t}s=s||0;for(var c=e.length;c>0&&e[c-1][2]>s;c--)e[c]=e[c-1];e[c]=[o,r,s]},i.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return i.d(t,{a:t}),t},i.d=(e,t)=>{for(var o in t)i.o(t,o)&&!i.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},i.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={75:0,314:0};i.O.j=t=>0===e[t];var t=(t,o)=>{var r,s,[l,a,n]=o,d=0;if(l.some((t=>0!==e[t]))){for(r in a)i.o(a,r)&&(i.m[r]=a[r]);if(n)var c=n(i)}for(t&&t(o);d<l.length;d++)s=l[d],i.o(e,s)&&e[s]&&e[s][0](),e[s]=0;return i.O(c)},o=self.webpackChunkubc_vpfo_spaces_pages=self.webpackChunkubc_vpfo_spaces_pages||[];o.forEach(t.bind(null,0)),o.push=t.bind(null,o.push.bind(o))})(),i.O(void 0,[314],(()=>i(185)));var r=i.O(void 0,[314],(()=>i(770)));r=i.O(r)})();