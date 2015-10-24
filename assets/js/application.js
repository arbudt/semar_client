// NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
// IT'S ALL JUST JUNK FOR OUR DOCS!
// ++++++++++++++++++++++++++++++++++++++++++

!function ($) {

  $(function(){

    var $window = $(window)

    // Disable certain links in docs
    $('section [href^=#]').click(function (e) {
      e.preventDefault()
    })

    // side bar
    setTimeout(function () {
      $('.bs-docs-sidenav').affix({
        offset: {
          top: function () { return $window.width() <= 980 ? 290 : 210 }
        , bottom: 270
        }
      })
    }, 100)

    // make code pretty
    window.prettyPrint && prettyPrint()

    // add-ons
    $('.add-on :checkbox').on('click', function () {
      var $this = $(this)
        , method = $this.attr('checked') ? 'addClass' : 'removeClass'
      $(this).parents('.add-on')[method]('active')
    })

    // add tipsies to grid for scaffolding
    if ($('#gridSystem').length) {
      $('#gridSystem').tooltip({
          selector: '.show-grid > [class*="span"]'
        , title: function () { return $(this).width() + 'px' }
      })
    }

    // tooltip demo
    $('.tooltip-demo').tooltip({
      selector: "a[data-toggle=tooltip]"
    })

    $('.tooltip-test').tooltip()
    $('.popover-test').popover()

    // popover demo
    $("a[data-toggle=popover]")
      .popover()
      .click(function(e) {
        e.preventDefault()
      })

    // button state demo
    $('#fat-btn')
      .click(function () {
        var btn = $(this)
        btn.button('loading')
        setTimeout(function () {
          btn.button('reset')
        }, 3000)
      })

    // carousel demo
    // $('#myCarousel').carousel()
    // $('#myCarousel2').carousel()

    // javascript build logic
    var inputsComponent = $("#components.download input")
      , inputsPlugin = $("#plugins.download input")
      , inputsVariables = $("#variables.download input")

    // toggle all plugin checkboxes
    $('#components.download .toggle-all').on('click', function (e) {
      e.preventDefault()
      inputsComponent.attr('checked', !inputsComponent.is(':checked'))
    })

    $('#plugins.download .toggle-all').on('click', function (e) {
      e.preventDefault()
      inputsPlugin.attr('checked', !inputsPlugin.is(':checked'))
    })

    $('#variables.download .toggle-all').on('click', function (e) {
      e.preventDefault()
      inputsVariables.val('')
    })

    // request built javascript
    $('.download-btn .btn').on('click', function () {

      var css = $("#components.download input:checked")
            .map(function () { return this.value })
            .toArray()
        , js = $("#plugins.download input:checked")
            .map(function () { return this.value })
            .toArray()
        , vars = {}
        , img = ['glyphicons-halflings.png', 'glyphicons-halflings-white.png']

    $("#variables.download input")
      .each(function () {
        $(this).val() && (vars[ $(this).prev().text() ] = $(this).val())
      })

      $.ajax({
        type: 'POST'
      , url: /\?dev/.test(window.location) ? 'http://localhost:3000' : 'http://bootstrap.herokuapp.com'
      , dataType: 'jsonpi'
      , params: {
          js: js
        , css: css
        , vars: vars
        , img: img
      }
      })
    })
  })

// Modified from the original jsonpi https://github.com/benvinegar/jquery-jsonpi
$.ajaxTransport('jsonpi', function(opts, originalOptions, jqXHR) {
  var url = opts.url;

  return {
    send: function(_, completeCallback) {
      var name = 'jQuery_iframe_' + jQuery.now()
        , iframe, form

      iframe = $('<iframe>')
        .attr('name', name)
        .appendTo('head')

      form = $('<form>')
        .attr('method', opts.type) // GET or POST
        .attr('action', url)
        .attr('target', name)

      $.each(opts.params, function(k, v) {

        $('<input>')
          .attr('type', 'hidden')
          .attr('name', k)
          .attr('value', typeof v == 'string' ? v : JSON.stringify(v))
          .appendTo(form)
      })

      form.appendTo('body').submit()
    }
  }
})


//right post hover
$(function() {
        /**
        * the list of posts
        */
        var list = $('#rp_list ul');
        /**
        * number of related posts
        */
        var elems_cnt = list.children().length;
        
        /**
        * show the first set of posts.
        * 200 is the initial left margin for the list elements
        */
        load(200);
        
        function load(initial){
          list.find('li').hide().andSelf().find('div').css('margin-left',-initial+'px');
          var loaded = 0;
          //show 5 random posts from all the ones in the list. 
          //Make sure not to repeat
          while(loaded < 5){
            var r = Math.floor(Math.random()*elems_cnt);
            var elem = list.find('li:nth-child('+ (r+1) +')');
            if(elem.is(':visible'))
              continue;
            else
              elem.show();
            ++loaded;
          }
          //animate them
          var d = 200;
          list.find('li:visible div').each(function(){
            $(this).stop().animate({
              'marginLeft':'-50px'
            },d += 100);
          });
        }
          
        /**
        * hovering over the list elements makes them slide out
        */  
        list.find('li:visible').on('mouseenter',function () {
          $(this).find('div').stop().animate({
            'marginLeft':'-220px'
          },200);
        }).on('mouseleave',function () {
          $(this).find('div').stop().animate({
            'marginLeft':'-50px'
          },200);
        });
        
        /**
        * when clicking the shuffle button,
        * show 5 random posts
        */
        $('#rp_shuffle').unbind('click')
                .bind('click',shuffle)
                .stop()
                .animate({'margin-left':'-18px'},700);
                
        function shuffle(){
          list.find('li:visible div').stop().animate({
            'marginLeft':'60px'
          },200,function(){
            load(-60);
          });
        }
            });

jQuery.extend(jQuery.validator.messages, {
    required: "perlu diisi",
    remote: "Please fix this field.",
    email: "Please enter a valid email address.",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});

// by nanda
String.prototype.padding = function(paddingPlacehold, paddingPos) {
  if(paddingPos == 'right') {
    return String(this + paddingPlacehold).slice(0,paddingPlacehold.length);
  }
  else {
    return String(paddingPlacehold + this).slice(-paddingPlacehold.length);
  };
};

// by nanda
Object.defineProperty(Object.prototype, "toType", {
  enumerable: false,
  writable: true,
  value: function () {
    return ({}).toString.call(this).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
  }
});

}(window.jQuery)

