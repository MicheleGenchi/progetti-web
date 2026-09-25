window.addEvent('domready', function() {
    var opt = {
      duration: 3000,
      delay: 1000,
      auto:true,
      onMouseEnter: function(){this.stop();},
      onMouseLeave: function(){this.play();}
    }
    var scroller = new QScroller('qscroller1',opt);
    scroller.load();
});

