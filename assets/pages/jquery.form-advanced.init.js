/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Form Advanced
 */


jQuery(document).ready(function () {

    //advance multiselect start
    $('#my_multi_select3').multiSelect({
        selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (ms) {
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function (e) {
                    if (e.which === 40) {
                        that.$selectableUl.focus();
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function (e) {
                    if (e.which == 40) {
                        that.$selectionUl.focus();
                        return false;
                    }
                });
        },
        afterSelect: function () {
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function () {
            this.qs1.cache();
            this.qs2.cache();
        }
    });

    // Select2
    $(".select2").select2();

    $(".select2-limiting-4").select2({
        maximumSelectionLength: 4
    });

    $(".select2-limiting-3").select2({
        maximumSelectionLength: 3
    });

    // $('.selectpicker').selectpicker();
    // $(":file").filestyle({input: false});
});


// $("input[name='demo2']").TouchSpin({
//     min: -1000000000,
//     max: 1000000000,
//     stepinterval: 50,
//     maxboostedstep: 10000000,
//     prefix: '$'
// });
// $("input[name='demo3']").TouchSpin();
// $("input[name='demo3_21']").TouchSpin({
//     initval: 40
// });
// $("input[name='demo3_22']").TouchSpin({
//     initval: 40
// });

// $("input[name='demo5']").TouchSpin({
//     prefix: "pre",
//     postfix: "post"
// });
// $("input[name='demo0']").TouchSpin({});

