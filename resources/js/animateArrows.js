import Vivus from 'vivus';
jQuery('<div>', {
  class: 'arrow__circle'
}).prependTo('.slick-arrow');
let arrows = $('.arrow__circle');
arrows.each((index,el) => {
  arrows[index] = new Vivus(el,{
    duration:200,
    file:`/images/icons/circle.svg`,
    type:"oneByOne",
    start:"manual"
  })
  $(arrows[index].parentEl.parentElement).on('mouseover', () => {
    arrows[index].play(3);
  })
  $(arrows[index].parentEl.parentElement).on('mouseleave', () => {
    arrows[index].play(-3);
  })
})