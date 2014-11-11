<?php

function add_at_js_users_to_meta( $comment_ID, $comment_approved ){
	// выходим если комментарий не одобрен
	if( $comment_approved == 0 )
		return;
		
	$comment = get_comment( $comment_ID );
	$post = get_post( $comment->comment_post_ID );
	$user = get_userdata( $post->post_author );
	

	$content_for_serach = $comment->comment_content;
	//Массив для ID пользователей, которых нужно уведомить
	$users_ids_for_comment_meta = array();
	
	// Разбиваем текст по пробелам на слова и добавляем в массив
	$content_words = explode(" ", $content_for_serach);

	
	//Проверем наличия символа @ в начале слова, если есть, то добавляем ид этого пользователя в массив
	foreach ($content_words as $value) {
		$rest = substr($value, 0, 1);
		if ($rest === '@') {			
			//Добавляем массив с ИД'шниками для уведомления по почте в мету коммента
			$user = get_user_by('login', substr($value, 1));
			if(isset($user->ID)) add_metadata('comment', $comment_ID, 'users_mention_cp', $user->ID, false);
		}
	}
	
}

add_action( 'comment_post', 'add_at_js_users_to_meta', 10, 2 );
