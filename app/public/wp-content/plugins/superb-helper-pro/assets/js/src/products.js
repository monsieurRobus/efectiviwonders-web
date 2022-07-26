jQuery(function ($) {
    $(document).ready(function () {
        $("#spbhlprpro_products_update_notification_modal").remove();

        $(".spbhlprpro_update_data_btn:not(.spbhlprpro_update_data_btn)").click(function(){
            loadScreen(spbhlprpro_msgs.checkingForUpdates);
            $(".spbhlprpro_customer_products_wrapper").remove();
        });

        $(".spbhlprpro_customer_products_item_cta:not(.spbhlprpro_customer_products_item_cta_expired) .spbhlprpro_customer_products_item_cta_button:not(.spbhlprpro_customer_products_item_cta_button_delete), .spbhlprpro_standalone_activate_btn, .spbhlprpro_customer_products_item_cta_button_activate").click(function(){
            loadScreen(spbhlprpro_msgs.processing);
        });

        $(".spbhlprpro_view_changelog_button").click(function(){
            $(this).parent().siblings(".spbhlprpro_customer_products_item_content").find(".spbhlprpro_changelog_wrapper").slideToggle();
        })

        $("#spbhlprpro-product-search").on("input", function (e) {
            e.preventDefault();
            $(".spbhlprpro_products_item_title").each(function () {
                const field = $(this).closest(".spbhlprpro_customer_products_item");
                const fieldText = field.attr("data-search").toLowerCase();
                const fieldTextSingle = field.attr("data-search-single").toLowerCase();
                const searchText = $("#spbhlprpro-product-search").val().toLowerCase();
                field.removeClass("spbhlprpro-product-search-target");
                if(searchText.length <= 2){
                    field.show();
                    return;
                }
                if(fieldTextSingle.includes(searchText)){
                    field.addClass("spbhlprpro-product-search-target");
                }
                if (fieldText.includes(searchText)) {
                    field.show();
                } else {
                    field.hide();
                }
            });
        });

        deleteBtnsRefresh();

        function deleteBtnsRefresh(){
            $(".spbhlprpro_customer_products_item_cta_button_delete").off();
            $(".spbhlprpro_customer_products_item_cta_button_delete").click(function(e){
                e.preventDefault();
                const element = $(e.target);
                const previousText = element.text();
                element.text(spbhlprpro_msgs.clickAgain);
                element.off();
                var resetTimer = setTimeout(function(){
                    element.text(previousText);
                    deleteBtnsRefresh();
                },10000);
                element.click(function(){
                    loadScreen(spbhlprpro_msgs.processing);
                    clearTimeout(resetTimer);
                });
            });
        }

       $(".spbhlprpro_customer_products_item_cta_button_expired").click(function(){
        $("#spbhlprpro_update_load_spinner").show();
        $(".spbhlprpro_update_data_btn").show();
        $(".spbhlprpro_products_error_modal").hide();
        $(".spbhlprpro_products_success_modal").hide();
        $(".spbhlprpro_information_notification").text(spbhlprpro_msgs.info_order)
        $("#spbhlprpro_update_load_spinner_text").text(spbhlprpro_msgs.waiting);
        $(".spbhlprpro_customer_products_wrapper").remove();
       });

       $(".spbhlprpro_update_data_btn").click(function(){
            loadScreen(spbhlprpro_msgs.processing);
            location.reload();
       });

        function loadScreen(loadtext){
            $("#spbhlprpro_update_load_spinner").show();
            $("#spbhlprpro_update_load_spinner_text").text(loadtext);
            $(".spbhlprpro_products_error_modal").hide();
            $(".spbhlprpro_products_success_modal").hide();
            $(".spbhlprpro_update_data_wrapper.spbhlprpro_update_data_update_notification .spbhlprpro_update_data_btn").hide();
            $(".spbhlprpro_update_data_wrapper.spbhlprpro_update_data_update_notification span:not(#spbhlprpro_update_load_spinner_text)").hide();
            $(".spbhlprpro_customer_products_wrapper").hide();
            $(".spbhlprpro_update_data_btn").hide();
        }

        const dateNow = new Date(Date.parse($("#spbhlprpro_update_time").data("now")));
        const dateUpdate = Date.parse($("#spbhlprpro_update_time").data("time"));

        setInterval(function(){
            $("#spbhlprpro_update_time").text(timeSince());
        },1000);

        function timeSince() {
            if(isNaN(dateNow.getTime()) || isNaN(dateUpdate))
                return;

            var seconds = Math.floor((dateNow - dateUpdate) / 1000);
            var interval = seconds / 31536000;

            dateNow.setSeconds(dateNow.getSeconds()+1);
            interval = seconds / 3600;
            if (interval > 1) {
              return Math.floor(interval) + spbhlprpro_msgs.hoursAgo;
            }
            interval = seconds / 60;
            if (interval > 1) {
              return Math.floor(interval) + spbhlprpro_msgs.minutesAgo;
            }
            
            //return Math.floor(seconds) + " second(s) ago";
            return spbhlprpro_msgs.justNow;
        }        
    });
});
