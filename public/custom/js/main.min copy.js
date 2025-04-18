'use strict';
$(function () {
  var t,
    e,
    o,
    i = {
      1: {
        filename: 'men1',
        color: [
          { id: '1', filename: 'blue', color: '0268b0' },
          { id: '2', filename: 'white', color: 'ffffff' },
        ],
      },
      2: {
        filename: 'women',
        color: [
          { id: '3', filename: 'black', color: '000000' },
          { id: '4', filename: 'white', color: 'ffffff' },
        ],
      },
    },
    n = 570,
    a = 20,
    l = 'front',
    r = {},
    c = 260,
    s = 350,
    d = 155,
    f = 1e3;
  (e = new fabric.Canvas('mainCanvas_front', { preserveObjectStacking: !0 })),
    (o = new fabric.Canvas('mainCanvas_back', { preserveObjectStacking: !0 })),
    (t = e),
    y(),
    fabric.Image.fromURL('', function (e) {
      t.add(e),
        e.scaleToWidth(0.8 * t.get('width')),
        e.viewportCenter().setCoords(),
        t.renderAll();
    });
  var u = new fabric.IText('', {
    fill: '#ff0000',
    stroke: '#000',
    fontSize: f,
  });
  function g(t) {
    t.target.set({ cornerSize: a }),
      p(t),
      $('.cvtoolbox', '#centerLayoutContainer').show(),
      t.target.isType('i-text')
        ? (L(t.target), $('.texttoolbox', '#rightLayoutContainer').show())
        : $('.texttoolbox', '#rightLayoutContainer').hide();
  }
  function b(t) {
    $('.cvtoolbox', '#centerLayoutContainer').hide(),
      $('.cvtoolbox_info', '#centerLayoutContainer').hide(),
      $('.texttoolbox', '#rightLayoutContainer').show();
  }
  function h(e) {
    p(e),
      e.target.isType('i-text') &&
        0 == e.target.get('text').length &&
        t.remove(e.target);
  }
  function p(t) {
    if (
      t.target.isType('image') &&
      (t.target.get('scaleX') > 1 || t.target.get('scaleY') > 1)
    )
      A(
        "<i class='fa fa-warning'></i> The scaled image is larger than the original image. The quality may decrease."
      );
    else if (t.target.isType('group')) {
      for (
        var e = t.target.getObjects(),
          o = t.target.get('scaleX'),
          i = t.target.get('scaleY'),
          n = !1,
          a = 0;
        a < e.length;
        a++
      )
        if (
          e[a].isType('image') &&
          (e[a].get('scaleX') * o > 1 || e[a].get('scaleY') * i > 1)
        ) {
          A(
            "<i class='fa fa-warning'></i> The scaled image is larger than the original image. The quality may decrease."
          ),
            (n = !0);
          break;
        }
      n || C('');
    } else C('');
  }
  function v(e) {
    (r[$(t.getElement()).attr('id')] = {
      width: t.get('width') / t.getZoom() - e.target.get('left') - 10,
      scaleX: e.target.get('scaleX'),
    }),
      e.target.setSelectionEnd(e.target.get('text').length),
      e.target.setSelectionStart(e.target.get('text').length),
      t.renderAll(),
      L(e.target);
  }
  function m(t) {
    t.target.isType('i-text') && L(t.target);
  }
  function x(e) {
    if ((e.target.initDimensions(), e.target.get('text').length > 0)) {
      var o = $(t.getElement()).attr('id'),
        i = r[o].width / e.target.getScaledWidth();
      (i < 1 || r[o].scaleX > e.target.get('scaleX')) &&
        (e.target.get('scaleX') * i > r[o].scaleX &&
          (i = r[o].scaleX / e.target.get('scaleX')),
        e.target.set('scaleX', e.target.get('scaleX') * i),
        e.target.set('scaleY', e.target.get('scaleY') * i),
        e.target.setCoords(),
        t.renderAll());
    }
  }
  function _() {
    var t = $(
        'input[name=form_shirt_type]:checked',
        '#leftLayoutContainer'
      ).val(),
      e = $(
        'input[name=form_shirt_color]:checked',
        '#centerLayoutContainer'
      ).val(),
      o = $.grep(i[t].color, function (t) {
        return t.id == e;
      });
    o.length > 0 &&
      $('#img_shirt').attr(
        'src',
        '/custom/images/' + 
        i[t].filename +
          '_' +
          o[0].filename +
          '_' +
          l +
          '.png'
      );
  }
  function y() {
    $('#centerLayoutContainer').height(
      $('#centerLayoutContainer div.shirt').width()
    );
    var t = w();
    $('#div_canvas_front').css('margin-top', d * t),
      $('#div_canvas_back').css('margin-top', d * t),
      e.setWidth(c * t),
      e.setHeight(s * t),
      e.setZoom(k()),
      e.renderAll(),
      o.setWidth(c * t),
      o.setHeight(s * t),
      o.setZoom(k()),
      o.renderAll();
  }
  function w() {
    return $('#centerLayoutContainer div.shirt').width() / n;
  }
  function k() {
    return (c * w()) / f;
  }
  function C(t) {
    $('.cvtoolbox_info div span', '#centerLayoutContainer').text(t),
      $('.cvtoolbox_info', '#centerLayoutContainer')
        .removeClass('warning_msg')
        .show();
  }
  function A(t) {
    $('.cvtoolbox_info div span', '#centerLayoutContainer').html(t),
      $('.cvtoolbox_info', '#centerLayoutContainer')
        .addClass('warning_msg')
        .show();
  }
  function L(e) {
    var o = '<div class="" data-toggle="buttons">';
    'bold' == e.get('fontWeight')
      ? (o +=
          '<label class="btn btn-default text-tool active" id="texttoolbox_bold"><input type="checkbox" autocomplete="off" istool="bold" checked><i class="fa fa-bold me-1"></i>Wight</label>')
      : (o +=
          '<label class="btn btn-default text-tool" id="texttoolbox_bold"><input type="checkbox" autocomplete="off" istool="bold"><i class="fa fa-bold me-1"></i>Wight</label>'),
      'italic' == e.get('fontStyle')
        ? (o +=
            '<label class="btn btn-default text-tool active" id="texttoolbox_italic"><input type="checkbox" autocomplete="off" istool="italic" checked><i class="fa fa-italic me-1"></i>Style</label>')
        : (o +=
            '<label class="btn btn-default text-tool" id="texttoolbox_italic"><input type="checkbox" autocomplete="off" istool="italic"><i class="fa fa-italic me-1"></i>Style</label>'),
      e.get('underline')
        ? (o +=
            '<label class="btn btn-default text-tool active" id="texttoolbox_underline"><input type="checkbox" autocomplete="off" istool="underline" checked><i class="fa fa-underline me-1"></i>Transform</label>')
        : (o +=
            '<label class="btn btn-default text-tool" id="texttoolbox_underline"><input type="checkbox" autocomplete="off" istool="underline"><i class="fa fa-underline me-1"></i>Transform</label>'),
      e.get('linethrough')
        ? (o +=
            '<label class="btn btn-default text-tool active" id="texttoolbox_strikethrough"><input type="checkbox" autocomplete="off" istool="strikethrough" checked><i class="fa fa-strikethrough me-1"></i>Strikethrough</label>')
        : (o +=
            '<label class="btn btn-default text-tool" id="texttoolbox_strikethrough"><input type="checkbox" autocomplete="off" istool="strikethrough"><i class="fa fa-strikethrough me-1"></i>Strikethrough</label>'),
      e.isEditing
        ? (o +=
            '<label class="btn btn-default text-tool active" id="texttoolbox_edit"><input type="checkbox" autocomplete="off" istool="edit" checked><i class="fa fa-pencil-square-o fa-lg me-1"></i>Edit</label>')
        : (o +=
            '<label class="btn btn-default text-tool" id="texttoolbox_edit"><input type="checkbox" autocomplete="off" istool="edit"><i class="fa fa-pencil-square-o fa-lg me-1"></i>Edit</label>'),
      (o +=
        '<label class=" btn btn-default text-tool colorpicker-component" id="texttoolbox_color">'),
      (o +=
        '<span class=" add-on"><i class="me-1" ></i>Color</span>'),
      (o += '</label>'),
      (o += '</div>'),

      (o +=
        '<h4 class="mb-2 mt-4">Font</h4>'),
      (o += '</h4>'),

      (o += '<div class="input-group">'),
      (o +=
        '<select id="texttoolbox_font" style="width: calc(100% - 40px);"><option value="Times New Roman">Times New Roman</option><option value="Pacifico">Pacifico</option><option value="VT323">VT323</option><option value="Quicksand">Quicksand</option><option value="Inconsolata">Inconsolata</option></select>'),
      (o += '</div>'),
      $('.texttoolbox', '#rightLayoutContainer').html(o),
      $('#texttoolbox_color')
        .colorpicker({ format: 'hex', color: e.get('fill') })
        .on('changeColor', T),
      $('#texttoolbox_font').val(e.get('fontFamily')),
      $('#texttoolbox_font').on('change', function (e) {
        var o = t.getActiveObject();
        o &&
          o.isType('i-text') &&
          ('Times New Roman' !== this.value
            ? (function (e, o) {
                new FontFaceObserver(e).load().then(function () {
                  o.set('fontFamily', e), t.renderAll();
                });
              })(this.value, o)
            : (o.set('fontFamily', this.value), t.renderAll()));
      });
  }
  function T(e) {
    var o = t.getActiveObject();
    o && o.isType('i-text') && (o.set('fill', e.color.toHex()), t.renderAll());
  }
  t.add(u),
    u.scaleToWidth(t.get('width') / 2),
    u.viewportCenterH().setCoords(),
    t.renderAll(),
    e.on('selection:created', g),
    o.on('selection:created', g),
    e.on('selection:updated', g),
    o.on('selection:updated', g),
    e.on('selection:cleared', b),
    o.on('selection:cleared', b),
    e.on('object:modified', h),
    o.on('object:modified', h),
    e.on('text:editing:entered', v),
    o.on('text:editing:entered', v),
    e.on('text:editing:exited', m),
    o.on('text:editing:exited', m),
    e.on('text:changed', x),
    o.on('text:changed', x),
    $(window).on('resize', function () {
      y();
    }),
    $('#toolbox_left').on('click', function () {
      C('Move left');
      var e = t.getActiveObject();
      return (
        e &&
          (e.set('left', e.get('left') - 1 / k()).setCoords(), t.renderAll()),
        !1
      );
    }),
    $('#toolbox_right').on('click', function () {
      C('Move right');
      var e = t.getActiveObject();
      return (
        e &&
          (e.set('left', e.get('left') + 1 / k()).setCoords(), t.renderAll()),
        !1
      );
    }),
    $('#toolbox_up').on('click', function () {
      C('Move up');
      var e = t.getActiveObject();
      return (
        e && (e.set('top', e.get('top') - 1 / k()).setCoords(), t.renderAll()),
        !1
      );
    }),
    $('#toolbox_down').on('click', function () {
      C('Move down');
      var e = t.getActiveObject();
      return (
        e && (e.set('top', e.get('top') + 1 / k()).setCoords(), t.renderAll()),
        !1
      );
    }),
    $('#toolbox_center').on('click', function () {
      C('Center');
      var e = t.getActiveObject();
      return e && (e.viewportCenter().setCoords(), t.renderAll()), !1;
    }),
    $('#toolbox_centerh').on('click', function () {
      C('Center horizontally');
      var e = t.getActiveObject();
      return e && (e.viewportCenterH().setCoords(), t.renderAll()), !1;
    }),
    $('#toolbox_centerv').on('click', function () {
      C('Center vertically');
      var e = t.getActiveObject();
      return e && (e.viewportCenterV().setCoords(), t.renderAll()), !1;
    }),
    $('#toolbox_flipx').on('click', function () {
      C('Flip vertically');
      var e = t.getActiveObject();
      return e && (e.set('flipX', !e.get('flipX')), t.renderAll()), !1;
    }),
    $('#toolbox_flipy').on('click', function () {
      C('Flip horizontally');
      var e = t.getActiveObject();
      return e && (e.set('flipY', !e.get('flipY')), t.renderAll()), !1;
    }),
    $('#toolbox_totop').on('click', function () {
      C('Bring to front');
      var e = t.getActiveObject();
      return e && (t.bringToFront(e), t.renderAll()), !1;
    }),
    $('#toolbox_tobottom').on('click', function () {
      C('Send to back');
      var e = t.getActiveObject();
      return e && (t.sendToBack(e), t.renderAll()), !1;
    }),
    $('#toolbox_remove').on('click', function () {
      C('Remove');
      var e = t.getActiveObject(),
        o = t.getActiveObjects();
      return (
        o.length > 1
          ? (t.discardActiveObject(),
            o.forEach(function (e) {
              t.remove(e);
            }))
          : e && t.remove(e),
        !1
      );
    }),
    $('input[name=form_shirt_type]', '#leftLayoutContainer').on(
      'change',
      function () {

        for (var t = '', e = 0; e < i[this.value].color.length; e++)
          t +=
            '<span class="btn colorButton ' +
            (0 == e ? 'active' : '') +
            '" style="background-color: #' +
            i[this.value].color[e].color +
            ';"><input type="radio" name="form_shirt_color" value="' +
            i[this.value].color[e].id +
            '" autocomplete="off" ' +
            (0 == e ? 'checked' : '') +
            ' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
        return (
          i[this.value].color.length < 2
            ? ($('#div_colors_title').hide(), $('#div_colors').html(t).hide())
            : ($('#div_colors_title').show(), $('#div_colors').html(t).show()),
            $('#img_shirt').attr(
              'src',
              '/custom/images/' + 
              i[this.value].filename + 
                  '_' + 
                  i[this.value].color[0].filename + 
                  '_' + 
                  l + 
                  '.png'
          ),
          !1
        );
      }
    ),
    $('#div_colors').on('change', function (t) {
      return $(t.target).is('input') && _(), !1;
    }),
    $('input[name=form_shirt_side]', '#centerLayoutContainer').on(
      'change',
      function () {
        if (
          ('front' == (l = this.value)
            ? ((t = e),
              $('#div_canvas_back').hide(),
              $('#div_canvas_front').show()
            )

            : ((t = o),
              $('#div_canvas_front').hide(),
              $('#div_canvas_back').show()
            ),
          t.getActiveObject())
        ) {

          $('.cvtoolbox', '#centerLayoutContainer').show();
          var i = t.getActiveObject();
          i && i.isType('i-text')
            ? (L(i), 
            $('.texttoolbox', '#rightLayoutContainer').show()
          )
            : $('.texttoolbox', '#rightLayoutContainer').show();
        } 
        // else

          // $('.cvtoolbox', '#centerLayoutContainer').hide(),
          //   $('.cvtoolbox_info', '#centerLayoutContainer').hide(),
          //   $('.texttoolbox', '#rightLayoutContainer').hide();
        return _(), !1;
      }
    ),
    $('#albumModal').on('click', function (e) {
      var o,
        i = $(e.target);

      if (i.is('img') && i.attr('bgsrc'))
        return (

          (o = i.attr('bgsrc')),
          // $('#albumModal').modal('hide'),
          fabric.Image.fromURL(o, function (e) {
            t.add(e),
              e.get('width') * k() > t.get('width') / 2 &&
                e.scaleToWidth(t.get('width') / 2),
              e.viewportCenter().setCoords(),
              t.setActiveObject(e),
              t.renderAll();
          }),
          !1
        );
    }),
    $('input[name=image_upload]', '#rightLayoutContainer').on(
      'change',
      function () {
        if (this.value && this.files && this.files[0]) {
          var e = $('#frm_upload label i'),
            o = $('#rightLayoutContainer .message');
          e.removeClass('fa-picture-o').addClass('fa-spinner fa-pulse'),
            o.text('');
          var i = new FileReader();
          (i.onload = function (i) {
            $('input[name=image_upload]', '#rightLayoutContainer').val(''),
              e.removeClass('fa-spinner fa-pulse').addClass('fa-picture-o'),
              o.text(''),
              fabric.Image.fromURL(i.target.result, function (e) {
                t.add(e),
                  e.get('width') * k() > t.get('width') / 2 &&
                    e.scaleToWidth(t.get('width') / 2),
                  e.viewportCenter().setCoords(),
                  t.setActiveObject(e),
                  t.renderAll();
              });
          }),
            i.readAsDataURL(this.files[0]);
        }
        return !1;
      }
    ),
    $('#btn_addtext').on('click', function () {
      $('#leftLayoutContainer .message').text('');
      var e = new fabric.IText('Abc', {
        fill: '#000',
        stroke: '#000',
        fontSize: f,
      });
      return (
        t.add(e),
        e.scaleToWidth(t.get('width') / 2),
        e.viewportCenter().setCoords(),
        t.setActiveObject(e),
        t.renderAll(),
        !1
      );
    }),
    $('#reviewModal').on('show.bs.modal', function () {
      t.discardActiveObject(), t.renderAll();
      var e = $('#reviewModal .shirtdesign'),
        o = $('#reviewModal .shirt');
      e
        .find('img')
        .attr(
          'src',
          t.toDataURL({
            format: 'png',
            multiplier: Math.ceil(1e4 / ((k() * f) / 250)) / 1e4,
          })
        ),
        o.find('img').attr('src', $('#img_shirt').attr('src')),
        e.width(250),
        o.width((250 * n) / c),
        $('#reviewModal .modal-body').height(o.width()),
        e.css('margin-top', (d * o.width()) / n);
    }),
    navigator.userAgent.match(/iPhone|iPad|iPod/i) &&
      $('.modal').on('show.bs.modal', function () {
        $(this).css({
          position: 'absolute',
          marginTop: $(window).scrollTop() + 'px',
          bottom: 'auto',
        });
      }),
    $.each(i, function (t, e) {
      for (t = 0; t < e.color.length; t++)
        (new Image().src =
          'images/' +
          e.filename +
          '_' +
          e.color[t].filename +
          '_front.png'),
          (new Image().src =
            'images/' +
            e.filename +
            '_' +
            e.color[t].filename +
            '_back.png');
    }),
    $('.texttoolbox', '#rightLayoutContainer').on('change', function (e) {
      var o,
        i = $(e.target);
      if (i.is('input') && i.attr('istool')) {
        switch (i.attr('istool')) {
          case 'bold':
            (o = t.getActiveObject()) &&
              o.isType('i-text') &&
              ($('#texttoolbox_bold input').prop('checked')
                ? o.set('fontWeight', 'bold')
                : o.set('fontWeight', 'normal'),
              t.renderAll());
            break;
          case 'italic':
            !(function () {
              var e = t.getActiveObject();
              e &&
                e.isType('i-text') &&
                ($('#texttoolbox_italic input').prop('checked')
                  ? e.set('fontStyle', 'italic')
                  : e.set('fontStyle', 'normal'),
                t.renderAll());
            })();
            break;
          case 'underline':
            !(function () {
              var e = t.getActiveObject();
              e &&
                e.isType('i-text') &&
                ($('#texttoolbox_underline input').prop('checked')
                  ? e.set('underline', !0)
                  : e.set('underline', !1),
                t.renderAll());
            })();
            break;
          case 'strikethrough':
            !(function () {
              var e = t.getActiveObject();
              e &&
                e.isType('i-text') &&
                ($('#texttoolbox_strikethrough input').prop('checked')
                  ? e.set('linethrough', !0)
                  : e.set('linethrough', !1),
                t.renderAll());
            })();
            break;
          case 'edit':
            !(function () {
              var e = t.getActiveObject();
              e &&
                e.isType('i-text') &&
                ($('#texttoolbox_edit input').prop('checked')
                  ? e.enterEditing()
                  : e.exitEditing(),
                t.renderAll());
            })();
        }
        return !1;
      }
    }),
    $('#btnDownloadDesign').on('click', function (e) {
      var o = document.createElement('a');
      (o.href = t.toDataURL({
        format: 'png',
        multiplier: Math.ceil(1e4 / ((k() * f) / 250)) / 1e4,
      })),
        (o.download = 'download.png'),
        (o.style.display = 'none'),
        document.body.appendChild(o),
        o.click(),
        document.body.removeChild(o),
        e.preventDefault();
    }),
    $('#btnDownloadShirt').on('click', function (e) {
      var o = n / (n + 30);
      mergeImages([
        { src: $('#img_shirt').attr('src'), x: 0, y: 0 },
        {
          src: t.toDataURL({
            format: 'png',
            multiplier: Math.ceil(1e4 / (((k() * f) / 250) * o)) / 1e4,
          }),
          x: (n + 30 - 250 / o) / 2,
          y: d / o,
        },
      ]).then(function (t) {
        var e = document.createElement('a');
        (e.href = t),
          (e.download = 'download.png'),
          (e.style.display = 'none'),
          document.body.appendChild(e),
          e.click(),
          document.body.removeChild(e);
      }),
        e.preventDefault();
    });


    let currentNumber = 1 

    $("#increase").click(function() {
        currentNumber++; 
        $("#number").text(currentNumber); 
    });

    $("#decrease").click(function() {
        currentNumber--; 
        $("#number").text(currentNumber); 
    });


    $('.size span').on('click', function() {
      $(this).siblings().removeClass('active');
      
      $(this).addClass('active');
    });

    $('.material span').on('click', function() {
      $(this).siblings().removeClass('active');
      
      $(this).addClass('active');
    });
    

});
