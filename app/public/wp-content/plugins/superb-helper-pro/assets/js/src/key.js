jQuery(function ($) {
    $(document).ready(function () {
        deleteBtnsRefresh();

        function deleteBtnsRefresh(){
            $(".spbhlprpro-key-btn-remove").off();
            $(".spbhlprpro-key-btn-remove").click(function(e){
                e.preventDefault();
                const element = $(e.target);
                const previousText = element.val();
                element.val(spbhlprpro_msgs.clickAgain);
                element.off();
                var resetTimer = setTimeout(function(){
                    element.val(previousText);
                    deleteBtnsRefresh();
                },10000);
                element.click(function(){
                    loadScreen(spbhlprpro_msgs.processing);
                    clearTimeout(resetTimer);
                });
            });
        }

        $(".spbhlprpro-key-btn-unlock").click(function(){
            loadScreen(spbhlprpro_msgs.processing);
        });

        function loadScreen(loadtext){
            $("#spbhlprpro_key_page_wrapper_inner").hide();
            $("#spbhlprpro_update_load_spinner").show();
            $("#spbhlprpro_update_load_spinner_text").text(loadtext);
            $(".spbhlprpro_products_error_modal").hide();
        }

         
    });
});
