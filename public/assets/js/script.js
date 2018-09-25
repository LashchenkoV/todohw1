let admin = {
    init:function () {
        this.btnAdd = $("#btnAddTodo");
        this.modalAdd = $("#addModal");
        this.tableForm = $("#tableNotes");
        this.bindEvent();
    },
    bindEvent:function () {
        this.btnAdd.on("click",this.addEvent.bind(this));
        this.bindEventTable();
    },
    bindEventTable:function(){
        $(".removeNote").on("click", function (e) {
            e.preventDefault();
            this.delEvent($(e.target).closest("tr").attr('id'));
        }.bind(this));

        $(".editNote").on("click",function (e) {
            e.preventDefault();
            this.editEvent($(e.target).closest("tr").attr('id'));
        }.bind(this));
    },
    editEvent:function(id){
        $.ajax({
            method: "POST",
            url:"/getEditForm",
            data:{id:id}
        }).done(function (html) {
            if(html.status == 0) return;
            if($("div").is("#editModal"))
                $("#editModal").replaceWith(html);
            else $("body").append(html)
            $("#editModal").modal("show");
            $("#sendEditForm").on("click",function () {
                let title =$("#title-edit").val();
                let message =$("#message-edit").val();
                $.ajax({
                    method: "POST",
                    url:"/editNote",
                    data:{id:id,title:title,message:message}
                }).done(function (html) {
                    $("#editModal").modal("hide");
                    if(html!=undefined){
                        $("#err").html(html);
                        //$("#err div").css("z-index","100").modal("show");
                        return;
                    }
                    this.getTableNote();
                }.bind(this));
            }.bind(this))
        }.bind(this));
    },
    delEvent:function(id){
        $.ajax({
            method: "POST",
            url:"/delNote",
            data:{id:id}
        }).done(function () {
            this.getTableNote();
        }.bind(this));
    },
    getTableNote:function(){
        $.ajax({
            url:"/getTableNotes",
        }).done(function (html) {
            this.tableForm.html(html);
            this.modalAdd.modal("hide");
            this.bindEventTable();
        }.bind(this))
    },
    addEvent:function () {
        let title =$("#title").val();
        let message =$("#message").val();
        $.ajax({
            url:"/addTodo",
            method:"POST",
            dataType:"JSON",
            data:{title:title,message:message},
        }).done(function (data) {
            if(data.id<0) return;
            $("#message").val("");
            $("#title").val("");
            this.getTableNote();
        }.bind(this))
    }
};
$(document).on("change","body")
document.addEventListener("load",admin.init());