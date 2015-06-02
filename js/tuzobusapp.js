/* Srciopt pra Tuzobus App */

var TB = function (){
	var image = null;
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

		$('form.form-search input[name="search"]').on("change", function(){
			$(this).parent().parent().find('input[name="npag"]').val(1);
		});

		$('.pagination a').click(function (e){
			e.preventDefault();
			var a = $(this), f = $('form.form-search');
			f.find('input[name="npag"]').val($(this).attr('href'));
			f.submit();
		});

		//Funcion Activa formulario para crear elementos
		$('a.create').click(function (e){
			var m = $('#CU_form'), f = $('#CU_form form');
			f.find('input[name="action"]').val('createItem');
			m.find('h3 span').html('Crear');
		});
		//Funcion Activa formulario para editar elementos
		$('a.edit').click(function (e){
			var m = $('#CU_form'), f = m.find('form'), row = $(this).parent().siblings();
			f.find('input[name="action"]').val('updateItem')
			m.find('h3 span').html('Editar');
			$(row).each(function (i,el){
			  var col = $(el).attr('data-col');
			  if(col=='image'){
			  	$('#select_image').html($(el).find('img'));
			  }else{
			  	f.find('input[name="'+col+'"]').val($(el).text());
			  }
				
			});
			var pub = f.find('input[name="publish"]').val();
			f.find('button.publish[data-pub="'+pub+'"]').addClass('active').siblings('button').removeClass('active');
		});
		//Botón de publicación
		$('button.publish').click(function (e){
			e.preventDefault();
			$('input[name="publish"]').val($(this).attr('data-pub'));
		});
		//Restabeciendo formulario al ocultar
		$('#CU_form').on('hidden', function(){
			$(this).find('form').get(0).reset();
			$('input[name="publish"]').val('Si');
			$('button.publish[data-pub="Si"]').addClass('active').siblings('button').removeClass('active');
			$('#select_image').html('Da clic aquí para seleccionar o arrastra la imagen del anuncio').removeClass('alert').removeClass('alert-success').removeClass('alert-box');
			$(this).find('.modal-body .alert.response').detach();
		});
		//Función VAlidacion y envio de datos para guardar elementos
		$('#CU_form form').submit(function (e){
			e.preventDefault();
			res = $(this).find('.modal-body');
			$(this).find('.modal-body .alert.response').detach();
			var err = '';
			if($('#select_image').length>0 && $(this).find('input[name="action"]').val()=='createItem' && image == null) err += '<li>Desbes agragar una imagen para el anuncio';

			if(err==''){
				data = new FormData();
				$(this).find('input:not([type=file])').each(function (i,e){
					data.append($(e).attr('name'), $(e).val());
				});
				if(image!=null && image!=undefined) data.append('image', image[0]);
				var button = $(this).find('button.btn-primary');
				button.attr('disabled', true).before('<img src="'+var_root+'img/ajax-loader.gif"> ');
				$.ajax({
					url: var_root+'ajax.php',
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST',
					success: function (data){
						data = JSON.parse(data);
						if(data.result=="success"){
							res.append('<div class="span12 alert alert-success response">'+data.message+'</div>');
							setTimeout(function (){
								$('#CU_form').modal('hide');
							}, 1500);
						}else if(data.result=='error'){
							res.append('<div class="span12 alert alert-box response">'+data.message+'</div>');
						}
						button.attr('disabled', false).prev('img').detach();
					}
				});
			}else{
				res.append('<div class="span11 alert alert-box response"><ul>'+err+'</ul></div>');
			}
		});
		//Funcion Solicitar confirmacion para elimiar elemento
		$('a.delete').click(function (e){
			var id = $(this).parent().siblings('td[data-col="id"]').html(), title = $(this).parent().siblings('td[data-col="title"]').html() || $(this).parent().siblings('td[data-col="code"]').html();
			$('#delete .modal-body p strong').html(title);
			$('#delete .deleteConfirmation').attr('data-deleteId', id);
		});
		//funcion Elimiar elemento
		$('button.deleteConfirmation').click(function (e){
			var button = $(this);
			button.prev('img').detach();
			button.parent().prev().find('.alert').detach();
			button.attr('disabled',true).before('<img src="'+var_root+'img/ajax-loader.gif">');
			$.getJSON(var_root+'ajax.php',{action:'deleteItem', id:button.attr('data-deleteId'), table:button.attr('data-deleteTable')}, function (data){
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

		$('#select_image').click(function (e){
			$('input[type="file"][name="image"]').click();
		});
		$('#select_image').on('dragover', function (e){
			e.stopPropagation();
			e.preventDefault();
			$(this).addClass('hover');
		});
		$('#select_image').on('dragleave', function (e){
			e.stopPropagation();
			e.preventDefault();
			$(this).removeClass('hover');
		});
		document.getElementById('select_image').addEventListener("drop", loadImage, false);
		
		$('input[type=file]').on('change',function (e){
			loadImage(e);
		});

	};
	var loadImage = function (e){
		e.stopPropagation();
		e.preventDefault();
		$('#select_image').removeClass('hover').removeClass('alert').removeClass('alert-success').removeClass('alert-box');
		//Cargar imagen
		image = e.target.files || e.dataTransfer.files;
		console.log(image);
		if(image[0].type=='image/jpg' || image[0].type=='image/jpeg' || image[0].type=='image/png' || image[0]=='image/gif'){
			var img = document.createElement('img');
			img.file = image[0];
			var reader = new FileReader();
			reader.onload = (function (aImg){ return function (e){ aImg.src = e.target.result; }; })(img);
			reader.readAsDataURL(image[0]);
			$('#select_image').html('').addClass('alert alert-success').append(img);
		}else{
			$('#select_image').addClass('alert alert-box').html('Solo se permiten imágenes');
			image = null;
		}
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