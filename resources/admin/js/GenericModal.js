var GenericModal = {
	selector: "",
	title: "",
	config: function(selector, title) {
		this.selector = selector;
		this.title    = title;
	},
	show: function(typeModal, message) {
		switch (typeModal) {
			case 'default':
                $(this.selector).removeClass('modal-danger');
                $(this.selector + ' .btn').removeClass('btn-outline');
                $(this.selector + ' .btn').addClass('btn-primary');
			break;
			case 'danger':
                $(this.selector).addClass('modal-danger');
                $(this.selector + ' .btn').addClass('btn-outline');
                $(this.selector + ' .btn').removeClass('btn-primary');
			break;
		}
        // $(this.selector + ' .modal-body').html("<p>" + message + "<p>");
		$(this.selector + ' .modal-body').html(message);
        $(this.selector).modal({keyboard: true});
		$(this.selector).modal('show');
	},
	onClickButtonAccept: function(callback) {
		$(this.selector + ' .modal-footer .btn-ok' ).on("click", function() {
			$(".skin-blue").css({"padding-right": "0px"});
			if (callback != undefined || callback != null) {
				callback();
			}
		});
	}
};