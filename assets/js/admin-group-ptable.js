;(function($){
    $(document).ready(function(){
        /**
         * Group product table show/hide
         * 
         * @author Fazle Bari
         */
        var $table_on_off = $('#wpt_group_table_on_off').is(':checked');
         
        if($table_on_off){
           $('.wpt_group_table').hide();
        }
        
        $(document.body).on('change','#wpt_group_table_on_off',function(){
           var $table_on_off = $(this).is(':checked');
           if($table_on_off){
               $('.wpt_group_table').fadeOut();
            }else{
               $('.wpt_group_table').fadeIn();
            }
       });

      }
    );
})(jQuery);