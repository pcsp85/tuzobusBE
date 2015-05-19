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

		$('#save_dates form').submit(function (e){
			e.preventDefault();
			f = $(this);
			f.find('.alert-box').detach();
			if(!f.find('input[name="begin_date"]').val() || !f.find('input[name="end_date"]').val()){
				f.find('.modal-body').append('<div class="alert alert-box">No hay datos para guardar</div>');
			}else{
				f.find('.loading').show();
				var args = f.serializeArray();
				args[args.length] = {name:'action', value:'save_dates'};
				$.getJSON(var_root+'ajax.php', args, function (data){
					if(data.result=='success'){
						f.find('.modal-body').append('<div class="alert alert-success alert-box">'+data.message+'</div>');
						setTimeout(function(){
							$('#save_dates').modal('hide');
						}, 1000);
					}else{
						f.find('.modal-body').append('<div class="alert alert-box">'+data.message+'</div>');
					}
					f.find('.loading').hide();
				});
			}

		});

		$('#save_dates').on('hidden', function (){
			$(this).find('.alert-box').detach();
			$.getJSON(var_root+'ajax.php',{action:'get_dates'}, function (data){
				$('#begin_date').html(data.begin_date);
				$('#end_date').html(data.end_date);
			});
		});

		$('.stores form').submit(function (e){
			e.preventDefault();
			f = $(this);
			f.find('.alert-box').detach();
			if(!f.find('input[name="store"]').val() || !f.find('input[name="rank"]').val()){
				f.find('legend').after('<div class="alert alert-box">No hay datos para guardar</div>');
			}else{
				f.find('.loading').show();
				var args = f.serializeArray();
				args[args.length] = {name:'action', value:'save_store'};
				$.getJSON(var_root+'ajax.php', args, function (data){
					if(data.result=='success'){
						f.find('legend').after('<div class="alert alert-success alert-box">'+data.message+'</div>');
					}else{
						f.find('legend').after('<div class="alert alert-box">'+data.message+'</div>');
					}
					f.find('.loading').hide();
				});
			}
		});

		$('.invitaciones form.form-search').submit(function (e){
			e.preventDefault();
		});
		$('.invitaciones .pagination a').click(function (e){
			e.preventDefault();
			$('.invitaciones form.form-search .loading').show();
			$.post(var_root+'ajax.php', {action:'invitations',npag:$(this).attr('href'),search:$('.invitaciones form.form-search input').val()}, function(data){
				$('.invitaciones').html(data);
			});
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