// by nanda
$.fn.changeAlertClass = function(classname) {
  var reg = /^alert-/;
  return $(this).removeClass(function(index, classes) {
    return classes.split(/\s+/).filter(function(c) {
      return reg.test(c);
    }).join(' ');
  })
  .addClass('alert-'+classname);
};

// by nanda
function popupCenter(pageURL, title,w,h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  var specs = 'toolbar=no, location=no, status=no, menubar=no, resizable=no, scrollbars=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left;
  var targetWin = window.open(pageURL, title, specs);
}

// by nova
// Prevent the backspace key from navigating back.
$(document).unbind('keydown').bind('keydown', function (event) {
    var doPrevent = false;
    if (event.keyCode === 8) {
        var d = event.srcElement || event.target;
        if ((d.tagName.toUpperCase() === 'INPUT' && (d.type.toUpperCase() === 'TEXT' || d.type.toUpperCase() === 'PASSWORD' || d.type.toUpperCase() === 'FILE')) 
             || d.tagName.toUpperCase() === 'TEXTAREA' || (d.tagName.toUpperCase() === 'DIV' && d.id == 'editor')) {
            doPrevent = d.readOnly || d.disabled;
        }
        else {
            doPrevent = true;
        }
    }

    if (doPrevent) {
        event.preventDefault();
    }
});

// by nanda to communicate with local/session storage html5
// save to local/session storage
Storage.prototype.setObject = function(key, value) {
  this.setItem(key, JSON.stringify(value));
}
// get from local/session storage
Storage.prototype.getObject = function(key) {
  var value = this.getItem(key);
  return value && JSON.parse(value);
}

// by nanda untuk menampilkan judul modul di title document
$(document).ready(function() {
  var title = $('.blinker').text().replace(/(.*)\((.*)\)/g,'$1').replace(/(.*)-(.*)/g,'$2').trim();
  var oldtitle = document.title;
  if (title.length > 0) {
    document.title = title.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();})+' - '+oldtitle;
  };
});


// by nanda fungsi pindah kolom di handsontable
function moveNextCol(table_id, increment) {
  var writeablecell = false;
  var nextcol = increment;
  var sign = increment > 0 ? 1 : -1;
  var $hotInstance = $('#'+table_id).handsontable('getInstance');
  while(!writeablecell) {
    if ($hotInstance.getCellMeta(tempPos[0],tempPos[1]+nextcol).readOnly) {
      nextcol = nextcol + increment;
    }
    else {
      writeablecell = true;
    };
  }
  return {row: 0,col: nextcol*sign};
};