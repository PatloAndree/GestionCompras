@extends('layouts/contentLayoutMaster')
@section('title', 'Mensajes')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
@endsection

@section('content')
	<div class="chat-application">
		<div class="content-overlay"></div>
		<div class="header-navbar-shadow"></div>
		<div class="content-area-wrapper container-xxl p-0">
			<div class="sidebar-left">
				<div class="sidebar">
					<!-- Chat Sidebar area -->
					<div class="sidebar-content">
						<span class="sidebar-close-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
								<line x1="18" y1="6" x2="6" y2="18"></line>
								<line x1="6" y1="6" x2="18" y2="18"></line>
							</svg>
						</span>
						<!-- Sidebar Users start -->
						<div id="users-list" class="chat-user-list-wrapper list-group ps ps--active-y">
							<h4 class="chat-list-title">Chats</h4>
							<ul class="chat-users-list chat-list media-list">
								@if (count($chats)>0)
									@foreach ($chats as $chat)
										<li class="chat-disponible" data-name="{{$chat['usuario']['name'].' '.$chat['usuario']['last_name']}}" data-userid="{{$chat['usuario']['id']}}">
											<span class="avatar d-none"><img src="../../../app-assets/images/portrait/small/avatar-s-3.jpg" height="42" width="42" alt="Generic placeholder image">
											<span class="avatar-status-offline"></span>
											</span>
											<div class="chat-info flex-grow-1">
												<h5 class="mb-0">{{$chat['usuario']['name'].' '.$chat['usuario']['last_name']}}</h5>
												<p class="card-text text-truncate">
													{{strip_tags($chat['mensaje']['mensaje'])}}
												</p>
											</div>
											<div class="chat-meta text-nowrap">
												<small class="float-end mb-25 chat-time">{{$chat['mensaje']['hora']}}</small>
												@if ($chat['mensaje']['cantidad']>0)
													<br>
													<span class="badge bg-danger rounded-pill float-end">{{$chat['mensaje']['cantidad']}}</span>
												@endif
												
											</div>
										</li>
									@endforeach
								@else
									<li>
										<h6 class="mb-0">No Chats Found</h6>
									</li>
								@endif
								
							</ul>
							<h4 class="chat-list-title">Usuarios</h4>
							<ul class="chat-users-list contact-list media-list">
								@foreach ($usuarios as $usuario)
									<li data-name="{{$usuario->name.' '.$usuario->last_name}}" data-userid="{{$usuario->id}}">
										<span class="avatar d-none"><img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" height="42" width="42" alt="Generic placeholder image">
										</span>
										<div class="chat-info">
											<h5 class="mb-0">{{$usuario->name.' '.$usuario->last_name}}</h5>
										</div>
									</li>
								@endforeach
							</ul>
							<div class="ps__rail-x" style="left: 0px; bottom: -106px;">
								<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
							</div>
							<div class="ps__rail-y" style="top: 106px; height: 789px; right: 0px;">
								<div class="ps__thumb-y" tabindex="0" style="top: 94px; height: 695px;"></div>
							</div>
						</div>
						<!-- Sidebar Users end -->
					</div>
					<!--/ Chat Sidebar area -->
				</div>
			</div>
			<div class="content-right">
				<div class="content-wrapper container-xxl p-0">
					<div class="content-header row"></div>
					<div class="content-body">
						<div class="body-content-overlay"></div>
						<!-- Main chat area -->
						<section class="chat-app-window">
							<!-- To load Conversation -->
							<div class="start-chat-area">
								<div class="mb-1 start-chat-icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
										<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
									</svg>
								</div>
								<h4 class="sidebar-toggle start-chat-text">Start Conversation</h4>
							</div>
							<!--/ To load Conversation -->
							<!-- Active Chat -->
							<div class="active-chat d-none">
								<!-- Chat Header -->
								<div class="chat-navbar">
									<header class="chat-header">
										<div class="d-flex align-items-center">
											<div class="avatar avatar-border user-profile-toggle m-0 me-1 d-none">
												<img  class="" src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="avatar" height="36" width="36">
												<span class="avatar-status-busy"></span>
											</div>
											<h6 class="mb-0" id="chat-user-name">Kristopher Candy</h6>
										</div>
									</header>
								</div>
								<!--/ Chat Header -->
								<!-- User Chat messages -->
								<div class="user-chats ps">
									<div class="chats">
										
									</div>
									<div class="ps__rail-x" style="left: 0px; bottom: 0px;">
										<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
									</div>
									<div class="ps__rail-y" style="top: 0px; right: 0px;">
										<div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
									</div>
								</div>
								<!-- User Chat messages -->
								<!-- Submit Chat form -->
								<form class="chat-app-form" action="javascript:void(0);" onsubmit="enterChat();">
									<div class="input-group input-group-merge me-1 form-send-message">
										<input type="text" class="form-control message" id="mensaje-send" placeholder="Escriba su mensaje">
									</div>
									<button type="button" class="btn btn-primary send waves-effect waves-float waves-light" id="btn-send-chat" onclick="enterChat();">
										<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send d-lg-none">
											<line x1="22" y1="2" x2="11" y2="13"></line>
											<polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
										</svg>
										<span class="d-none d-lg-block">Enviar</span>
									</button>
								</form>
								<!--/ Submit Chat form -->
							</div>
							<!--/ Active Chat -->
						</section>
						<!--/ Main chat area -->
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script>
	'use strict';
