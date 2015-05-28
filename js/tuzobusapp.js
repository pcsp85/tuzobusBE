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
			var a = $(this);
			$('.invitaciones form.form-search .loading').show();
			$.post(var_root+'ajax.php', {action:'invitations',npag:$(this).attr('href'),search:$('.invitaciones form.form-search input').val(), format:'html'}, function(data){
				$('.invitaciones .response').html($($(data)[2]).html());
				$('.invitaciones form.form-search .loading').hide();
				a.parent().addClass('active').siblings().removeClass('active');
			});
		});

		//Funcion Activa formulario para crear elementos
		$('a.create').click(function (e){
			var m = $('#CU_form'), f = $('#CU_form form');
			m.find('h3 span').html('Crear');
		});
		//Funcion Activa formulario para editar elementos
		$('a.edit').click(function (e){
			var m = $('#CU_form'), f = m.find('form'), row = $(this).parent().siblings();
			m.find('h3 span').html('Editar');
			$(row).each(function (i,el){
			  var col = $(el).attr('data-col');
			  if(col!='image'){
			  	f.find('input[name="'+col+'"]').val($(el).text());
			  }
				
			});
		});
		//Resstabeciendo formulario al ocultar
		$('#CU_form').on('hidden', function(){
			$(this).find('form').get(0).reset();
		});
		//Funcion Solicitar confirmacion para elimiar elemento
		$('a.delete').click(function (e){
			var id = $(this).parent().siblings('td[data-col="id"]').html(), title = $(this).parent().siblings('td[data-col="title"]').html();
			$('#delete .modal-body p strong').html(title);
			$('#delete .deleteConfirmation').attr('data-deleteId', id);
		});
		//funcion Elimiar elemento
		$('button.deleteConfirmation').click(function (e){
			var button = $(this);
			button.prev('img').detach();
			button.parent().prev().find('.alert').detach();
			button.attr('disabled',true).before('<img src="'+var_root+'img/ajax-loader.gif">');
			$.getJSON(var_root+'ajax.php',{action:'deleteItem', id:button.attr('data.deleteId'), table:button.attr('data.deleteTable')}, function (data){
				if(data.result=="error"){
					button.parent().prev().append('<div class="alert alert-box">'+data.message+'</div>');
				}else if(data.result=='success'){
					button.parent().prev().append('<div class="alert alert-success">'+data.message+'</div>');
				} 
				button.attr('disabled',false).prev('img').detach();
			});
		});
		//Formateando al ocultar
		$('#delete').on('hidden', function (){
			$(this).find('.alert').detach();
		});


		$('input[name="select-image"]').click(function (e){
			$(this).parent().find('input[type=file]').click();
		});
		$('input[type=file]').on('change',function (){
			$(this).parent().prev().val($(this).val());
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