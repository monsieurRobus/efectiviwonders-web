jQuery(function ($) {
    $(document).ready(function () {
        $("#spbhlprpro_update_needed_buttons a").click(function(){
            loadScreen(spbhlprpro_msgs.processing);
        });

        function loadScreen(loadtext){
            $("#spbhlprpro_update_load_spinner").show();
            $("#spbhlprpro_update_load_spinner_text").text(loadtext);
            $(".spbhlprpro_products_error_modal").hide();
            $("#spbhlprpro_update_needed_buttons").hide();
        }
    });
});