/***            LOGIN                ***/
/****************************************************/

var myCoolJavascriptVariable;
var pos = 0;

const objPrincipal = {};

myCoolJavascriptVariable = window.location.href.split("/");
 
$(function() {
	/**
	 * Muestra una carga a un boton y lo desactiva
	 * @param boton
     */
	objPrincipal.botonCargando = function(boton) {
		const icon = boton.find('i.fa');
		if (icon.length) icon.hide();
		boton.prepend('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" ></span>');
		boton.prop('disabled', true);
	};
	/**
	 * Libera el boton de la carga y lo activa
	 * @param boton
     */
	objPrincipal.liberarBoton = function(boton) {
		const carga = boton.find('span.spinner-border');
		const icon = boton.find('i.fa');
		if (carga.length) carga.remove();
		if (icon.length) icon.show();
		boton.prop('disabled', false);
	}
});
 
login = function() {
	$(document).ready(function () {
		
	});

	$('#frmlogin').submit(function(event){
		event.preventDefault();
		var vcia = $('#cia').val();
		
		if(vcia == '1'){
			vcia = 'fs';
		}else if(vcia == '2'){
			vcia = 'fsc';
		}
		
		var request = $.ajax({
			url:$('#frmlogin').attr("action"),
			type:$('#frmlogin').attr("method"),
			data:$('#frmlogin').serialize(),
			error: function(){
				Vtitle = 'No se puede Acceder por Error';
				Vtype = 'error';
				sweetalert(Vtitle,Vtype); 
			}
		});	
		request.done(function( respuesta ) {
			var posts = JSON.parse(respuesta);
			if(posts.valor == -3){
				Swal.fire({
					type: 'warning',
					title: 'Usuario Bloqueado!',
					text: posts.respuesta,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Si, desbloquear!'
				}).then((result) => {
					if (result.value) {
						window.location="clogin/unlock_pass/"+vcia;
					}
				})
			}else if(posts.valor == 0){
				window.location="clogin/change_pass/"+vcia;
			}else if(posts.valor == 1){
				window.location="main";
			}else if(posts.valor == 99){
				window.location="cpanel";
			}else{
				Swal.fire({
					title:'Error de Acceso!',
					text:posts.respuesta,
					type: 'error'
				})
			}
		});
	});
};

change_pass = function() {
	$(document).ready(function () {

		$("#email").prop({readonly:true});
		$('#txtpassword').val(''); 

		var folderimage;
		var tipogenero;
		var nombresprf;
		var userlogin;
		
		var tipopsw = $('#TipoPassword').val();//$('[name=TipoPassword]');
		var pass1 = $('[name=new_password]');
		var pass2 = $('[name=conf_password]');
		var compania = $('#cia').val();//$('[name=cia]');

		var confirmacion = "Las contraseñas si coinciden";
		var longitud6 = "La contraseña debe ser mayor a 6 carácteres";
		var longitud11 = "La contraseña debe ser mayor a 11 carácteres";
		var negacion = "No coinciden las contraseñas";
		var vacio = "La contraseña no puede estar vacía";
		var sintexto = "";
		

		//oculto por defecto el elemento span
		var span1 = $('<span></span>').insertAfter(pass1);
		
		span1.hide();
		
		//función que comprueba la longitud y vacion en la clave
		function valorPassword(){
			var valor1 = pass1.val();
			var valor2 = pass2.val();
			//muestro el span
			span1.show().removeClass();
			
			//condiciones dentro de la función
			if(valor1.length==0 || valor1==""){
				span1.text(vacio).addClass('negacion');
				$("#idbtnsave").prop('disabled','disabled');	
			}else if(valor1.length<6 && tipopsw=='S'){
				span1.text(longitud6).addClass('negacion');
				$("#idbtnsave").prop('disabled','disabled');
			}else if(valor1.length<11 && tipopsw=='D'){
				span1.text(longitud11).addClass('negacion');
				$("#idbtnsave").prop('disabled','disabled');
			}else{
				span1.hide();
			}
		}
		
		//ejecuto la función al soltar la tecla	del campo de password
		pass1.keyup(function(){
			valorPassword();
		});
		
		//oculto por defecto el elemento span
		var span2 = $('<span></span>').insertAfter(pass2);
		
		span2.hide();
		
		//función que comprueba las dos contraseñas si coinciden
		function coincidePassword(){
			var valor1 = pass1.val();
			var valor2 = pass2.val();
			//muestro el span
			span2.show().removeClass();
			//condiciones dentro de la función
			if(valor1 != valor2){
				span2.text(negacion).addClass('negacion');
				$("#idbtnsave").prop('disabled','disabled');
			}
	
			if(valor1.length!=0 && valor1==valor2){
				span2.text(confirmacion).removeClass("negacion").addClass('confirmacion');
				$("#idbtnsave").prop('disabled',false);
			}
		}
		
		//ejecuto la función al soltar la tecla	del campo de confirmar clave
		pass2.keyup(function(){
			coincidePassword();
		});
	});

	$('#frmchangepwd').submit(function(event){
		event.preventDefault();
		
		var request = $.ajax({
			url:$('#frmchangepwd').attr("action"),
			type:$('#frmchangepwd').attr("method"),
			data:$('#frmchangepwd').serialize(),
			error: function(){
				Vtitle = 'No se puede Acceder por Error';
				Vtype = 'error';
				sweetalert(Vtitle,Vtype); 
			}
		});				
		request.done(function( respuesta ) {
			var posts = JSON.parse(respuesta);
			if(posts.valor == 2){		
				Swal.fire({
					title: 'Contraseña cambiada!!',
					text: posts.respuesta,
					position: 'center',
					type: 'success',
					showConfirmButton: true,
					confirmButtonText: 'Iniciar sesión'
				}).then((result) => {
					var retornar = document.getElementById('btnexit');
					retornar.click();
				})				
			}else{	
				Swal.fire({
					title: 'Error en Cambiar Contraseña!',
					text: posts.respuesta,
					type: 'error',
				})	
			}
			
		});
	});	
}

