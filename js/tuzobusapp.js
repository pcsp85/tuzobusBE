/* Srciopt pra Tuzobus App */

var TB = function (){

	var init = function (){
		$('#change_password form').submit(function (e){
			e.preventDefault();
			if($('#change_password .modal-body .alert-box').length > 0) $('#change_password .modal-body .alert-box').detach();
			
			if(!$(this).find('input[name="user_password"]').val() || !$(this).find('input[name="user_password_new"]').val() || !$(this).find('input[name="user_password_new"]').val()){
				$('#change_password .modal-body').append('<div class="alert alert-box">Todos los campos son abligatorios</div>');
			}else if($(this).find('input[name="user_password"]').val() == $(this).find('input[name="user_password_new"]').val()){
				$('#change_password .modal-body').append('<div class="alert alert-box">La contraseña nueva es igual a la actual</div>');
			}else if($(this).find('input[name="user_password_repeat"]').val() != $(this).find('input[name="user_password_new"]').val()){
				$('#change_password .modal-body').append('<div class="alert alert-box">La nueva contraseña no coincide</div>');
			}else{
				$('#change_password .loading').show();
				var args = $(this).serializeArray();
				args[args.length] = {name:'action', value:'change_password'}
				$.getJSON(var_root+'ajax.php', args, function (data){
					if(data.result=='success'){
						$('#change_password .modal-body').append('<div class="alert alert-success alert-box">'+data.message+'</div>');
						$('#change_password').modal('hide');
					}else if(data.result == 'error'){
						$('#change_password .modal-body').append('<div class="alert alert-box">'+data.message+'</div>');
					}
					$('#change_password .loading').hide();
				});
			}
		});
		$('#change_password').on('hidden', function (){
			if($('#change_password .modal-body .alert-box').length > 0) $('#change_password .modal-body .alert-box').detach();
		});
	};

	return {
		init: function(){
			init();
		}
	};
}();

$(document).ready(function (){
	TB.init();
});