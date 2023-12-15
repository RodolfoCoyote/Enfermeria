//Number Picker Plugin - TobyJ
(function ($) {
  $.fn.numberPicker = function () {
    var dis = "disabled";
    return this.filter("input")
      .each(function () {
        var input = $(this).wrap("<div></div>"),
          p = $("<button></button>").insertAfter(input),
          m = $("<button></button>").insertBefore(input),
          min = parseInt(input.attr("min"), 10),
          max = parseInt(input.attr("max"), 10),
          inputFunc = function () {
            var i = parseInt(input.val(), 10);
            if (i <= min || !i) {
              input.val(min);
              p.prop(dis, false);
              m.prop(dis, true);
            } else if (i >= max) {
              input.val(max);
              p.prop(dis, true);
              m.prop(dis, false);
            } else {
              p.prop(dis, false);
              m.prop(dis, false);
            }
          },
          changeFunc = function (qty) {
            var i = parseInt(input.val(), 10);
            if ((i < max && qty > 0) || (i > min && !(qty > 0))) {
              input.val(i + qty).change();
            }
          };
        m.on("click", function () {
          changeFunc(-1);
        });
        p.on("click", function () {
          changeFunc(1);
        });
        input
          .on("keydown", function (e) {
            switch (e.which) {
              case 38:
                changeFunc(1);
                break;
              case 40:
                changeFunc(-1);
                break;
              default:
                return;
            }
            e.preventDefault();
          })
          .parent()
          .attr("class", input.attr("class"))
          .addClass("plusminus")
          .on("change", function () {
            inputFunc();
          })
          .change(); //init
      })
      .parent();
  };
})(jQuery);

$(document).on("ready", function () {
  $('input[type="number"]').numberPicker(); //turn all input
});