var sidebarToggle = $('.sidebar-toggle'),
	overlay = $('.body-content-overlay'),
	sidebarContent = $('.sidebar-content');

// Chat sidebar toggle
function sidebarToggleFunction() {
	if (sidebarToggle.length) {
		sidebarToggle.on('click', function () {
			sidebarContent.addClass('show');
			overlay.addClass('show');
		});
	}
}
$(function () {
	//chat-users-list contact-list media-list
	var chatUsersListWrapper = $('.chat-application .chat-user-list-wrapper'),
		profileSidebar = $('.chat-application .chat-profile-sidebar'),
		profileSidebarArea = $('.chat-application .profile-sidebar-area'),
		profileToggle = $('.chat-application .sidebar-profile-toggle'),
		userProfileToggle = $('.chat-application .user-profile-toggle'),
		userProfileSidebar = $('.user-profile-sidebar'),
		statusRadio = $('.chat-application .user-status input:radio[name=userStatus]'),
		userChats = $('.user-chats'),
		chatsUserList = $('.chat-users-list'),
		chatList = $('.chat-list'),
		contactList = $('.contact-list'),
		closeIcon = $('.chat-application .close-icon'),
		sidebarCloseIcon = $('.chat-application .sidebar-close-icon'),
		menuToggle = $('.chat-application .menu-toggle'),
		speechToText = $('.speech-to-text'),
		chatSearch = $('.chat-application #chat-search');

	if (!$.app.menu.is_touch_device()) {
		// Chat user list
		if (chatUsersListWrapper.length > 0) {
			var chatUserList = new PerfectScrollbar(chatUsersListWrapper[0]);
		}

		// Admin profile left
		if (userProfileSidebar.find('.user-profile-sidebar-area').length > 0) {
			var userScrollArea = new PerfectScrollbar(userProfileSidebar.find('.user-profile-sidebar-area')[0]);
		}

		// Chat area
		if (userChats.length > 0) {
			var chatsUser = new PerfectScrollbar(userChats[0], {
				wheelPropagation: false
			});
		}

		// User profile right area
		if (profileSidebarArea.length > 0) {
			var user_profile = new PerfectScrollbar(profileSidebarArea[0]);
		}
	}

	// Chat Profile sidebar & overlay toggle
	if (profileToggle.length) {
		profileToggle.on('click', function () {
			profileSidebar.addClass('show');
			overlay.addClass('show');
		});
	}

	// Update status by clicking on Radio
	if (statusRadio.length) {
		statusRadio.on('change', function () {
			var $className = 'avatar-status-' + this.value,
				profileHeaderAvatar = $('.header-profile-sidebar .avatar span');
			profileHeaderAvatar.removeClass();
			profileToggle.find('.avatar span').removeClass();
			profileHeaderAvatar.addClass($className + ' avatar-status-lg');
			profileToggle.find('.avatar span').addClass($className);
		});
	}

	// On Profile close click
	if (closeIcon.length) {
		closeIcon.on('click', function () {
			profileSidebar.removeClass('show');
			userProfileSidebar.removeClass('show');
			if (!sidebarContent.hasClass('show')) {
				overlay.removeClass('show');
			}
		});
	}

	// On sidebar close click
	if (sidebarCloseIcon.length) {
		sidebarCloseIcon.on('click', function () {
			sidebarContent.removeClass('show');
			overlay.removeClass('show');
		});
	}

	// User Profile sidebar toggle
	if (userProfileToggle.length) {
		userProfileToggle.on('click', function () {
			userProfileSidebar.addClass('show');
			overlay.addClass('show');
		});
	}

	// On overlay click
	if (overlay.length) {
		overlay.on('click', function () {
			sidebarContent.removeClass('show');
			overlay.removeClass('show');
			profileSidebar.removeClass('show');
			userProfileSidebar.removeClass('show');
		});
	}

	// auto scroll to bottom of Chat area
	chatsUserList.find('li').on('click', function () {
		chatsUserList.find('li').removeClass('active');
		$(this).addClass('active');
		var botonList = $(this);
		var userID = $(this).data('userid');
		var name = $(this).data('name');
		var v_token = "{{ csrf_token() }}";
		var method = 'GET';
		$.ajax({
			url: "{{route('mensajes.chat')}}/" + userID,
			type: "GET",
			data: { _token: v_token, _method: method },
			dataType: 'json',
			success: function (obj) {
				var badge=botonList.find('span.badge');
				if(badge.length>0){
					badge.remove();
				}
				var menssages = obj.mensajes;
				$("#chat-user-name").html(name);
				printMessages(menssages);
				$('.start-chat-area').addClass('d-none');
				$('.active-chat').removeClass('d-none');
				userChats.animate({ scrollTop: userChats[0].scrollHeight }, 400);
				$("#btn-send-chat").data('chatid',obj.chat_id);
				$("#btn-send-chat").data('userid',userID);
			}
		});
	});

	// Main menu toggle should hide app menu
	if (menuToggle.length) {
		menuToggle.on('click', function (e) {
			sidebarContent.removeClass('show');
			overlay.removeClass('show');
			profileSidebar.removeClass('show');
			userProfileSidebar.removeClass('show');
		});
	}

	if ($(window).width() < 992) {
		sidebarToggleFunction();
	}

});
// Window Resize
$(window).on('resize', function () {
	sidebarToggleFunction();
	if ($(window).width() > 992) {
		if ($('.chat-application .body-content-overlay').hasClass('show')) {
			$('.app-content .sidebar-left').removeClass('show');
			$('.chat-application .body-content-overlay').removeClass('show');
		}
	}

	// Chat sidebar toggle
	if ($(window).width() < 991) {
		if (
			!$('.chat-application .chat-profile-sidebar').hasClass('show') ||
			!$('.chat-application .sidebar-content').hasClass('show')
		) {
			$('.sidebar-content').removeClass('show');
			$('.body-content-overlay').removeClass('show');
		}
	}
});

