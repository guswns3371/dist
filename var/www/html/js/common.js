$(document).ready(function(){

    $("#rep_bt2").click(function(){
        var params = $("form").serialize();
        $.ajax({
            type: 'post',
            url: 'community_reply_ok.php?=<?php echo $board["comm_num"]; ?>',
            data : params,
            dataType : 'html',
            success: function(data){
                console.error("/".data);
                if (data == 0){
                    alert("댓글을 입력하세요");
                } else {
                    $(".reply_view").html(data);
                    $(".form-control").val('');
                }

            }
        });
    });
    //
    $(".dat_edit_bt").click(function(){
        /* dat_edit_bt클래스 클릭시 동작(댓글 수정) */

        var obj = $(this).closest(".dap_lo").find(".dat_edit");
        obj.dialog({
            modal:true,
            width:650,
            height:200,
            title:"댓글 수정"});
    });
    //
    $(".dat_delete_bt").click(function(){
        /* dat_delete_bt클래스 클릭시 동작(댓글 삭제) */
        dialog_del.dialog("open");
        // var obj = $(this).closest(".dap_lo").find(".dat_delete");
        // obj.dialog({
        //     modal:true,
        //     width:400,
        //     title:"댓글 삭제확인"});
        // var r = confirm("댓글을 sdf삭제 하시겠습니까?");
        // if (r == true) {
        //
        // } else {
        //
        // }

    });
    //
    dialog_del = $( ".dat_delete" ).dialog({
        autoOpen: false,
        height: 400,
        width: 400,
        modal: true,
        // buttons: {
        //     "Create an account": addUser,
        //     Cancel: function() {
        //         dialog.dialog( "close" );
        //     }
        // },
        // close: function() {
        //     form[ 0 ].reset();
        //     allFields.removeClass( "ui-state-error" );
        // }
       // title:"댓글 삭제확인"
    });
});