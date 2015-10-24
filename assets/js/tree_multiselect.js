/*COPYRIGHT ALLISON STONE 2013*/


<!-- MODAL TREE STRUCTURE -->

//    $("li.parent-list ul").hide(); //hide the child lists
//    $("li.parent-list span").click(function () {
//        var next_i = $(this).next("i");
//        next_i.toggleClass('icon-caret-up'); // toggle the font-awesome icon class on click
//        $(next_i).next("ul").toggle(); // toggle the visibility of the child list on click
//    });
    $("li.parent-list ul").hide(); //hide the child lists
    $(document).delegate("li.parent-list span", 'click', function () {
        var next_i = $(this).next("i");
        next_i.toggleClass('icon-caret-up'); // toggle the font-awesome icon class on click
        $(next_i).next("ul").toggle(); // toggle the visibility of the child list on click
    });

    $("span[id=expand], span[id=expand_satker]").click(function () {
        thisId = $(this).prop('id');
        
        if(thisId == 'expand') {
            $("div[id=main_ul] ul ul").toggle();
        } else if(thisId == 'expand_satker') {
            $("div[id=main_ul_satker] ul ul").toggle();
        }
    });

<!--MODAL MULTISELECT FUNCTIONALITY -->

// check-uncheck all
    $(document).on('change', 'input[id="all"], input[id="all_satker"]', function () { 
        thisId = $(this).prop('id');
        
        if(thisId == 'all') {
            $('div[id=main_ul] .canine').prop("checked", this.checked);
        } else {
            $('div[id=main_ul_satker] .canine').prop("checked", this.checked);
        }
    });

// parent/child check-uncheck all
    $(function () {
        $('.parent').on('click', function () {
            $(this).closest('ul li').find(':checkbox').prop('checked', this.checked);
        });
    });