// Add message to chat - function call on form submit
function enterChat(source) {
	var message = $('#mensaje-send').val();
	var v_token = "{{ csrf_token() }}";
	var method = 'POST';
	var userid = $("#btn-send-chat").data('userid');
	var chatid = $("#btn-send-chat").data('chatid');
	if(message.length>0){
		$.ajax({
			url: "{{route('mensajes.send')}}",
			type: "POST",
			data: { _token: v_token, _method: method,userid:userid,chatid:chatid,message:message},
			dataType: 'json',
			success: function (obj) {
				var htmlChat = '';
				if(obj.sw_error==1){
					Swal.fire({
						position: "center",
						icon: "warning",
						title: "Atención",
						text: 'Ocurrio un problema, intentelo nuevamente.',
						showConfirmButton: false,
						timer: 2500
					});
				}else{
					htmlChat += `<div class="chat">
						<div class="chat-body">
							<div class="chat-content">
								${message}
							</div>
						</div>
					</div>`;
					$('#mensaje-send').val('');
					$(".chats").append(htmlChat);
					$('.user-chats').animate({ scrollTop: $('.user-chats')[0].scrollHeight }, 400);
				}
			}
		});
	}
	
	/*if (/\S/.test(message)) {
		var html = '<div class="chat-content">' + '<p>' + message + '</p>' + '</div>';
		$('.chat:last-child .chat-body').append(html);
		$('.message').val('');
		$('.user-chats').scrollTop($('.user-chats > .chats').height());
	}*/
}
function printMessages(messages) {
	var htmlChat = '';
	var fecha = '';
	messages.forEach(element => {
		if(element.created_at!=fecha){
			fecha=element.created_at;
			htmlChat += `<div class="divider"><div class="divider-text">${fecha}</div></div>`;
		}
        var mensaje = element.mensaje;
		htmlChat += `<div class="chat ${(element.tipo==2) ? 'chat-left':''}">
						<div class="chat-body">
							<div class="chat-content">
								${mensaje.replace("\n", "<br>")}
							</div>
						</div>
					</div>`;

		/*if(fecha!=)*
		htmlChat += ``;*/
	});
	
	$(".chats").html(htmlChat);
}
</script>
@endsection