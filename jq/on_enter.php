<script>
    $('.on_enter').on('keydown', 'input, select',function(e){
        if(e.key  === "Enter") {
            var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
            focusable = form.find('input,a,select,button,textarea').filter(':visible');
            next = focusable.eq(focusable.index(this)+1);
            if(next.length){
                next.focus();
            }else{
                form.submit();
            }
            return false;
        }
    })
</script>    