unlock_pass = function() {
	$(document).ready(function () {						
		$('#cardemail').show(); 
		$('#cardverif').hide();
				
		if($('#tipo').val()=='1'){
			$('#email').val('');
			$("#email").prop({readonly:false});
		}else if($('#tipo').val()=='2'){
			$("#email").prop({readonly:true});
		} 

		//var vcia = $('#cia').val();
		
		$('#frmrecoverpwd').validate({
			rules: {
			},
			messages: {
			},
			errorElement: 'span',
			errorPlacement: function (error, element) {
			  error.addClass('invalid-feedback');
			  element.closest('.form-group').append(error);
			},
			highlight: function (element, errorClass, validClass) {
			  $(element).addClass('is-invalid');
			},
			unhighlight: function (element, errorClass, validClass) {
			  $(element).removeClass('is-invalid');
			},        
			submitHandler: function (form) {
				const botonEvaluar = $('#idbuttongrupo');
				var request = $.ajax({
					url:$('#frmrecoverpwd').attr("action"),
					type:$('#frmrecoverpwd').attr("method"),
					data:$('#frmrecoverpwd').serialize(),
					error: function(){
						Vtitle = 'No se puede Acceder por Error';
						Vtype = 'error';
						sweetalert(Vtitle,Vtype); 
						objPrincipal.liberarBoton(botonEvaluar);
					},
					beforeSend: function() {
						objPrincipal.botonCargando(botonEvaluar);
					}
				});	
				request.done(function( respuesta ) {
					var posts = JSON.parse(respuesta);
					if(posts.valor == -6){		
						Swal.fire({
							title: 'Error en Validar Email!',
							text: posts.respuesta,
							type: 'error',
						})
					}else if(posts.valor == 3){		
						Swal.fire({
							title: 'Envio de Email!',
							text: posts.respuesta,
							position: 'center',
							type: 'success',
							showConfirmButton: false,
							timer: 4000
						}).then((result) => {
							if (result.dismiss === Swal.DismissReason.timer) {						
								$('#cardverif').show(); 
								$('#cardemail').hide();
								$('#iduser').val(posts.iduser);
								objPrincipal.liberarBoton(botonEvaluar);
							}
						})
					}					
				});
				return false;
			}
		});
		
		$('#frmverifsegu').validate({
			rules: {
			},
			messages: {
			},
			errorElement: 'span',
			errorPlacement: function (error, element) {
			  error.addClass('invalid-feedback');
			  element.closest('.form-group').append(error);
			},
			highlight: function (element, errorClass, validClass) {
			  $(element).addClass('is-invalid');
			},
			unhighlight: function (element, errorClass, validClass) {
			  $(element).removeClass('is-invalid');
			},        
			submitHandler: function (form) {
				const botonEvaluar = $('#btnSiguiente');
				var request = $.ajax({
					url:$('#frmverifsegu').attr("action"),
					type:$('#frmverifsegu').attr("method"),
					data:$('#frmverifsegu').serialize(),
					error: function(){
						Vtitle = 'No se puede Acceder por Error';
						Vtype = 'error';
						sweetalert(Vtitle,Vtype); 
						objPrincipal.liberarBoton(botonEvaluar);						
						$('#cardemail').show(); 
						$('#cardverif').hide();
						$('#frmverifsegu').trigger("reset");
					},
					beforeSend: function() {
						objPrincipal.botonCargando(botonEvaluar);
					}
				});	
				request.done(function( respuesta ) {
					var posts = JSON.parse(respuesta);
					if(posts.valor == 0){		
						Swal.fire({
							title: 'Error en Validar Codigo!',
							text: posts.respuesta,
							type: 'error',
						})
					}else if(posts.valor == 1){		
						Swal.fire({
							title: 'Codigo Validado!',
							text: posts.respuesta,
							position: 'center',
							type: 'success',
							showConfirmButton: false,
							timer: 4000
						}).then((result) => {
							if (result.dismiss === Swal.DismissReason.timer) {								
								objPrincipal.liberarBoton(botonEvaluar);
								var varcia = posts.ccia
								window.open(baseurl+"clogin/recovery_password/"+varcia,"_parent");
							}
						})
					}
					
				});
				return false;
			}
		});
	});
	
	$("#btnreturn").click(function (){   		 
		$('#cardemail').show(); 
		$('#cardverif').hide();
		$('#frmverifsegu').trigger("reset");
	});


}


switch(myCoolJavascriptVariable[5]) {
    case "unlock_pass":
		unlock_pass();
		break;
    case "recover_pass":
		unlock_pass();
		break;
    case "change_pass":
		change_pass();
		break;
    case "recovery_password":
		change_pass();
		break;
	default:
		login();
}


const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 6000
});

sweetalert = function(Vtitle,Vtype){
	Toast.fire({
	  type: Vtype,
	  title: Vtitle
	})
};


